<?php
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

//FLUTTERWAVE
//LIVE
define('DEF_FLW_SECRET_KEY_LIVE', 'FLWSECK-dbb3f4abec3a322f27ef40c0451b1141-18a36a0d66evt-X');
define('DEF_FLW_ENCRYPTION_KEY_LIVE', 'dbb3f4abec3aaf55446769a5');
define('DEF_FLW_PUBLIC_KEY_LIVE', 'FLWPUBK-0abc7db9adfd0f8129f26e841bf979e0-X');
//TEST
define('DEF_FLW_SECRET_KEY_TEST', 'FLWSECK_TEST-a835f15eece4a85946ce27ff64799b57-X');
define('DEF_FLW_ENCRYPTION_KEY_TEST', 'FLWSECK_TEST71274229ef97');
define('DEF_FLW_PUBLIC_KEY_TEST', 'FLWPUBK_TEST-5829510b14a5c362ad61a97694948ea9-X');
//CURRENT
define('DEF_FLW_SECRET_KEY', DEF_FLW_SECRET_KEY_TEST);
define('DEF_FLW_ENCRYPTION_KEY', DEF_FLW_ENCRYPTION_KEY_TEST);
define('DEF_FLW_PUBLIC_KEY', DEF_FLW_PUBLIC_KEY_TEST);
define('DEF_FLW_PAYMENT_URL', 'https://api.flutterwave.com/v3/payments');
define('DEF_FLW_VERIFY_PAYMENT_URL', 'https://api.flutterwave.com/v3/transactions');
define('DEF_PAYMENT_REDIRECT_URL', DEF_FULL_ROOT_PATH.'/app/payments');

//PAYSTACK
//LIVE
define('DEF_PSK_SECRET_KEY_LIVE', 'sk_live_51cb4e5b6323279156fa005039c8da72da9c8109');
define('DEF_PSK_PUBLIC_KEY_LIVE', 'pk_live_e2e0fad26835862ba88a55e34850659519de4e57');
//TEST
define('DEF_PSK_SECRET_KEY_TEST', 'sk_test_3d7ca8dca8a56dde2e688bfacf5b4ad15176d1dd');
define('DEF_PSK_PUBLIC_KEY_TEST', 'pk_test_ed374e93dd5d7a4fa72629b7f13aec769b0c6c0b');
//CURRENT
define('DEF_PSK_SECRET_KEY', 'sk_test_3d7ca8dca8a56dde2e688bfacf5b4ad15176d1dd');
define('DEF_PSK_PAYMENT_URL', 'https://api.paystack.co/transaction/initialize');
define('DEF_PSK_VERIFY_PAYMENT_URL', 'https://api.paystack.co/transaction/verify');

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