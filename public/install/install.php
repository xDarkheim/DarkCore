<?php
/**
 * DarkCore
 *
 * @version 1.1.1
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 */

define('access', 'install');
if (! @include(__DIR__ . '/loader.php')) {
    die('Could not load DarkCore Installer.');
}

/** @var array $install */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DarkCore <?php echo INSTALLER_VERSION; ?> — Installer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo __INSTALL_URL__; ?>css/install.css?v=<?php echo @filemtime(__DIR__ . '/css/install.css'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo __BASE_URL__; ?>themes/default/favicon.ico">
</head>
<body>

<div class="install-container">

    <!-- Header -->
    <div class="install-header">
        <div class="install-logo">DK</div>
        <h1 class="install-title">DarkCore Installer</h1>
        <p class="install-subtitle">Version <?php echo INSTALLER_VERSION; ?></p>
    </div>

    <!-- Progress -->
    <div class="install-progress">
        <?php
        $currentStep = (int) ($_SESSION['install_cstep'] ?? 0);
for ($i = 1; $i <= 5; $i++) {
    $stepClass = 'progress-step';
    if ($i < $currentStep) {
        $stepClass .= ' done';
    } elseif ($i === $currentStep) {
        $stepClass .= ' active';
    }
    ?>
        <div class="<?php echo $stepClass; ?>"></div>
        <?php } ?>
    </div>

    <!-- Body -->
    <div class="install-body">
        <?php
    // ...existing code...
    if (isset($_GET['action']) && $_GET['action'] === 'restart') {
        include __INSTALL_ROOT__ . 'install_intro.php';
    } else {
        switch ($_SESSION['install_cstep'] ?? 0) {
            case 0:
                include __INSTALL_ROOT__ . 'install_intro.php';
                break;
            case 1:
                include __INSTALL_ROOT__ . 'install_step_1.php';
                break;
            case 2:
                include __INSTALL_ROOT__ . 'install_step_2.php';
                break;
            case 3:
                include __INSTALL_ROOT__ . 'install_step_3.php';
                break;
            case 4:
                include __INSTALL_ROOT__ . 'install_step_4.php';
                break;
            case 5:
                include __INSTALL_ROOT__ . 'install_step_5.php';
                break;
            default:
                include __INSTALL_ROOT__ . 'install_intro.php';
        }
    }
?>
    </div>

    <!-- Footer -->
    <div class="install-footer">
        DarkCore &copy; <?php echo date('Y'); ?> — Installer v<?php echo INSTALLER_VERSION; ?>
    </div>

</div>

<script>
// ...existing code...
</script>

</body>
</html>

