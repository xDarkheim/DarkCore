<?php
use Darkheim\Infrastructure\Http\JsonResponse;
define('access', 'api');

if(!@include('../../includes/bootstrap/boot.php')) {
	JsonResponse::send(['code' => 500, 'error' => 'Could not load Darkheim CMS.'], 500);
	return;
}

JsonResponse::send([
	'code' => 200,
	'ServerTime' => date("Y/m/d H:i:s"),
], 200);
