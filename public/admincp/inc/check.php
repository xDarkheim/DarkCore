<?php
$configError = array();

$writablePaths = loadJsonFile(DARKHEIM_WRITABLE_PATHS);
if(!is_array($writablePaths)) {
        throw new RuntimeException('Could not load DarkCore writable paths list.');
}

// File permission check
foreach($writablePaths as $thisPath) {
	$fullPath = __ROOT_DIR__ . ltrim($thisPath, '/');
	if(file_exists($fullPath)) {
		if(!is_writable($fullPath)) {
			$configError[] = "<span style=\"color:#aaaaaa;\">[Permission Error]</span> " . $thisPath . " <span style=\"color:red;\">(file must be writable)</span>";
		}
	} else {
		$configError[] = "<span style=\"color:#aaaaaa;\">[Not Found]</span> " . $thisPath. " <span style=\"color:orange;\">(re-upload file)</span>";
	}
}

// Check cURL
if(!function_exists('curl_version')) {
	$configError[]
		= "<span style=\"color:#aaaaaa;\">[PHP]</span> <span style=\"color:green;\">cURL extension is not loaded (DarkCore requires cURL)</span>";
}

if(count($configError) >= 1) {
	throw new RuntimeException("<strong>The following errors ocurred:</strong><br /><br />" . implode("<br />", $configError));
}