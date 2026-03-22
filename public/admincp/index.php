<?php

// access
define('access', 'admincp');

use Darkheim\Application\Admincp\AdmincpConfigurationChecker;
use Darkheim\Application\Admincp\AdmincpLayoutDataProvider;
use Darkheim\Application\Auth\AdminGuard;
use Darkheim\Infrastructure\View\ViewRenderer;

try {
    if (! @include('../../includes/bootstrap/boot.php')) {
        throw new RuntimeException('Could not load CMS.');
    }
    if (! isLoggedIn()) {
        redirect();
    }
    if (! AdminGuard::canAccess((string) ($_SESSION['username'] ?? ''))) {
        redirect();
    }
    new AdmincpConfigurationChecker()->ensureValid();
} catch (Exception $ex) {
    $errorPage = file_get_contents('../../includes/error.html');
    echo str_replace('{ERROR_MESSAGE}', $ex->getMessage(), $errorPage);
    die();
}

$currentModule      = (string) ($_REQUEST['module'] ?? '');
$layoutDataProvider = new AdmincpLayoutDataProvider();

$view = new ViewRenderer();
$view->render('admincp/layout', [
    'sidebarGroups' => $layoutDataProvider->sidebarGroups(),
    'currentModule' => $currentModule,
    'handler'       => $handler,
]);
