<?php
require_once '../inc/utils.php';
$pageTitle = 'Comments';
require_once 'inc/head.php';

use Lamba\Comment\Comment;
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
            <div class="col-lg-12 col-md-12">
                <div class="utf_dashboard_list_box margin-top-0">
                    <h4><i class="sl sl-icon-star"></i> Comments </h4>
                    <ul id="commentListing">
                        <?php
                            echo Comment::getUserListingCommentContent();
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="utf_pagination_container_part margin-top-30 margin-bottom-30">
                    <?php
                        echo Comment::getUserListingCommentsPagination();
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
                    action: 'getUserListingsPaginationData'
                },
                beforeSend: function() {
                },
                complete: function() {
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        $("#commentListing").html(data.data['list']);
                        $("#listingReviewPagination").html(data.data['pagination']);
                    }
                }
            });
        }
    }

    function doOpenListingCommentDeleteModal(id)
    {
        Swal.fire({
            title: '',
            text: 'Are you sure you want to delete this comment?',
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
                        'action': 'deletecomment'
                    },
                    success: function(data)
                    {
                        if(data.status) {
                            throwSuccess(data.msg);
                            var currentPage = $('#listingReviewPagination #currentPage').val();
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

    function doOpenListingCommentApprovalModal(id, action)
    {
        var confirmLabel = 'Approve';
        if (action != 'approve')
        {
            confirmLabel = 'Disapprove';
        }
        Swal.fire({
            title: '',
            text: 'Are you sure you want to '+action+' this comment?',
            icon: 'error',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: confirmLabel,
            confirmButtonColor: '#062f61',
            customClass: 'swalWide',
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: 'inc/actions',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'id': id,
                        'actionType': action,
                        'action': 'enableDisableComment'
                    },
                    success: function(data)
                    {
                        if(data.status) {
                            throwSuccess(data.msg);
                            var currentPage = $('#listingReviewPagination #currentPage').val();
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

require_once 'inc/foot.php';
?>