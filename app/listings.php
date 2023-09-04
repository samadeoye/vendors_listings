<?php
require_once '../inc/utils.php';
$pageTitle = 'My Listings';
require_once 'inc/head.php';
use Lamba\Listing\Listing;
?>

<div id="dialogEditListing" class="dialog_signin_part zoom-anim-dialog mfp-hide">
    <div class="small_dialog_header">
        <h3>Edit Listing</h3>
    </div>
    <div class="utf_signin_form style_one">
        <div class="tab_container alt">
            <div class="tab_content" id="tab1" style="display:none;">
                <form method="post" class="login" id="editListingForm" onsubmit="return false;">
                    <?php
                    echo getAlertWrapper('alert_editListing');
                    ?>
                    <input type="hidden" name="action" id="action" value="updatelisting">
                    <input type="hidden" name="id" id="id" value="">
                    <p class="utf_row_form utf_form_wide_block">
                    <label for="title">
                        <input type="text" class="input-text" name="title" id="title" value="" placeholder="Title" />
                    </label>
                    </p>
                    <p class="utf_row_form utf_form_wide_block">
                    <label for="short_desc">
                        <textarea cols="20" rows="2" name="short_desc" id="short_desc" placeholder="Short Description"></textarea>
                    </label>
                    </p>
                    <p class="utf_row_form utf_form_wide_block">
                    <label for="full_desc">
                        <textarea cols="40" rows="6" name="full_desc" id="full_desc" placeholder="Full Description"></textarea>
                    </label>
                    </p>
                    <div class="utf_row_form">
                        <button class="button border fw margin-top-10" id="btnSubmit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="dashboard">
    <?php require_once 'inc/sidebar.php'; ?>

	<div class="utf_dashboard_content"> 
        <div id="titlebar" class="dashboard_gradient">
            <div class="row">
                <div class="col-md-12">
                    <h2><?=$pageTitle;?></h2>
                    <nav id="breadcrumbs">
                    <ul>
                        <li><a href="<?=DEF_ROOT_PATH;?>">Home</a></li>
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
                    <h4><i class="sl sl-icon-list"></i> Comments </h4>
                    <ul id="appListingList">
                        <?php
                            echo Listing::getAppUserListingsContent();
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="utf_pagination_container_part margin-top-30 margin-bottom-30">
                    <?php
                        echo Listing::getAppUserListingPagination();
                    ?>
                </div>
            </div>
        </div>
        
        <?php require_once 'inc/footer.php'; ?>

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
                    action: 'getAppPaginationData'
                },
                beforeSend: function() {
                    enableDisableBtn('#appListingList #btnEditListing', 0);
                },
                complete: function() {
                    enableDisableBtn('#appListingList #btnEditListing', 1);
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        $("#appListingList").html(data.data['list']);
                        $("#appListingPagination").html(data.data['pagination']);
                    }
                }
            });
        }
    }
    function doOpenEditListingModal(id)
    {
        var formId = '#editListingForm';
        var form = $('#editListingForm');
        $.ajax({
            url: 'inc/actions',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                action: 'getEditListingModalData'
            },
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
                    $(formId+' #title').val(data.data['title']);
                    $(formId+' #short_desc').val(data.data['short_desc']);
                    $(formId+' #full_desc').val(data.data['full_desc']);
                    $(formId+' #id').val(id);
                }
                else
                {
                    enableDisableBtn(formId+' #btnSubmit', 0);
                    throwError('An error occured while fetching listing details.');
                }
            }
        });
    }
    function doOpenDeleteListingModal(id)
    {
        Swal.fire({
        title: '',
        text: 'Are you sure you want to delete this listing?',
        icon: 'error',
        showCancelButton: true,
        reverseButtons: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#d33',
        customClass: 'swalWide',
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
            url: 'inc/actions',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id,
                    'action': 'deletelisting'
                },
                success: function(data)
                {
                    if(data.status) {
                        throwSuccess(data.msg);
                        var currentPage = $('#appListingPagination #currentPage').val();
                        showPagination(currentPage);
                    }
                    else
                    {
                        throwError(data.msg);
                    }
                }
            });
        }
        });
    }
EOQ;
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#editListingForm #btnSubmit').click(function ()
    {
        var formId = '#editListingForm';
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
                        //var currentPage = $('#appListingPagination #currentPage').val();
                        //showPagination(currentPage);
                        throwSuccess('Listing updated successfully!');
                        //$.magnificPopup.close();
                        location.reload();
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