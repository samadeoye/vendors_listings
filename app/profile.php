<?php
$pageTitle = 'Change Password';
require_once 'inc/head.php';
?>

<div id="dashboard">
    <?php require_once 'inc/sidebar.php'; ?>

	<div class="utf_dashboard_content"> 
        <div id="titlebar" class="dashboard_gradient">
            <div class="row">
                <div class="col-md-12">
                    <h2>Dashboard</h2>
                    <nav id="breadcrumbs">
                    <ul>
                        <li><a href="<?=DEF_FULL_BASE_PATH_URL;?>">Home</a></li>
                        <li><a href="app/">Dashboard</a></li>
                        <li>Profile</li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="utf_dashboard_list_box margin-top-0">
                    <h4 class="gray"><i class="sl sl-icon-user"></i> Business Details </h4>
                    <div class="utf_dashboard_list_box-static">
                        <?php $logoFileName = !empty($arUser['logo']) ? $arUser['logo'] : 'dummy.png'; ?>
                        <div class="edit-profile-photo"> <img id="userLogo" src="images/lamba/users/<?=$logoFileName;?>" alt="Business Logo"></div>
                        <form method="post" id="profileForm" onsubmit="return false;" action="crud/actions" enctype="multipart/form-data">
                            <div class="my-profile">
                                <div class="row with-forms">
                                    <input type="hidden" id="action" name="action" value="updateprofile">
                                    <div class="col-md-4">
                                        <label>First Name <span class="text-red">*</span></label>
                                        <input type="text" class="input-text" id="fname" name="fname" value="<?=$arUser['fname'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Last Name <span class="text-red">*</span></label>
                                        <input type="text" class="input-text" id="lname" name="lname" value="<?=$arUser['lname'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Business / Company Name <span class="text-red">*</span></label>				
                                        <input type="text" class="input-text" id="business_name" name="business_name" value="<?=$arUser['business_name'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Business Type <span class="text-red">*</span></label>
                                        <select id="business_type_id" name="business_type_id">
                                            <?php echo Lamba\BusinessType\BusinessType::getBusinessTypeDropdownOptions(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Email <span class="text-red">*</span></label>						
                                        <input type="text" class="input-text" id="email" name="email" value="<?=$arUser['email'];?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Phone <span class="text-red">*</span></label>						
                                        <input type="text" class="input-text" id="phone" name="phone" value="<?=$arUser['phone'];?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Street Address</label>
                                        <input type="text" class="input-text" id="address_street" name="address_street" value="<?=$arUser['address_street'];?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>City <span class="text-red">*</span></label>
                                        <input type="text" class="input-text" id="address_city" name="address_city" value="<?=$arUser['address_city'];?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>State <span class="text-red">*</span></label>						
                                        <input type="text" class="input-text" id="address_state" name="address_state" value="<?=$arUser['address_state'];?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Business Logo</label>
                                        <input type="file" class="input-text" name="logo" id="logo">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Business Cover Image</label>
                                        <input type="file" class="input-text" name="cover_img" id="cover_img">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Full Business Description <span class="text-red">*</span></label>
                                        <textarea id="business_info" name="business_info" cols="10" rows="4"><?=$arUser['business_info'];?></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Facebook Link</label>
                                        <input type="text" id="facebook" name="facebook" class="input-text" placeholder="https://facebook.com/example" value="<?=$arUser['facebook'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Instagram Link</label>
                                        <input type="text" id="instagram" name="instagram" class="input-text" placeholder="http://instagram.com/example" value="<?=$arUser['instagram'];?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Twitter Link</label>
                                        <input type="text" id="twitter" name="twitter" class="input-text" placeholder="https://twitter.com/example" value="<?=$arUser['twitter'];?>">
                                    </div>
                                </div>	
                            </div>
                            <button class="button preview btn_center_item margin-top-15" id="btnSubmit">Save Changes</button>
                        </form>
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
    $('#profileForm #btnSubmit').click(function ()
    {
        var formId = '#profileForm';
        var fname = $(formId+' #fname').val();
        var lname = $(formId+' #lname').val();
        var phone = $(formId+' #phone').val();
        var businessName = $(formId+' #business_name').val();
        var businessInfo = $(formId+' #business_info').val();
        var addressCity = $(formId+' #address_city').val();
        var addressState = $(formId+' #address_state').val();

        if (fname.length < 3 || lname.length < 3 || phone.length < 11 || phone.length > 15 ||businessName.length < 5 || businessInfo.length < 20 || addressCity.length < 3 || addressState.length < 3)
        {
            throwError('Please fill all required fields');
        }
        else
        {
            var formData = new FormData(this.form);
            $.ajax({
                url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    enableDisableBtn(formId+' #btnSumbmit', 0);
                },
                complete: function() {
                    enableDisableBtn(formId+' #btnSumbmit', 1);
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        throwSuccess('Business details updated successfully!');
                        $(formId+' #fname').val(data.data['fname']);
                        $(formId+' #lname').val(data.data['lname']);
                        $(formId+' #phone').val(data.data['phone']);
                        $(formId+' #business_name').val(data.data['business_name']);
                        $(formId+' #business_type_id').val(data.data['business_type_id']);
                        $(formId+' #business_info').val(data.data['business_info']);
                        $(formId+' #address_street').val(data.data['address_street']);
                        $(formId+' #address_city').val(data.data['address_city']);
                        $(formId+' #address_state').val(data.data['address_state']);
                        $(formId+' #facebook').val(data.data['facebook']);
                        $(formId+' #instagram').val(data.data['instagram']);
                        $(formId+' #twitter').val(data.data['twitter']);
                        $(formId+' #logo').val('');
                        $(formId+' #cover_img').val('');
                        $('#userLogo').attr('src', 'images/lamba/users/'+data.data['logo']);
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