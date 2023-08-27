<?php
namespace Lamba\Payment;

use Exception;
use Lamba\Crud\Crud;
use Lamba\Api\Api;

class Payment
{
    static $table = DEF_TBL_PAYMENTS;
    static $tablePaymentPlans = DEF_TBL_PAYMENT_PLANS;
    static $data = [];

    public static function getPaymentPlan($id, $arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$tablePaymentPlans,
            [
                'columns' => $fields,
                'where' => [
                    'id' => $id
                ]
            ]
        );
    }
    public static function getPaymentPlans($arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$tablePaymentPlans,
            [
                'columns' => $fields,
                'where' => [
                    'deleted' => 0
                ],
                'return_type' => 'all'
            ]
        );
    }
    public static function getPaymentPlansDropdown()
    {
        $rs = self::getPaymentPlans();
        $output = '';
        if ($rs)
        {
            foreach($rs as $r)
            {
                $amount = doNumberFormat($r['amount']);
                $output .= <<<EOQ
                <option value="{$r['id']}">{$r['name']} ({$amount})</option>
EOQ;
            }
        }

        return $output;
    }
    public static function makePayment()
    {
        $paymentPlanId = trim($_REQUEST['payment_plan_id']);
        $rs = self::getPaymentPlan($paymentPlanId, ['amount']);
        if ($rs)
        {
            global $userId, $arUser;

            //initiate payment
            $id = getNewId();
            $reference = getTransactionReference();
            //$amount = $rs['amount'];
            $amount = 3000;
            $data = [
                'id' => $id,
                'reference' => $reference,
                'user_id' => $userId,
                'amount' => $amount,
                'plan_id' => $paymentPlanId,
                'cdate' => time()
            ];
            if (Crud::insert(self::$table, $data))
            {
                //invoke API
                $arParams = [
                    'tx_ref' => $id,
                    'amount' => $amount,
                    'currency' => 'NGN',
                    'redirect_url' => DEF_PAYMENT_REDIRECT_URL,
                    'customer' => [
                        'email' => $arUser['email']
                    ]
                ];
                $arData = [
                    'url' => DEF_FLW_PAYMENT_URL,
                    'method' => 'POST',
                    'body' => $arParams
                ];
                $rsx = Api::invokeApiCall($arData);
                $res = json_decode($rsx, true);
                if (array_key_exists('status', $res))
                {
                    if ($res['status'])
                    {
                        if (array_key_exists('data', $res))
                        {
                            if (array_key_exists('link', $res['data']))
                            {
                                if ($res['data']['link'] != '')
                                {
                                    self::$data = [
                                        'status' => true,
                                        'data' => [
                                            'link' => $res['data']['link']
                                        ]
                                    ];
                                }
                                else
                                {
                                    self::throwPaymentError();
                                }
                            }
                            else
                            {
                                self::throwPaymentError();
                            }
                        }
                        else
                        {
                            self::throwPaymentError();
                        }
                    }
                    else
                    {
                        self::throwPaymentError();
                    }
                }
                else
                {
                    self::throwPaymentError();
                }
            }
        }
        else
        {
            self::throwPaymentError('Invalid payment plan selected!');
        }
    }
    public static function throwPaymentError($msg='')
    {
        $error = !empty($msg) ? $msg : 'An error occured while processing your payment. Please try again.';
        throw new Exception($error);
    }

    public static function getPayment($id, $arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    'id' => $id
                ]
            ]
        );
    }

    public static function verifyPayment()
    {
        $txRef = trim($_GET['tx_ref']);
        $transactionId = trim($_GET['transaction_id']);
        $status = trim($_GET['status']);
        
        //payments?status=successful&tx_ref=4434A196-7E21-6795-98B6-30DF1719D0F5&transaction_id=4556155
        if ($status == 'successful')
        {
            //verify payment
            $rs = self::getPayment($txRef, ['id', 'amount']);
            if ($rs)
            {
                //https://api.flutterwave.com/v3/transactions/:id/verify
                //invoke API
                $arData = [
                    'url' => DEF_FLW_VERIFY_PAYMENT_URL.'/'.$transactionId.'/verify',
                    'method' => 'GET'
                ];
                $rsx = Api::invokeApiCall($arData);
                $res = json_decode($rsx, true);
                //print_r($res);
                if (array_key_exists('status', $res))
                {
                    if ($res['status'] == 'success')
                    {
                        if (
                            $res['data']['status'] === "successful"
                            && doTypeCastDouble($res['data']['amount']) === doTypeCastDouble($rs['amount']))
                        {
                            $data = [
                                'transaction_id' => $transactionId,
                                'status' => 1
                            ];
                            Crud::update(
                                self::$table,
                                $data,
                                ['id' => $rs['id']]
                            );
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}