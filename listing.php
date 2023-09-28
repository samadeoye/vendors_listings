<?php
require_once 'inc/utils.php';
use Lamba\Listing\Listing;
use Lamba\User\User;
use Lamba\BusinessType\BusinessType;

$pageTitle = 'Listings';

$arAdditionalCSS[] = <<<EOQ
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.3.3/dist/css/splide.min.css">
EOQ;

require_once 'inc/head.php';

if (isset($_GET['id']))
{
    $id = trim($_GET['id']);
    if (strlen($id) != 36)
    {
        header('location: listings');
    }
}
else
{
    header('location: listings');
}

Listing::updateListingViews($id);
$rs = Listing::getListing($id);
$arUserInfo = User::getUser($rs['user_id']);
$userAddress = User::getUserAddress(
    $arUserInfo['address_street'],
    $arUserInfo['address_city'],
    $arUserInfo['address_state']
);
$rsx = BusinessType::getBusinessType($rs['category_id'], ['name']);
$businessTypeName = $rsx['name'];
$arGallery = [$rs['cover_img']];
$galleryImages = $rs['gallery_img'];
if ($galleryImages != '')
{
    $arGallery = array_merge([$rs['cover_img']], explode(',', $rs['gallery_img']));
}
?>
<section id="main-carousel" class="splide" aria-label="">
    <div class="splide__track">
    <ul class="splide__list">
    <?php
    foreach($arGallery as $gImg)
    {?>
        <li class="splide__slide">
            <img src="images/woara/users/<?=$gImg;?>" alt="">
        </li>
    <?php
    } ?>
    </ul>
    </div>
</section>

<ul id="thumbnails" class="thumbnails">
    <?php
    foreach($arGallery as $gImg)
    {?>
        <li class="thumbnail">
            <img src="images/woara/users/<?=$gImg;?>" alt="">
        </li>
    <?php
    } ?>
</ul>

