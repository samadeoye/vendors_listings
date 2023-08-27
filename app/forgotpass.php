<?php
require_once '../inc/utils.php';
$pageTitle = 'Forgot Password';
require_once '../inc/head.php';
?>

<div class="container">
    <div class="row margin-top-40 margin-bottom-40">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3> Password Reset</h3>
            <span>Enter your registered email address to proceed</span>
            <form method="post" id="forgotPassForm" onsubmit="return false;">
                <!-- <label><b>Email</b></label> -->
                <input type="hidden" id="action" name="action" value="forgotPassVerifyEmail">
                <input type="text" class="input-text" id="email" name="email">
                <button class="button preview btn_center_item margin-top-15" id="btnSubmit">Proceed</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#forgotPassForm #btnSubmit').click(function()
    {
        var formId = '#forgotPassForm';
        var email = $(formId+' #email').val();

        if (email.length < 13)
        {
            throwError('Please enter a valid email');
        }
        else
        {
            var form = $('#forgotPassForm');
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
                        throwSuccess('Password reset link has been sent to your email: '+ email);
                        form[0].reset();
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
require_once '../inc/foot.php';
?>