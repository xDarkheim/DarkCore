<?php
use Darkheim\Infrastructure\Http\JsonResponse;
define('access', 'api');

try {
	if(!@include(rtrim(str_replace('\\','/', dirname(__DIR__, 2)), '/') . '/includes/bootstrap/boot.php')) {
		throw new RuntimeException('Could not load Darkheim.');
	}

	if(!function_exists('apache_get_version')) {
		function apache_get_version() {
			if(!isset($_SERVER['SERVER_SOFTWARE']) || $_SERVER['SERVER_SOFTWARE']
				=== ''
			) {
				return '';
			}
			return $_SERVER['SERVER_SOFTWARE'];
		}
	}

	JsonResponse::send([
		'code' => 200,
		'apache' => apache_get_version(),
		'php' => PHP_VERSION,
		'darkheim' => __CMS_VERSION__,
	], 200);

} catch(Exception $ex) {
	JsonResponse::send(['code' => 500, 'error' => $ex->getMessage()], 500);
}