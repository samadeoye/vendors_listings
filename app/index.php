<?php
$pageTitle = 'Dashboard';
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
                        <li>Dashboard</li>
                    </ul>
                    </nav>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-12">
                <div class="notification success closeable margin-bottom-30">
                    <p>You are currently signed in as <strong>Jonathon Cristy</strong> Has Been Approved!</p>
                    <a class="close" href="#"></a> 
                </div>
            </div>
        </div>
      
        <div class="row"> 
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-1">
                    <div class="utf_dashboard_stat_content">
                    <h4>36</h4>
                    <span>Published Listings</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Map2"></i></div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-2">
                    <div class="utf_dashboard_stat_content">
                    <h4>615</h4>
                    <span>Pending Listings</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Add-UserStar"></i></div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-3">
                    <div class="utf_dashboard_stat_content">
                    <h4>9128</h4>
                    <span>Expired Listings</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Align-JustifyRight"></i></div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-4">
                    <div class="utf_dashboard_stat_content">
                    <h4>572</h4>
                    <span>New Feedbacks</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Diploma"></i></div>
                </div>
            </div>
        
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-5">
                    <div class="utf_dashboard_stat_content">
                    <h4>572</h4>
                    <span>Total Views</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Eye-Visible"></i></div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <div class="utf_dashboard_stat color-6">
                    <div class="utf_dashboard_stat_content">
                    <h4>572</h4>
                    <span>Total Reviews</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Star"></i></div>
                </div>
            </div>
        </div>

        <?php require_once 'inc/footer.php'; ?>

    </div>    
  </div>
</div>

<?php require_once 'inc/foot.php'; ?>