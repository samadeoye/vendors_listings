<?php
require_once 'config.php';
define('SITE_NAME', 'WoAra');
define('SITE_ABR', 'WOA');
//define('SITE_URL', 'https://woara.ng');
define('SITE_URL', 'http://localhost/woara');
define('SITE_DOMAIN', 'woara.ng');
define('SITE_EMAIL', 'info@woara.ng');
define('SITE_PHONE', '+2348177196362');
define('SITE_ADDRESS', 'Ibadan, Nigeria');
define('SITE_MAIL_FROM_EMAIL', SITE_EMAIL);
define('SITE_MAIL_FROM_NAME', SITE_NAME);
define('DEF_CURRENCY_CODE', 'NGN');

define('DEF_KB', 1024);
define('DEF_MB', 1048576);
define('DEF_ANNUAL_PLAN_FEE', 10000);
define('DEF_MONTHLY_PLAN_FEE', 1000);

//TABLES
define('DEF_TBL_USERS', 'users');
define('DEF_TBL_GALLERY', 'gallery');
define('DEF_TBL_BUSINESS_TYPES', 'business_types');
define('DEF_TBL_LISTINGS', 'listings');
define('DEF_TBL_LISTINGS_COMMENTS', 'listings_comments');
define('DEF_TBL_PAYMENTS', 'payments');
define('DEF_TBL_PAYMENT_PLANS', 'payment_plans');
define('DEF_TBL_CONTACTS', 'contacts');
define('DEF_TBL_PASSWORD_RESET', 'password_reset');
?>