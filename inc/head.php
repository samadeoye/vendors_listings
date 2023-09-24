<?php
$arCurrentPage = getCurrentPage($pageTitle);
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
<link rel="shortcut icon" href="images/woara/woara-logo.png">
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
  <header id="header_part" class="fullwidth"> 
    <div id="header">
      <div class="container"> 
        <div class="utf_left_side"> 
          <div id="logo"> <a href="<?=DEF_ROOT_PATH;?>"><img src="images/woara/woara-logo.png" alt="Logo"></a> </div>
          <div class="mmenu-trigger">
            <button class="hamburger utfbutton_collapse" type="button">
              <span class="utf_inner_button_box">
                <span class="utf_inner_section"></span>
              </span>
            </button>
          </div>
          <nav id="navigation" class="style_one">
            <ul id="responsive">
              <li><a class="<?=$arCurrentPage['home'];?>" href="<?=DEF_ROOT_PATH;?>">Home</a></li>
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
              <a href="app/login" class="button border"><i class="fa fa-sign-in"></i> Sign In</a>
            <?php
            }
            ?>
          </div>
        </div>

      </div>
    </div>    
  </header>
  <div class="clearfix"></div>