<?php
require_once '../inc/utils.php';
$pageTitle = 'Change Password';
require_once 'inc/head.php';
?>

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
      
        <div class="row"> 
            <div class="col-lg-12 col-md-12">
                <div class="utf_dashboard_list_box margin-top-0">
                    <h4 class="gray"><i class="sl sl-icon-key"></i> Change Password </h4>
                    <div class="utf_dashboard_list_box-static"> 
                        <div class="my-profile">
                            <div class="row with-forms">
                                <form id="changePasswordForm" onsubmit="return false;">
                                    <input type="hidden" name="action" id="action" value="changepassword">
                                    <div class="col-md-4">
                                        <label>Current Password</label>				
                                        <input type="password" class="input-text" name="current_password" id = "current_password">
                                    </div>
                                    <div class="col-md-4">
                                        <label>New Password</label>						
                                        <input type="password" class="input-text" name="new_password" id="new_password">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Confirm New Password</label>
                                        <input type="password" class="input-text" name="confirm_password" id="confirm_password">
                                    </div>
                                    <div class="col-md-12">
                                        <button class="button btn_center_item margin-top-15" id="btnSubmit">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <?php require_once 'inc/footer.php'; ?>

    </div>    
  </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#changePasswordForm #btnSubmit').click(function ()
    {
        var formId = '#changePasswordForm';
        var currentPassword = $(formId+' #current_password').val();
        var newPassword = $(formId+' #new_password').val();
        var confirmPassword = $(formId+' #confirm_password').val();

        if (currentPassword.length < 6 || newPassword.length < 6 || confirmPassword.length < 6)
        {
            throwError('Password must contain at least 6 characters');
        }
        else if (newPassword != confirmPassword)
        {
            throwError('Passwords do not match');
        }
        else
        {
            var form = $("#changePasswordForm");
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
                        throwSuccess('Password changed successfully!');
                        form[0].reset();
                    }
                    else
                    {
                        if(data.info !== undefined)
                        {
                            throwInfo(data.msg);
                        }
                        else
                        {
                            throwError(data.msg);
                        }
                    }
                }
            });
        }
    });
EOQ;

require_once 'inc/foot.php';
?>