<?php
$pageTitle = 'Listings';
require_once 'inc/head.php';
?>

<div id="utf_listing_gallery_part" class="utf_listing_section">
    <div class="utf_listing_slider utf_gallery_container margin-bottom-0"> 
		<a href="images/single-listing-01.jpg" data-background-image="images/single-listing-01.jpg" class="item utf_gallery"></a> 
		<a href="images/single-listing-02.jpg" data-background-image="images/single-listing-02.jpg" class="item utf_gallery"></a>
	</div>
</div>

<div class="container">
    <div class="row utf_sticky_main_wrapper">
        <div class="col-lg-8 col-md-8">
        <div id="titlebar" class="utf_listing_titlebar">
            <div class="utf_listing_titlebar_title">
                <h2>The Hot and More Restaurant <span class="listing-tag">Restaurant</span></h2>		   
                <span> <a href="#utf_listing_location" class="listing-address"> <i class="sl sl-icon-location"></i> The Ritz-Carlton, Hong Kong </a> </span>			
                <span class="call_now"><i class="sl sl-icon-phone"></i> (415) 796-3633</span>
                <span class="call_now"><i class="fa fa-envelope-o"></i> <a href="mailto:info@example.com">info@example.com</a></span>
            </div>
        </div>
        <div id="utf_listing_overview" class="utf_listing_section">
            <h3 class="utf_listing_headline_part margin-top-30 margin-bottom-30">Listing Description</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam. Sed tempor iaculis massa faucibus feugiat. In fermentum facilisis massa, a consequat purus viverra.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam.</p>
        </div>
        
        <div id="utf_listing_reviews" class="utf_listing_section">
            <h3 class="utf_listing_headline_part margin-top-75 margin-bottom-20">Comments <span>(08)</span></h3>
            <div class="clearfix"></div>

            <div class="comments utf_listing_reviews">
                <ul>
                    <li>
                        <div class="avatar"><img src="images/client-avatar1.jpg" alt="" /></div>
                        <div class="utf_comment_content">
                            <div class="utf_arrow_comment"></div>
                            <div class="utf_star_rating_section" data-rating="5"></div>              
                            <div class="utf_by_comment">
                                Francis Burton<span class="date"><i class="fa fa-clock-o"></i> Jan 05, 2022 - 8:52 am</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat.</p>                                  
                        </div>
                    </li>
                    <li>
                        <div class="avatar"><img src="images/client-avatar3.jpg" alt="" /> </div>
                        <div class="utf_comment_content">
                            <div class="utf_arrow_comment"></div>
                            <div class="utf_star_rating_section" data-rating="4"></div>                  
                            <div class="utf_by_comment">
                                Francis Burton<span class="date"><i class="fa fa-clock-o"></i> Jan 05, 2022 - 8:52 am</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat.</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="utf_pagination_container_part margin-top-30">
                        <nav class="pagination">
                        <ul>
                            <li><a href="#"><i class="sl sl-icon-arrow-left"></i></a></li>
                            <li><a href="#" class="current-page">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
                        </ul>
                        </nav>
                    </div>
                </div>
            </div>
          <div class="clearfix"></div>
        </div>
        <div id="utf_add_review" class="utf_add_review-box">
            <h3 class="utf_listing_headline_part margin-bottom-20">Add Your Review</h3>
            <span class="utf_leave_rating_title">Your email address will not be published.</span>
            <form id="utf_add_comment" class="utf_add_comment">
                <fieldset>
                <div class="row">
                    <div class="col-md-6">
                    <label>Name:</label>
                    <input type="text" placeholder="Name" value=""/>
                    </div>
                    <div class="col-md-6">
                    <label>Email:</label>
                    <input type="text" placeholder="Email" value=""/>
                    </div>
                </div>
                <div>
                    <label>Review:</label>
                    <textarea cols="40" placeholder="Your Message..." rows="3"></textarea>
                </div>
                </fieldset>
                <button class="button">Submit Review</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
      
    <!-- Sidebar -->
    <div class="col-lg-4 col-md-4 margin-top-45 sidebar-search">
        <div class="utf_box_widget margin-top-35">
            <h3><i class="sl sl-icon-phone"></i> Contact Info</h3>
            <div class="utf_hosted_by_user_title">
                <a href="#" class="utf_hosted_by_avatar_listing"><img src="images/dashboard-avatar.jpg" alt=""></a>
                <h4><a href="#">Kathy Brown</a><span>Posted on 20.05.2023</span></h4>
            </div>
            <ul class="utf_social_icon rounded margin-top-10">
                <li><a class="facebook" href="#"><i class="icon-facebook"></i></a></li>
                <li><a class="instagram" href="#"><i class="icon-instagram"></i></a></li>
                <li><a class="twitter" href="#"><i class="icon-twitter"></i></a></li>         
            </ul>
            <ul class="utf_listing_detail_sidebar">
                <li><i class="sl sl-icon-map"></i> 12345 Little Lonsdale St, Melbourne</li>
                <li><i class="sl sl-icon-phone"></i> +(012) 1123-254-456</li>
                <li><i class="fa fa-envelope-o"></i> <a href="mailto:info@example.com">info@example.com</a></li>
            </ul>  
        </div>
        <div class="utf_box_widget margin-top-35">
            <h3><i class="sl sl-icon-folder-alt"></i> Categories</h3>
            <ul class="utf_listing_detail_sidebar">
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Travel</a></li>
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Nightlife</a></li>
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Fitness</a></li>
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Real Estate</a></li>
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Restaurant</a></li>
                <li><i class="fa fa-angle-double-right"></i> <a href="#">Dance Floor</a></li>
            </ul>
        </div>

    </div>
  </div>

<?php
require_once 'inc/foot.php';
?>