<?php
require_once '../inc/utils.php';
$pageTitle = 'Dashboard';
require_once 'inc/head.php';
use Lamba\Dashboard\DashboardAnalytics;
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
      
        <?php
            if (!Lamba\User\User::checkIfUserHasActiveSubscription())
            { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="notification error closeable margin-bottom-30">
                            <p>You currently do not have an active subscription. Please in as <strong><a href="app/payments">click here</a></strong> to pay</p>
                            <a class="close" href="#"></a> 
                        </div>
                    </div>
                </div>
            <?php
            }
        ?>
      
        <div class="row"> 
            <div class="col-lg-4 col-md-6">
                <div class="utf_dashboard_stat color-1">
                    <div class="utf_dashboard_stat_content">
                    <h4><?php echo DashboardAnalytics::getUserTotalListings(); ?></h4>
                    <span>Total Listings</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Align-JustifyRight"></i></div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="utf_dashboard_stat color-2">
                    <div class="utf_dashboard_stat_content">
                    <h4><?php echo DashboardAnalytics::getUserTotalViews(); ?></h4>
                    <span>Total Listings Views</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Eye-2"></i></div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="utf_dashboard_stat color-3">
                    <div class="utf_dashboard_stat_content">
                    <h4><?php echo DashboardAnalytics::getUserTotalComments(); ?></h4>
                    <span>Total Comments</span>
                    </div>
                    <div class="utf_dashboard_stat_icon"><i class="im im-icon-Technorati"></i></div>
                </div>
            </div>
        </div>

        <?php require_once 'inc/footer.php'; ?>

    </div>    
  </div>
</div>

<?php require_once 'inc/foot.php'; ?>