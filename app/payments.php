<?php
require_once '../inc/utils.php';
$pageTitle = 'Payments';

$isVerify = false;
if (isset($_GET['tx_ref']) && isset($_GET['transaction_id']) && isset($_GET['status']))
{
    $isVerify = true;
    if (Lamba\Payment\Payment::verifyPayment())
    {
        $_SESSION['msg'] = [
            'msg' => 'Payment completed successfully',
            'class' => 'success'
        ];
    }
    else
    {
        //handle error message
        $_SESSION['msg'] = [
            'msg' => 'Payment could not be processed successfully. Please try again.',
            'class' => 'error'
        ];
    }
    header('location: payments');
}

require_once 'inc/head.php';
?>

<div id="dialogMakePayment" class="dialog_signin_part zoom-anim-dialog mfp-hide">
    <div class="small_dialog_header">
        <h3>Select Plan</h3>
    </div>
    <div class="utf_signin_form style_one">
        <div class="tab_container alt">
            <div class="tab_content" id="tab1" style="display:none;">
                <form method="post" class="login" id="makePaymentForm" onsubmit="return false;">
                    <input type="hidden" name="action" id="action" value="makepayment">
                    <p class="utf_row_form utf_form_wide_block">
                        <label for="title">
                            <select name="payment_plan_id" id="payment_plan_id">
                                <?php
                                    echo Lamba\Payment\Payment::getPaymentPlansDropdown();
                                ?>
                            </select>
                        </label>
                    </p>
                    <div class="utf_row_form">
                        <button class="button border fw margin-top-10" id="btnSubmit"> Proceed to Pay </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard -->
<div id="dashboard">
    <?php require_once 'inc/sidebar.php'; ?>

	<div class="utf_dashboard_content"> 
        <div id="titlebar" class="dashboard_gradient">
            <div class="row">
                <div class="col-md-12">
                    <h2><?=$pageTitle;?></h2>
                    <nav id="breadcrumbs">
                    <ul>
                        <li><a href="<?=DEF_FULL_BASE_PATH_URL;?>">Home</a></li>
                        <li><a href="app/">Dashboard</a></li>
                        <li><?=$pageTitle;?></li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>

        <?php
            if (isset($_SESSION['msg']) && !$isVerify)
            {
                echo getAlertWrapperDisplay($_SESSION['msg']['msg'], $_SESSION['msg']['class']);
                unset($_SESSION['msg']);
            }
        ?>
      
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="row"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="utf_dashboard_block_part color-1">
                            <div class="utf_dashboard_ic_stat">
                                <i class="fa fa-money"></i>
                            </div>	
                            <div class="utf_dashboard_content_part utf_wallet_totals_item">
                                <h4>$ 1260.08</h4>
                                <span>Total Withdrawal Payout</span>					
                            </div>		  
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="utf_dashboard_block_part color-2">
                            <div class="utf_dashboard_ic_stat">
                                <i class="sl sl-icon-wallet"></i>
                            </div>
                            <div class="utf_dashboard_content_part utf_wallet_totals_item">
                                <h4>$ 680.26</h4>
                                <span>Total Earning Payout</span>					
                            </div>  
                        </div>
                    </div>
                
                    <div class="col-lg-3 col-md-6">
                        <div class="utf_dashboard_block_part color-3">
                            <div class="utf_dashboard_ic_stat">
                                <i class="sl sl-icon-list"></i>
                            </div>
                            <div class="utf_dashboard_content_part">
                                <h4>115</h4>
                                <span>Listing Pending Order</span>					
                            </div>			  
                        </div>
                    </div>
                
                    <div class="col-lg-3 col-md-6">
                        <div class="utf_dashboard_block_part color-4">
                            <div class="utf_dashboard_ic_stat">
                                <i class="sl sl-icon-basket"></i>
                            </div>
                            <div class="utf_dashboard_content_part">
                                <h4>228</h4>
                                <span>Listing Total Order</span>					
                            </div>				  
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <a href="#dialogMakePayment" class="myButton btnPrimary sign-in popup-with-zoom-anim"> <i class="sl sl-icon-credit-card"></i> Make Payment</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
				<div class="utf_dashboard_list_box invoices with-icons margin-top-20">
                    <h4>Listings Earning</h4>
                    <ul>
                        <li><i class="utf_list_box_icon sl sl-icon-basket-loaded"></i> <strong>The Hot and More Restaurant <span class="list_hotel">Restaurant</span></strong>
                        <ul>
                            <li><span>Date:-</span> 12 Jan 2022</li>
                            <li><span>Order No:-</span> 00403128</li>
                            <li class="paid"><span>Price:-</span> $178.00</li>												
                        </ul>
                        </li>
                        <li><i class="utf_list_box_icon sl sl-icon-basket-loaded"></i> <strong>Burger House (MG Road) <span class="list_hotel">Burger House</span></strong>
                            <ul>
                                <li><span>Date:-</span> 12 Jan 2022</li>
                                <li><span>Order No:-</span> 00403128</li>
                                <li class="paid"><span>Price:-</span> $178.00</li>												
                            </ul>
                        </li>
                    </ul>
				</div>
            </div>
			  
            <div class="col-lg-6 col-md-12">
				<div class="utf_dashboard_list_box invoices with-icons margin-top-20">
                    <h4>Listings Payout History</h4>
                    <ul>
                        <li><i class="utf_list_box_icon fa fa-paste"></i> <strong>$122  <span class="paid">Paid</span></strong>
                            <ul>
                            <li><span>Order Number:-</span> 004128641</li>
                            <li><span>Date:-</span> 12 Jan 2022</li>
                            </ul>
                            <div class="buttons-to-right"> <a href="dashboard_invoice.html" class="button gray"><i class="sl sl-icon-printer"></i> Invoice</a> </div>
                        </li>
                        <li><i class="utf_list_box_icon fa fa-paste"></i> <strong>$189 <span class="paid">Paid</span></strong>
                            <ul>
                                <li><span>Order Number:-</span> 004312641</li>
                                <li><span>Date:-</span> 12 Jan 2022</li>
                            </ul>
                            <div class="buttons-to-right"> <a href="dashboard_invoice.html" class="button gray"><i class="sl sl-icon-printer"></i> Invoice</a> </div>
                        </li>			  
					</ul>
				</div>
            </div>

        </div>
		
        <?php require_once 'inc/footer.php'; ?>

    </div>    
  </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#makePaymentForm #btnSubmit').click(function ()
    {
        var formId = '#makePaymentForm';
        var paymentPlanId = $(formId+' #payment_plan_id').val();

        if (paymentPlanId.length != 36)
        {
            throwError('Please select a payment plan');
        }
        else
        {
            var form = $("#makePaymentForm");
            $.ajax({
                url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    enableDisableBtn(formId+' #btnSubmit', 0);
                },
                complete: function() {
                    enableDisableBtn(formId+' #btnSubmit', 1);
                },
                success: function(data)
                {
                    if(data.status)
                    {
                        form[0].reset();
                        window.location.href = data.data.link;
                    }
                    else
                    {
                        throwError(data.msg);
                    }
                }
            });
        }
    });
EOQ;

require_once 'inc/foot.php';
?>