<?php
if (!isset($_SESSION['user']))
{
  blockOutToMainPage();
}
$arSidebarCurrentPage = getSidebarCurrentPage($pageTitle);
?>

<!DOCTYPE html>
<html lang="eng">
<head>
<meta name="author" content="">
<meta name="description" content="">
<base href="<?php echo DEF_ROOT_PATH; ?>/">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=SITE_NAME; ?> - <?=$pageTitle; ?></title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.png">
<!-- Style CSS -->
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/mmenu.css">
<link rel="stylesheet" href="css/perfect-scrollbar.css">
<link rel="stylesheet" href="css/style.css" id="colors">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&amp;display=swap&amp;subset=latin-ext,vietnamese" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<?php
if (count($arAdditionalCSS) > 0)
{
  echo implode(PHP_EOL, $arAdditionalCSS);
}
?>
</head>

<!-- Preloader Start -->
<div class="preloader">
    <div class="utf-preloader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- Preloader End -->

<!-- Wrapper -->
<div id="main_wrapper"> 
  <header id="header_part" class="fixed fullwidth_block dashboard"> 
    <div id="header" class="not-sticky">
      <div class="container"> 
        <div class="utf_left_side"> 
          <div id="logo"> <a href="<?DEF_ROOT_PATH; ?>"><img src="images/woara/woara-logo.png" alt="<?=SITE_NAME;?>"></a> <a href="<?=DEF_ROOT_PATH;?>" class="dashboard-logo"><img src="images/woara/woara-logo.png" alt=""></a> </div>
          <div class="mmenu-trigger">
            <button class="hamburger utfbutton_collapse" type="button">
              <span class="utf_inner_button_box">
                <span class="utf_inner_section"></span>
              </span>
            </button>
          </div>
          <nav id="navigation" class="style_one">
            <ul id="responsive">
              <li><a href="<?=DEF_ROOT_PATH;?>">Home</a></li>
              <li><a href="listings">Listings</a></li>
              <li><a href="about">About</a></li>
              <li><a href="contact">Contact</a></li>
            </ul>
          </nav>
          <div class="clearfix"></div>
        </div>
        <div class="utf_right_side"> 
          <div class="header_widget"> 
            <div class="utf_user_menu">
              <div class="utf_user_name"><span><img src="images/woara/dash_avatar.png" alt="User Img"></span>Hi, <?=stringToTitle($arUser['fname']);?>!</div>
                <ul>
                  <li><a href="app/profile"><i class="sl sl-icon-user"></i> My Profile</a></li>
                  <li id="logoutHeaderBtn"><a><i class="sl sl-icon-power"></i> Logout</a></li>
                </ul>
              </div>
            </div>
        </div>
      </div>
    </div>
  </header>
  <div class="clearfix"></div>