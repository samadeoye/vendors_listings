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
    static $appPerPage = 20;

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

    public static function getPayments($page=1, $arFields=['*'])
    {
        global $userId;

        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;

        $perPage = self::$appPerPage;
        if($page <= 1)
        {
            $limit = '0,'.$perPage;
        }
        else
        {
            $offset = doTypeCastDouble(($page - 1) * $perPage);
            $limit = $offset.','.$perPage;
        }
        $data = [
            'columns' => $fields,
            'where' => [
                'user_id' => $userId,
                'deleted' => 0
            ],
            'return_type' => 'all',
            'order' => 'cdate DESC',
        ];
        if($limit != '')
        {
            $data['limit'] = $limit;
        }

        return Crud::select(
            self::$table,
            $data
        );
    }
    public static function getPaymentsContent($page=1)
    {
        $rs = self::getPayments($page);
        if (count($rs) == 0)
        {
            return 'No payment yet.';
        }

        $output = '';
        foreach($rs as $r)
        {
            $amount = getAmountWithCurrency($r['amount']);
            $cdate = getFormattedDate($r['cdate']);
            $rsx = self::getPaymentPlan($r['plan_id'], ['name']);
            $plan = $rsx['name'];
            $expiryDate = '';
            $statusLabel = 'Paid';
            $statusClass = 'paid';
            if ($r['status'] == 0)
            {
                $statusLabel = 'Unpaid';
                $statusClass = 'unpaid';
            }
            $output .= <<<EOQ
            <li><i class="utf_list_box_icon fa fa-paste"></i> <strong> {$amount} <span class="{$statusClass}"> {$statusLabel} </span></strong>
                <ul>
                    <li><span>Payment Reference: </span> {$r['reference']} </li>
                    <li><span>Plan: </span> {$plan} </li>
                    <li><span>Expires on: </span> {$expiryDate} </li>
                    <li><span>Date: </span> {$cdate} </li>
                </ul>
            </li>
EOQ;
        }

        return $output;
    }
    public static function getPaymentsTotal()
    {
        global $userId;

        $rsTotal = Crud::select(
            self::$table,
            [
                'columns' => 'COUNT(id) AS total',
                'where' => [
                    'user_id' => $userId,
                    'deleted' => 0
                ],
            ]
        );
        return doTypeCastDouble($rsTotal['total']);
    }
    public static function getPaymentsPaginationData()
    {
        $page = doTypeCastInt($_REQUEST['page']);
        $pagination = self::getPaymentsPagination($page);
        $list = self::getPaymentsContent($page);

        $data = [
            'pagination' => $pagination,
            'list' => $list
        ];

        self::$data = [
            'status' => true,
            'data' => $data
        ];
    }
    public static function getPaymentsPagination($page=1)
    {
        $total = self::getPaymentsTotal();
        if ($total == 0)
        {
            return '';
        }
        //get last page
        $perPage = self::$appPerPage;
        $lastPage = ceil($total / $perPage);
        
        $prev = $page - 1;
        $next = $page + 1;

        $prevOnClick = "showPagination('{$prev}')";
        $nextOnClick = "showPagination('{$next}')";
        if ($page <= 1)
        {
            $prevOnClick = '';
        }
        if ($page >= $lastPage)
        {
            $nextOnClick = '';
        }

        $output = <<<EOQ
        <nav class="pagination" id="paymentsPagination">
            <input type="hidden" name="currentPage" id="currentPage" value="{$page}">
            <ul>
            <li><a onclick="{$prevOnClick}"><i class="sl sl-icon-arrow-left"></i></a></li>
EOQ;
        for($i = 1; $i <= $lastPage; $i++)
        {
            $current = '';
            $onClick = "showPagination('{$i}')";
            if ($i == $page)
            {
                $current = 'current-page';
                $onClick = '';
            }
            $output .= <<<EOQ
            <li><a onclick="{$onClick}" class="{$current}">{$i}</a></li>
EOQ;
        }
        $output .= <<<EOQ
            <li><a onclick="{$nextOnClick}"><i class="sl sl-icon-arrow-right"></i></a></li>
            </ul>
        </nav>
EOQ;

        return $output;
    }
}