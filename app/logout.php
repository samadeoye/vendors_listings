<?php
require_once '../inc/utils.php';

unset($_SESSION['user']);
session_destroy();

header('Location: '.DEF_FULL_BASE_PATH_URL);