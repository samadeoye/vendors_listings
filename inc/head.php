<?php
require_once 'utils.php';
$arCurrentPage = getCurrentPage($pageTitle);
?>

<!DOCTYPE html>
<html lang="eng">

<head>
<meta name="author" content="">
<meta name="description" content="">
<base href="<?php echo DEF_FULL_BASE_PATH_URL; ?>">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=SITE_NAME; ?> - <?=$pageTitle; ?></title>

<!-- Favicon -->
<link rel="shortcut icon" href="images/favicon.png">
<!-- Style CSS -->
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/mmenu.css">
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
<body class="header-one">

<!-- Preloader Start -->
<!-- <div class="preloader">
    <div class="utf-preloader">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div> -->
<!-- Preloader End -->

<!-- Wrapper -->
<div id="main_wrapper">
  <header id="header_part" class="fullwidth"> 
    <div id="header">
      <div class="container"> 
        <div class="utf_left_side"> 
          <div id="logo"> <a href="<?=DEF_FULL_BASE_PATH_URL;?>"><img src="images/logo.png" alt="Logo"></a> </div>
          <div class="mmenu-trigger">
            <button class="hamburger utfbutton_collapse" type="button">
              <span class="utf_inner_button_box">
                <span class="utf_inner_section"></span>
              </span>
            </button>
          </div>
          <nav id="navigation" class="style_one">
            <ul id="responsive">
              <li><a class="<?=$arCurrentPage['home'];?>" href="<?=DEF_FULL_BASE_PATH_URL;?>">Home</a></li>
              <li><a class="<?=$arCurrentPage['listings'];?>" href="listings">Listings</a></li>
              <li><a class="<?=$arCurrentPage['about'];?>" href="about">About</a></li>
              <li><a class="<?=$arCurrentPage['contact'];?>" href="contact">Contact</a></li>
            </ul>
          </nav>
          <div class="clearfix"></div>
        </div>
        <div class="utf_right_side">
          <div class="header_widget">
            <?php
            if (isset($_SESSION['user']))
            { ?>
              <a href="app/" class="button border with-icon"><i class="sl sl-icon-user"></i> Dashboard</a>
            <?php
            }
            else
            { ?>
              <a href="#dialog_signin_part" class="button border sign-in popup-with-zoom-anim"><i class="fa fa-sign-in"></i> Sign In</a>
            <?php
            }
            ?>
          </div>
        </div>
        
        <div id="dialog_signin_part" class="dialog_signin_part zoom-anim-dialog mfp-hide">
          <div class="small_dialog_header">
            <h3>Sign In</h3>
          </div>
          <div class="utf_signin_form style_one">
            <ul class="utf_tabs_nav">
              <li class=""><a href="#tab1">Log In</a></li>
              <li><a href="#tab2">Register</a></li>
            </ul>
            <div class="tab_container alt"> 
              <div class="tab_content" id="tab1" style="display:none;">
                <form method="post" class="login" id="loginForm" onsubmit="return false;">
                  <?php
                    echo getAlertWrapper('alert_login');
                  ?>
                  <input type="hidden" name="action" id="action" value="login">
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="email">
                      <input type="text" class="input-text" name="email" id="email" value="" placeholder="Email" />
                    </label>
                  </p>
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="password">
                      <input class="input-text" type="password" name="password" id="password" placeholder="Password"/>
                    </label>
                  </p>
                  <div class="utf_row_form utf_form_wide_block form_forgot_part">
                    <span class="lost_password fl_left"> <a href="javascript:void(0);">Forgot Password?</a> </span>
                  </div>
                  <div class="utf_row_form">
                    <button class="button border fw margin-top-10" id="btnSubmit">Login</button>
                  </div>
                </form>
              </div>
              
              <div class="tab_content" id="tab2" style="display:none;">
                <form method="post" class="register" id="registerForm" onsubmit="return false;">
                  <?php
                    echo getAlertWrapper('alert_register');
                  ?>
                  <input type="hidden" name="action" id="action" value="register">
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="fname">
                      <input type="text" class="input-text" name="fname" id="fname" placeholder="First Name" />
                    </label>
                  </p>
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="lname">
                      <input type="text" class="input-text" name="lname" id="lname" placeholder="Last Name" />
                    </label>
                  </p>
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="email">
                      <input type="text" class="input-text" name="email" id="email" placeholder="Email" />
                    </label>
                  </p>
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="password1">
                      <input class="input-text" type="password" name="password1" id="password1" placeholder="Password" />
                    </label>
                  </p>
                  <p class="utf_row_form utf_form_wide_block">
                    <label for="password2">
                      <input class="input-text" type="password" name="password2" id="password2" placeholder="Confirm Password" />
                    </label>
                  </p>
                  <button class="button border fw margin-top-10" id="btnSubmit">Register</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>    
  </header>
  <div class="clearfix"></div>