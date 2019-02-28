<?php
/**
 * 统一访问入口
 */
header('Access-Control-Allow-Origin:*');

require_once dirname(__FILE__) . '/init.php';

$pai = new \PhalApi\PhalApi();
$pai->response()->output();