<div class="container">
    <div class="row utf_sticky_main_wrapper">
        <div class="col-lg-8 col-md-8">
            <div id="titlebar" class="utf_listing_titlebar">
                <div class="utf_listing_titlebar_title">
                    <h2><?=$rs['title'];?> <span class="listing-tag"><?=$businessTypeName;?></span></h2>
                    <div><i class="fa fa-eye"></i> <b><?=$rs['views'];?></b></div>   
                    <span> <a href="#utf_listing_location" class="listing-address"> <i class="sl sl-icon-location"></i> <?=$userAddress;?> </a> </span>
                    <span class="call_now"><i class="sl sl-icon-phone"></i> <?=$arUserInfo['phone'];?> </span>
                    <span class="call_now"><i class="fa fa-envelope-o"></i> <a href="mailto:<?=$arUserInfo['email'];?>"> <?=$arUserInfo['email'];?> </a></span>
                </div>
            </div>
            <div id="utf_listing_overview" class="utf_listing_section">
                <h3 class="utf_listing_headline_part margin-top-30 margin-bottom-30">Listing Description</h3>
                <p><?=$rs['full_desc'];?></p>
            </div>
        
            <div id="utf_listing_reviews" class="utf_listing_section">
                <h3 class="utf_listing_headline_part margin-top-75 margin-bottom-20">Comments</h3>
                <div class="clearfix"></div>

                <div class="comments utf_listing_reviews">
                    <ul id="listingReviewList">
                        <?php
                            echo Listing::getListingCommentContent($id);
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="utf_pagination_container_part margin-top-30">
                            <?php
                                echo Listing::getListingCommentsPagination($id);
                            ?>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>
            </div>
            <div id="utf_add_review" class="utf_add_review-box">
                <h3 class="utf_listing_headline_part margin-bottom-20">Add Your Review</h3>
                <span class="utf_leave_rating_title">Your email address will not be published.</span>
                <form id="utf_add_comment" class="utf_add_comment" onsubmit="return false;">
                    <fieldset>
                    <div class="row">
                        <input type="hidden" id="action" name="action" value="addreview">
                        <input type="hidden" id="listing_id" name="listing_id" value="<?=$id;?>">
                        <div class="col-md-6">
                        <label>Name:</label>
                        <input type="text" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                        <label>Email:</label>
                        <input type="text" id="email" name="email">
                        </div>
                    </div>
                    <div>
                        <label>Comment:</label>
                        <textarea cols="40" placeholder="Your Message..." rows="3" id="msg" name="msg"></textarea>
                    </div>
                    </fieldset>
                    <button class="button" id="btnSubmit">Submit Review</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    
      
        <!-- Sidebar -->
        <div class="col-lg-4 col-md-4 margin-top-45 sidebar-search">
            <div class="utf_box_widget margin-top-35">
                <h3><i class="sl sl-icon-phone"></i> Contact Info</h3>
                <div class="utf_hosted_by_user_title">
                    <a href="#" class="utf_hosted_by_avatar_listing"><img src="images/woara/dash_avatar.png" alt=""></a>
                    <h4><a href="#"> <?=$arUserInfo['fname'].' '.$arUserInfo['lname'];?> </a><span>Posted on <?=getFormattedDate($rs['cdate']);?></span></h4>
                </div>
                <ul class="utf_social_icon rounded margin-top-10">
                    <li><a class="facebook" href="<?=$arUserInfo['facebook'];?>"><i class="icon-facebook"></i></a></li>
                    <li><a class="instagram" href="<?=$arUserInfo['instagram'];?>"><i class="icon-instagram"></i></a></li>
                    <li><a class="twitter" href="<?=$arUserInfo['twitter'];?>"><i class="icon-twitter"></i></a></li>         
                </ul>
                <ul class="utf_listing_detail_sidebar">
                    <li><i class="sl sl-icon-map"></i> <?=$userAddress;?> </li>
                    <li><i class="sl sl-icon-phone"></i> <a href="tel:<?=$arUserInfo['phone'];?>"> <?=$arUserInfo['phone'];?> </a></li>
                    <li><i class="fa fa-envelope-o"></i> <a href="mailto:<?=$arUserInfo['email'];?>"> <?=$arUserInfo['email'];?> </a></li>
                </ul>  
            </div>
            <div class="utf_box_widget margin-top-35">
                <h3><i class="sl sl-icon-folder-alt"></i> Categories</h3>
                <ul class="utf_listing_detail_sidebar">
                    <?php
                    $arBusinessTypes = BusinessType::getBusinessTypesWithCounts();
                    foreach($arBusinessTypes as $r)
                    { ?>
                        <li><i class="fa fa-angle-double-right"></i> <a href="listings?categoryId=<?=$r['id'];?>"><?=$r['name'];?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>

<?php
$arAdditionalJsScripts[] = <<<EOQ
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.3.3/dist/js/splide.min.js"></script>
EOQ;

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
                listing_id: '{$id}',
                action: 'getReviewPaginationData'
            },
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data)
            {
                if(data.status == true)
                {
                    $("#listingReviewList").html(data.data['list']);
                    $("#listingReviewPagination").html(data.data['pagination']);
                }
            }
        });
    }
}

var splide = new Splide( '#main-carousel', {
    pagination: false,
} );

var thumbnails = document.getElementsByClassName( 'thumbnail' );
var current;

for ( var i = 0; i < thumbnails.length; i++ ) {
    initThumbnail( thumbnails[ i ], i );
}

function initThumbnail( thumbnail, index ) {
    thumbnail.addEventListener( 'click', function () {
    splide.go( index );
    } );
}

splide.on( 'mounted move', function () {
    var thumbnail = thumbnails[ splide.index ];

    if ( thumbnail ) {
    if ( current ) {
        current.classList.remove( 'is-active' );
    }

    thumbnail.classList.add( 'is-active' );
    current = thumbnail;
    }
} );

splide.mount();
EOQ;

$arAdditionalJsOnLoad[] = <<<EOQ
    $('#utf_add_comment #btnSubmit').click(function() {
        var formId = '#utf_add_comment';
        var name = $(formId+' #name').val();
        var email = $(formId+' #email').val();
        var msg = $(formId+' #msg').val();

        if (name.length < 3 || name.length > 100)
        {
            throwError('Name is invalid');
        }
        else if (email.length > 0 && email.length < 14)
        {
            throwError('Please leave email empty or enter a valid email address');
        }
        else if (msg.length < 5)
        {
            throwError('Please enter a valid message');
        }
        else
        {
            var form = $('#utf_add_comment');
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
                        throwSuccess('Comment posted successfully!');
                        form[0].reset();
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
EOQ;
require_once 'inc/foot.php';
?>