<?php
require_once 'inc/utils.php';
$pageTitle = 'About';
require_once 'inc/head.php';
?>

<div id="titlebar" class="gradient margin-bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>About Us</h2>     
                <nav id="breadcrumbs">
                    <ul>
                    <li><a href="">Home</a></li>
                    <li>About Us</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="fullwidth_block" data-background-color="#fff"> 
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="headline_part centered margin-top-80">Who We Are <span class="margin-top-10"> Discover & connect with great customers and vendors </span> </h2>
            </div>
        </div>
        <div>
            <?=SITE_NAME;?> provides vendors dealing in the line of hair, jewelleries, skincare and perfumes a platform to explore in their line of business. With a reasonably low amount, you get to put your business to the world.<br>
            Be visible! Obtain new customers and generate more traffic. Improve social media engagement. Get reviews and grow business reputation online. Your company profile can include contacts and description, photo gallery and your business location.
        </div>
    </div>
</section>
  

<section class="fullwidth_block margin-top-20" data-background-color="#f9f9f9"> 
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="headline_part centered margin-top-80">How It Works? <span class="margin-top-10"> Get started in just a few steps </span> </h2>
            </div>
        </div>
        <div class="row container_icon"> 
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="box_icon_two box_icon_with_line"> <i class="im im-icon-Checked-User"></i>
                    <h3>Sign Up</h3>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="box_icon_two box_icon_with_line"> <i class="im im-icon-Credit-Card2"></i>
                    <h3>Make Payment</h3>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="box_icon_two"> <i class="im im-icon-Bulleted-List"></i>
                    <h3>Begin to List</h3>
                </div>
            </div>
        </div>
    </div>
</section>
  
<section class="fullwidth_block padding-top-75 padding-bottom-55" data-background-color="#fff"> 
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="headline_part centered margin-bottom-20">Choose Your Plan</h3>
            </div>
        </div>
        <div class="row">        
            <div class="utf_pricing_container_block margin-top-30 margin-bottom-20"> 
                <div class="plan featured col-md-4 col-sm-6 col-xs-12">
                    <div class="utf_price_plan">
                        <h3>Annual</h3>
                        <span class="value">NGN <?=doNumberFormat(DEF_ANNUAL_PLAN_FEE);?> <span>/ Year</span></span> 
                    </div>
                    <div class="utf_price_plan_features">
                        <ul>
                            <li>Paid yearly</li>
                            <li>Multiple Listings</li>
                            <li>Featured In Search Results</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a class="button border" href="app/login"><i class="sl sl-icon-cursor"></i> Get Started </a>
                    </div>
                </div>

                <div class="plan featured col-md-4 col-sm-6 col-xs-12">
                    <div class="utf_price_plan">
                        <h3>6 Months</h3>
                        <span class="value">NGN <?=doNumberFormat(DEF_SIX_MONTHS_PLAN_FEE);?> <span>/ 6 Months</span></span> 
                    </div>
                    <div class="utf_price_plan_features">
                        <ul>
                            <li>Paid Every 6 Months</li>
                            <li>Multiple Listings</li>
                            <li>Featured In Search Results</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a class="button border" href="app/login"><i class="sl sl-icon-cursor"></i> Get Started </a>
                    </div>
                </div>
            
                <div class="plan featured col-md-4 col-sm-6 col-xs-12 active">
                    <div class="utf_price_plan">
                        <h3>Monthly</h3>
                        <span class="value">NGN <?=doNumberFormat(DEF_MONTHLY_PLAN_FEE);?> <span>/ Month</span></span>
                    </div>
                    <div class="utf_price_plan_features">
                        <ul>
                            <li>Paid monthly</li>
                            <li>Multiple Listings</li>
                            <li>Featured In Search Results</li>
                            <li>24/7 Support</li>
                        </ul>
                        <a class="button border" href="app/login"><i class="sl sl-icon-cursor"></i> Get Started </a>
                    </div>
                </div>
               
            </div>       
        </div>     
    </div>    
</section>

<?php
require_once 'inc/foot.php';
?>