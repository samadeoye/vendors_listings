<?php
require_once '../inc/utils.php';
$pageTitle = 'Reset Password';

if (isset($_GET['token']))
{
    $token = trim($_GET['token']);
    if (strlen($token) != 36)
    {
        header('location: forgotpass');
    }
}
else
{
    header('location: forgotpass');
}

require_once '../inc/head.php';
?>

<div class="container">
    <div class="row margin-top-40 margin-bottom-40">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3> Password Reset </h3>
            <span> Enter new password to complete your password reset. </span>
            <form method="post" id="resetPasswordForm" onsubmit="return false;">
                <!-- <label><b>Email</b></label> -->
                <input type="hidden" id="action" name="action" value="resetpassword">
                <input type="hidden" id="token" name="token" value="<?=$token;?>">
                <input type="password" class="input-text" id="password" name="password" placeholder="New Password">
                <input type="password" class="input-text" id="password_confirm" name="password_confirm" placeholder="Confirm Password">
                <button class="button preview btn_center_item margin-top-15" id="btnSubmit">Reset Password</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#resetPasswordForm #btnSubmit').click(function()
    {
        var formId = '#resetPasswordForm';
        var password = $(formId+' #password').val();
        var passwordConfirm = $(formId+' #password_confirm').val();

        if (password.length < 6)
        {
            throwError('Please enter a valid password');
        }
        else if (password != passwordConfirm)
        {
            throwError('Passwords do not match');
        }
        else
        {
            var form = $('#resetPasswordForm');
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
                        throwSuccess('Password reset successfully! Proceed to login.');
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