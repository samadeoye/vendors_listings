<?php
require_once '../inc/utils.php';
$pageTitle = 'Add Listing';
require_once 'inc/head.php';
?>

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
            <div class="col-lg-12">
                <div id="utf_add_listing_part">
                    <form id="listingForm" onsubmit="return false;" enctype="multipart/form-data">
                        <div class="add_utf_listing_section margin-top-45">
                            <div class="utf_add_listing_part_headline_part">
                                <h3><i class="sl sl-icon-list"></i> Listing Details </h3>
                            </div>
                            <input type="hidden" name="action" id="action" value="addlisting">   
                            <div class="row with-forms">
                                <div class="col-md-12">
                                    <h5>Title <span class="text-red">*</span></h5>
                                    <input type="text" name="title" id="title">
                                </div>
                                <div class="col-md-12">
                                    <h5>Short Description</h5>
                                    <textarea cols="20" rows="2" name="short_desc" id="short_desc" spellcheck="true"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <h5>Full Description <span class="text-red">*</span></h5>
                                    <textarea cols="40" rows="6" name="full_desc" id="full_desc" spellcheck="true"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="add_utf_listing_section margin-top-45"> 
                            <div class="utf_add_listing_part_headline_part">
                                <h3><i class="sl sl-icon-picture"></i> Images</h3>
                            </div>			  
                            <div class="row with-forms">              
                                <div class="utf_submit_section col-md-6">
                                    <h4>Cover Image <span class="text-red">* </span><span class="text-red" style="font-size:12px;">Max. of 2MB</span></h4>
                                    <input type="file" class="input-text" accept="image/*" name="cover_img" id="cover_img">
                                </div>
                                <div class="utf_submit_section col-md-6">
                                    <h4>Gallery Images <span class="text-red" style="font-size:12px;">Maximum of 3 (max. of 2MB)</span></h4>
                                    <input type="file" class="input-text" accept="image/*" multiple="multiple" max-uploads=2 name="gallery_img[]" id="gallery_img">
                                </div>
                            </div>
                        </div>
                        <button class="button preview" id="btnSubmit">Submit</button>
                    </form>
                </div>
            </div>

        </div>
        
        <?php require_once 'inc/footer.php'; ?>

    </div>
</div>

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#listingForm #btnSubmit').click(function ()
    {
        var formId = '#listingForm';
        var title = $(formId+' #title').val();
        var shortDesc = $(formId+' #short_desc').val();
        var fullDesc = $(formId+' #full_desc').val();

        if (title.length < 3)
        {
            throwError('The title is invalid or too short.');
        }
        else if (shortDesc.length > 400)
        {
            throwError('Short description must be short and precise.');
        }
        else if (fullDesc.length < 20)
        {
            throwError('Please fill full description. It must give full details.');
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
                    enableDisableBtn(formId+' #btnSubmit', 0);
                },
                complete: function() {
                    enableDisableBtn(formId+' #btnSubmit', 1);
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        throwSuccess('Listing added successfully!');
                        $("#listingForm")[0].reset();
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