<?php
$pageTitle = 'Home';
require_once 'inc/head.php';
use Lamba\BusinessType\BusinessType;
use Lamba\Listing\Listing;
use Lamba\User\User;

?>

<div class="search_container_block home_main_search_part main_search_block" data-background-image="images/city_search_background.jpg">
  <div class="main_inner_search_block">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Best Place For <span class="typed-words"></span></h2>
          <h4>Find verified hair vendors for all your hair related needs.</h4>
          <div class="main_input_search_part">
            <div class="main_input_search_part_item">
              <input type="text" placeholder="What are you looking for?" value=""/>
            </div>
            <div class="main_input_search_part_item intro-search-field">
              <select class="selectpicker default" data-live-search="true" data-selected-text-format="count" data-size="5" title="Select Location">
                <option>Afghanistan</option>
                <option>Albania</option>
                <option>Algeria</option>
                <option>Brazil</option>
                <option>Burundi</option>
                <option>Bulgaria</option>
                <option>Germany</option>
                <option>Grenada</option>
                <option>Guatemala</option>
                <option>Iceland</option>
              </select>
            </div>
            <div class="main_input_search_part_item intro-search-field">
              <select data-placeholder="All Categories" class="selectpicker default" title="All Categories" data-live-search="true" data-selected-text-format="count" data-size="5">
                <option>Food & Restaurants </option>
                <option>Shop & Education</option>
                <option>Education</option>
                <option>Business</option>
                <option>Events</option>
              </select>
            </div>
            <button class="button" onclick="">Search</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container padding-bottom-70">
  <div class="row">
    <div class="col-md-12">
      <h3 class="headline_part centered margin-bottom-35 margin-top-70">Categories <span>Discover the vendors based on your needs.</span></h3>
    </div>
    <?php
      $arBusinessTypes = BusinessType::getBusinessTypesWithCounts();
      if (count($arBusinessTypes) > 0)
      {
        foreach ($arBusinessTypes as $r)
        { ?>
          <div class="col-md-4 col-sm-6 col-xs-12"> 
            <a href="listings_list_with_sidebar.html" class="img-box" data-background-image="images/woara/<?=$r['img'];?>">
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
        <img src="" alt="<?=SITE_NAME; ?> Logo">
      </div>
      
      <div class="col-md-7 col-sm-6 col-xs-12">
        <?=SITE_NAME;?> provides vendors in the line of <b>hair (sales, rentals & partnerships)</b>, jewelleries, skincare and perfumes a platform to explore in their line of business. With a reasonably low amount, you get to put your business to the world.<br>
        Be visible! Obtain new customers and generate more traffic. Improve social media engagement. Get reviews and grow business reputation online. Your company profile can include contacts and description, photo gallery and your business location.
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
              foreach($arListings as $r)
              {
                $rs = User::getUser($r['user_id'], ['business_type_id', 'business_name']);
                $rsx = BusinessType::getBusinessType($rs['business_type_id'], ['name']);
                $businessType = $rsx['name'];
                $coverImgFileName = !empty($r['cover_img']) ? $r['cover_img'] : 'dummy.jpg';
                $shortDesc = !empty($r['short_desc']) ? $r['short_desc'] : substr($r['full_desc'], 0, 200).'...';
                ?>
                <div class="utf_carousel_item">
                  <a href="listing?id=<?=$r['id'];?>" class="utf_listing_item-container compact">
                    <div class="utf_listing_item"> <img src="images/woara/users/<?=$coverImgFileName;?>" alt=""> <span class="tag"> <?=$businessType;?> </span>
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
                  <div><?=$shortDesc;?></div>
                </div>
              <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<a href="" class="flip-banner parallax" data-background="images/slider-bg-02.jpg" data-color="#000" data-color-opacity="0.85" data-img-width="2500" data-img-height="1666">
  <div class="flip-banner-content">
  <h2 class="flip-visible">Browse Vendors List</h2>
  </div>
</a>

<?php
$arAdditionalJs[] = <<<EOQ
  var typed = new Typed('.typed-words', {
  strings: ["Hair Sales"," Hair Rentals"," Hair Business Partnership","Jewelleries","Skincare","Perfumes"],
    typeSpeed: 80,
    backSpeed: 80,
    backDelay: 4000,
    startDelay: 1000,
    loop: true,
    showCursor: true
  });
EOQ;
require_once 'inc/foot.php';
?>