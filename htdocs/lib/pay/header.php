<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
require __DIR__ . '/vendor/autoload.php';
if (!defined('PAY_PAGE_CONFIG')) {
    define('PAY_PAGE_CONFIG', realpath('config.php'));
}