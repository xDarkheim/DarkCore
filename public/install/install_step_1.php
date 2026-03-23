<?php
/**
 * DarkCore
 *
 * @version 1.1.0
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 */

if (! defined('access') || access !== 'install') {
    die();
}

/** @var array|null $writablePaths */

if (isset($_POST['install_step_1_submit'])) {
    try {
        $_SESSION['install_cstep']++;
        header('Location: install.php');
        die();
    } catch (Exception $ex) {
        echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($ex->getMessage()) . '</div>';
    }
}

function reqRow($label, $ok, $note = ''): void
{
    $status = $ok ? 'success' : 'error';
    $icon   = $ok ? '✓' : '✕';
    echo '<li class="' . $status . '">';
    echo htmlspecialchars($label);
    if ($note) {
        echo ' <small style="color:var(--tx-3)">(' . htmlspecialchars($note) . ')</small>';
    }
    echo '</li>';
}

function optRow($label, $ok, $optNote = 'Optional'): void
{
    $status = $ok ? 'success' : 'warning';
    echo '<li class="' . $status . '">';
    echo htmlspecialchars($label) . ' — ' . htmlspecialchars($optNote);
    echo '</li>';
}
?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-cpu"></i> System Requirements</h2>
    <p class="step-description">Checking your server configuration...</p>

    <div class="info-box" style="margin-bottom: 20px;">
        <strong>PHP Extensions</strong><br>
        <div style="margin-top: 8px; margin-bottom: 10px; color: var(--tx-2); font-size: 12.5px;">
            Only extensions actually required by DarkCore and its Docker image are checked here.
        </div>
        <ul class="checklist" style="margin-top: 10px;">
            <?php
            reqRow('PHP Version ' . PHP_VERSION, PHP_VERSION_ID >= 80400, 'PHP 8.4+');
reqRow('PDO (Database)', extension_loaded('pdo'), 'Required for database access');
reqRow('PDO MSSQL (FreeTDS)', extension_loaded('pdo_dblib'), 'Required for SQL Server');
reqRow('JSON', extension_loaded('json'), 'Required for configuration');
optRow('Curl', extension_loaded('curl'), 'For email/HTTP requests');
?>
        </ul>
    </div>

    <div class="info-box">
        <strong>File Permissions</strong><br>
        <ul class="checklist" style="margin-top: 10px;">
            <?php
$writablePaths = json_decode(file_get_contents(__PATH_CONFIGS__ . CMS_WRITABLE_PATHS_FILE), true);
if (is_array($writablePaths)) {
    foreach ($writablePaths as $path) {
        $fullPath   = __ROOT_DIR__ . $path;
        $isWritable = is_writable($fullPath);
        reqRow($path, $isWritable, $isWritable ? 'writable' : 'not writable');
    }
}
?>
        </ul>
    </div>

    <div class="btn-group" style="margin-top: 28px;">
        <form method="post" style="flex: 1;">
            <button type="submit" name="install_step_1_submit" class="btn btn-primary btn-block">
                <i class="bi bi-arrow-right"></i> Continue
            </button>
        </form>
    </div>
</div>
