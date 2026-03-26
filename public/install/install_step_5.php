<?php
/**
 * DarkCore
 *
 * @version 1.1.1
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 */

use Darkheim\Infrastructure\Config\ConfigRepository;

if (! defined('access') || access !== 'install') {
    die();
}

/** @var array $install */

if (isset($_POST['install_step_5_submit'])) {
    try {
        if (! isset($_SESSION['install_sql_host'])) {
            throw new Exception('Database connection info missing. Restart the installation.');
        }
        if (! isset($_SESSION['install_sql_db1'])) {
            throw new Exception('Database connection info missing. Restart the installation.');
        }

        $cmsDefaultConfig['admins']                  = [$_SESSION['install_admin_user'] => 100];
        $cmsDefaultConfig['SQL_DB_HOST']             = $_SESSION['install_sql_host'];
        $cmsDefaultConfig['SQL_DB_NAME']             = $_SESSION['install_sql_db1'];
        $cmsDefaultConfig['SQL_DB_USER']             = $_SESSION['install_sql_user'];
        $cmsDefaultConfig['SQL_DB_PASS']             = $_SESSION['install_sql_pass'];
        $cmsDefaultConfig['SQL_DB_PORT']             = $_SESSION['install_sql_port'];
        $cmsDefaultConfig['SQL_PDO_DRIVER']          = $_SESSION['install_sql_dsn'] ?? 'mssql';
        $cmsDefaultConfig['SQL_PASSWORD_ENCRYPTION'] = $_SESSION['install_sql_passwd_encrypt'];
        $cmsDefaultConfig['SQL_SHA256_SALT']         = $_SESSION['install_sql_sha256_salt'];
        $cmsDefaultConfig['cms_installed']           = true;

        $configRepository = new ConfigRepository(dirname($cmsConfigsPath));
        $configRepository->saveCms($cmsDefaultConfig);

        $_SESSION = [];
        session_destroy();

        header('Location: ' . __BASE_URL__);
        die();

    } catch (Exception $ex) {
        echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($ex->getMessage()) . '</div>';
    }
}
?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-check-circle"></i> Installation Complete!</h2>
    <p class="step-description">Your DarkCore installation is ready. Review your settings below and click Finish.</p>

    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> All steps completed successfully!
    </div>

    <div class="info-box" style="margin-bottom: 20px;">
        <strong><i class="bi bi-person-circle"></i> Admin Account</strong><br>
        <div style="margin-top: 8px; font-size: 14px;">
            <strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['install_admin_user'] ?? ''); ?><br>
            <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['install_admin_email'] ?? ''); ?>
        </div>
    </div>

    <div class="info-box" style="margin-bottom: 20px;">
        <strong><i class="bi bi-database"></i> Database</strong><br>
        <div style="margin-top: 8px; font-size: 14px;">
            <strong>Host:</strong> <?php echo htmlspecialchars($_SESSION['install_sql_host'] ?? ''); ?><br>
            <strong>Port:</strong> <?php echo htmlspecialchars($_SESSION['install_sql_port'] ?? '1433'); ?><br>
            <strong>Database:</strong> <?php echo htmlspecialchars($_SESSION['install_sql_db1'] ?? ''); ?><br>
            <strong>Encryption:</strong> <?php echo htmlspecialchars($_SESSION['install_sql_passwd_encrypt'] ?? 'none'); ?>
        </div>
    </div>

    <div class="info-box">
        <strong><i class="bi bi-exclamation-triangle"></i> Important Notes</strong><br>
        <ul style="margin: 8px 0 0 0; padding-left: 20px;">
            <li>Write down your admin credentials — you'll need them to log in</li>
            <li>Delete the <code>public/install/</code> directory after installation</li>
            <li>Configure your email settings in the admin panel</li>
            <li>Set up cron jobs for automated tasks</li>
        </ul>
    </div>

    <form method="post" style="margin-top: 28px; margin-bottom: 4px;">
        <div class="btn-group">
            <button type="submit" name="install_step_5_submit" class="btn btn-primary">
                <i class="bi bi-arrow-right"></i> Finish Installation
            </button>
        </div>
    </form>
</div>
