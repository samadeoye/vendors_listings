<?php
require_once '../inc/utils.php';
$pageTitle = 'Login';
require_once DEF_DOC_ROOT.'inc/head.php';
?>

<div id="titlebar" class="gradient margin-bottom-0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Login</h2>     
                <nav id="breadcrumbs">
                    <ul>
                    <li><a href="">Home</a></li>
                    <li>Login</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<section class="fullwidth_block" data-background-color="#fff">
    <div class="container">
        <div class="row margin-top-50">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="utf_signin_form">
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
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="email">
                                    <input type="text" class="input-text" name="email" id="email" value="" placeholder="Email" />
                                </label>
                                </p>
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="password">
                                    <input class="input-text" type="password" name="password" id="password" placeholder="Password"/>
                                </label>
                                </p>
                                <div class="utf_row_form utf_form_wide_blockX form_forgot_part">
                                <span class="lost_password fl_left"> <a href="app/forgotpass">Forgot Password?</a> </span>
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
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="fname">
                                    <input type="text" class="input-text" name="fname" id="fname" placeholder="First Name" />
                                </label>
                                </p>
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="lname">
                                    <input type="text" class="input-text" name="lname" id="lname" placeholder="Last Name" />
                                </label>
                                </p>
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="email">
                                    <input type="text" class="input-text" name="email" id="email" placeholder="Email" />
                                </label>
                                </p>
                                <p class="utf_row_form utf_form_wide_blockX">
                                <label for="password1">
                                    <input class="input-text" type="password" name="password1" id="password1" placeholder="Password" />
                                </label>
                                </p>
                                <p class="utf_row_form utf_form_wide_blockX">
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
            <div class="col-md-2"></div>
        </div>

    </div>
</section>

<?php
require_once DEF_DOC_ROOT.'inc/foot.php';
?>