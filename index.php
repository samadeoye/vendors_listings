<?php
require_once 'inc/utils.php';
use Lamba\BusinessType\BusinessType;
use Lamba\Listing\Listing;
use Lamba\User\User;

$pageTitle = 'Home';

$arAdditionalCSS[] = <<<EOQ
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.3.3/dist/css/splide.min.css">
EOQ;

require_once 'inc/head.php';

$arBusinessTypes = BusinessType::getBusinessTypesWithCounts();

?>

<div class="search_container_block home_main_search_part main_search_block" data-background-image="images/woara/page-title.jpg">
  <div class="main_inner_search_block">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Make yourself beautiful</h2>
          <h4>FIND YOUR VERIFIED VENDORS</h4>
          <form id="searchForm" onsubmit="return false;">
            <div class="main_input_search_part">
              <div class="main_input_search_part_item">
                <input type="text" name="query" id="query" placeholder="What are you looking for?">
              </div>
              <div class="main_input_search_part_item intro-search-field">
                <select data-placeholder="All Categories" class="selectpicker default" title="Categories" data-live-search="true" data-selected-text-format="count" data-size="5" name="category_id" id="category_id">
                  <option value=""> All </option>
                  <?php
                  foreach($arBusinessTypes as $r)
                  { ?>
                    <option value="<?=$r['id'];?>"> <?=$r['name'];?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <button class="button" id="btnSubmit">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="main-carousel splide adsCorner" aria-label="Ads Gallery">
  <h2 class="text-center white padding-top-20">Ads Corner</h2>
  <div class="splide__track padding-bottom-20">
    <ul class="splide__list">
      <li class="splide__slide">
        <img src="images/woara/ads/hair.jpg" alt="">
      </li>
      <li class="splide__slide">
        <img src="images/woara/ads/skincare.jpg" alt="">
      </li>
    </ul>
  </div>
</section>

<ul id="thumbnails" class="thumbnails">
  <li class="thumbnail">
    <img src="images/woara/ads/hair.jpg" alt="">
  </li>
  <li class="thumbnail">
    <img src="images/woara/ads/skincare.jpg" alt="">
  </li>
</ul>

<div class="container padding-bottom-70">
  <div class="row">
    <div class="col-md-12">
      <h3 class="headline_part centered margin-bottom-35 margin-top-70">Categories <span>Discover the vendors based on your needs.</span></h3>
    </div>
    <?php
      if (count($arBusinessTypes) > 0)
      {
        foreach ($arBusinessTypes as $r)
        { ?>
          <div class="col-md-4 col-sm-6 col-xs-12"> 
            <a href="listings?categoryId=<?=$r['id'];?>" class="img-box" data-background-image="images/woara/<?=$r['img'];?>">
              <div class="utf_img_content_box visible">
                <h4><?=$r['name']; ?></h4>
                <span><?=$r['num']; ?> Listings</span>
              </div>
            </a>
          </div>
        <?php
        }
      }
    ?>
  </div>
</div>


<section class="fullwidth_block padding-top-75 padding-bottom-75" data-background-color="#ffffff">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="headline_part centered margin-bottom-50"> Who We Are</h3>
      </div>
    </div>
    <div class="row"> 
      <div class="col-md-5 col-sm-6 col-xs-12">
        <img src="images/woara/woara-logo.png" alt="<?=SITE_NAME; ?> Logo">
      </div>
      
      <div class="col-md-7 col-sm-6 col-xs-12">
        <?=SITE_NAME;?> provides vendors dealing in the line of hair, jewelleries, skincare and perfumes a platform to explore in their line of business. With a reasonably low amount, you get to put your business to the world.<br>
        Be visible! Obtain new customers and generate more traffic. Improve social media engagement. Get reviews and grow business reputation online. Your company profile can include contacts and description, photo gallery and your business location.<br>
        <div class="margin-top-15">
          <a href="about" class="myButton btnPrimary">Read More</a>
        </div>
        
      </div>
  </div>
</section>

<section class="fullwidth_block padding-top-75 padding-bottom-70" data-background-color="#f9f9f9">
  <div class="container">
    <div class="row slick_carousel_slider">
      <div class="col-md-12">
        <h3 class="headline_part centered margin-bottom-45"> Featured Listings </h3>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="simple_slick_carousel_block utf_dots_nav"> 
            <?php
              $arListings = Listing::getPaidUsersListings();
              if (count($arListings) > 0)
              {
                foreach($arListings as $r)
                {
                  $rs = User::getUser($r['user_id'], ['business_type_id', 'business_name']);
                  $rsx = BusinessType::getBusinessType($rs['business_type_id'], ['name']);
                  $businessType = '';
                  if ($rsx)
                  {
                    $businessType = $rsx['name'];
                  }
                  $coverImgFileName = !empty($r['cover_img']) ? $r['cover_img'] : 'dummy.jpg';
                  $shortDesc = !empty($r['short_desc']) ? $r['short_desc'] : substr($r['full_desc'], 0, 200).'...';
                  ?>
                  <div class="utf_carousel_item">
                    <a href="listing?id=<?=$r['id'];?>" class="utf_listing_item-container compact">
                      <div class="utf_listing_item"> <img src="images/woara/users/<?=$coverImgFileName;?>" alt="">
                        <div class="utf_listing_item_content">
                          <div class="utf_listing_prige_block">			
                            <span class="utp_approve_item"><i class="utf_approve_listing"></i></span>
                          </div>
                          <h3><?=$r['title'];?></h3>
                        </div>					  
                      </div>
                      <div class="utf_star_rating_section">
                        <div> <i class="fa fa-home"></i> <?=$rs['business_name'];?> | <i class="fa fa-eye"></i> <?=$r['views'];?> <span> </div>
                      </div>
                    </a>
                    <span class="myBadge btnPrimary"> <i class="sl sl-icon-layers"></i> <?=$businessType;?> </span>
                    <div><?=$shortDesc;?></div>
                  </div>
                  <?php
                }
              }
              else
              {?>
                <p>No listing yet</p>
              <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<a href="listings" class="flip-banner parallax" data-background="images/woara/vendor-link-bg.jpg" data-color="#000" data-color-opacity="0.85" data-img-width="2500" data-img-height="1666">
  <div class="flip-banner-content">
  <h2 class="flip-visible">Browse Vendors List</h2>
  </div>
</a>

<section id="main-carousel2" class="main-carousel splide adsCorner" aria-label="Ads Gallery">
  <h2 class="text-center white padding-top-20">Ads Corner</h2>
  <div class="splide__track padding-bottom-20">
    <ul class="splide__list">
      <li class="splide__slide">
        <img src="images/woara/ads/perfume.jpg" alt="">
      </li>
    </ul>
  </div>
</section>

<ul id="thumbnails" class="thumbnails">
  <li class="thumbnail">
    <img src="images/woara/ads/perfume.jpg" alt="">
  </li>
</ul>

<?php
$arAdditionalJsScripts[] = <<<EOQ
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@1.3.3/dist/js/splide.min.js"></script>
EOQ;

$arAdditionalJs[] = <<<EOQ
var splide = new Splide( '.main-carousel', {
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

var splide2 = new Splide( '#main-carousel2', {
  pagination: false,
} );

var thumbnails = document.getElementsByClassName( 'thumbnail' );
var current;

for ( var i = 0; i < thumbnails.length; i++ ) {
  initThumbnail( thumbnails[ i ], i );
}

function initThumbnail( thumbnail, index ) {
  thumbnail.addEventListener( 'click', function () {
    splide2.go( index );
  } );
}

splide2.on( 'mounted move', function () {
  var thumbnail = thumbnails[ splide2.index ];

  if ( thumbnail ) {
  if ( current ) {
      current.classList.remove( 'is-active' );
  }

  thumbnail.classList.add( 'is-active' );
  current = thumbnail;
  }
} );

splide2.mount();
EOQ;

$arAdditionalJsOnLoad[] = <<<EOQ
  $('#searchForm #btnSubmit').click(function()
  {
    var formId = '#searchForm';
    var query = $(formId+' #query').val();

    if (query.length < 3)
    {
      throwError('Your search query is too short');
    }
    else if (query.length > 200)
    {
      throwError('Your search query is too long');
    }
    else
    {
      var categoryId = $(formId+' #category_id').val();
      url = 'listings?query='+query;
      if (categoryId.length == 36)
      {
        url += '&categoryId='+categoryId;
      }
      window.location.href = url;
    }
  });
EOQ;

require_once 'inc/foot.php';
?>