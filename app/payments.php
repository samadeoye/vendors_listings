<?php
use Lamba\Payment\Payment;
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
            <div class="col-md-12">
                <a href="#dialogMakePayment" class="myButton btnPrimary sign-in popup-with-zoom-anim"> <i class="sl sl-icon-credit-card"></i> Make Payment</a>
            </div>

            <div class="col-lg-12 col-md-12">
				<div class="utf_dashboard_list_box invoices with-icons margin-top-20">
                    <h4>Payment History</h4>
                    <ul id="paymentsList">
                        <?php
                            echo Payment::getPaymentsContent();
                        ?>  
					</ul>
				</div>
                <div class="clearfix"></div>
                <div class="utf_pagination_container_part margin-top-30 margin-bottom-30">
                    <?php
                        echo Payment::getPaymentsPagination();
                    ?>
                </div>
            </div>
        </div>
		
        <?php require_once 'inc/footer.php'; ?>

    </div>    
  </div>
</div>

<?php
$arAdditionalJs[] = <<<EOQ
    function showPagination(page)
    {
        if (page <= 0)
        {
            return false;
        }
        else
        {
            $.ajax({
                url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: {
                    page: page,
                    action: 'getPaymentsPaginationData'
                },
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        $("#paymentsList").html(data.data['list']);
                        $("#paymentsPagination").html(data.data['pagination']);
                    }
                }
            });
        }
    }
EOQ;

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