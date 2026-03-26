<?php
/**
 * DarkCore
 *
 * @version 1.1.1
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 */
if (! defined('access') || access !== 'install') {
    die();
}

/** @var array $install */

if (isset($_POST['install_step_2_submit'])) {
    try {
        if (empty($_POST['install_step_2_1'])) {
            throw new Exception('Database host is required.');
        }
        if (empty($_POST['install_step_2_7'])) {
            throw new Exception('Database port is required.');
        }
        if (empty($_POST['install_step_2_2'])) {
            throw new Exception('Database username is required.');
        }
        if (! isset($_POST['install_step_2_3'])) {
            throw new Exception('Database password field is required.');
        }
        if (empty($_POST['install_step_2_4'])) {
            throw new Exception('Database name is required.');
        }
        if (! isset($_POST['install_step_2_6']) || ! in_array(
            strtolower($_POST['install_step_2_6']),
            $install['PDO_PWD_ENCRYPT'],
            true,
        )
        ) {
            throw new Exception('You must select a password encryption method.');
        }
        $_SESSION['install_sql_host']           = trim($_POST['install_step_2_1']);
        $_SESSION['install_sql_port']           = trim($_POST['install_step_2_7']);
        $_SESSION['install_sql_user']           = trim($_POST['install_step_2_2']);
        $_SESSION['install_sql_pass']           = $_POST['install_step_2_3'];
        $_SESSION['install_sql_db1']            = trim($_POST['install_step_2_4']);
        $_SESSION['install_sql_passwd_encrypt'] = strtolower($_POST['install_step_2_6']);
        $_SESSION['install_sql_sha256_salt']    = $_POST['install_step_2_9'] ?? '';
        /** @phpstan-ignore-next-line */
        $db1 = new dB($_SESSION['install_sql_host'], $_SESSION['install_sql_port'], $_SESSION['install_sql_db1'], $_SESSION['install_sql_user'], $_SESSION['install_sql_pass']);
        if ($db1->dead) {
            throw new Exception('Could not connect to database. Check your credentials.');
        }
        $_SESSION['install_cstep']++;
        header('Location: install.php');
        die();
    } catch (Exception $ex) {
        echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($ex->getMessage()) . '</div>';
    }
}
?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-database-gear"></i> Database Connection</h2>
    <p class="step-description">Configure your MSSQL database connection details.</p>

    <form method="post">
        <div class="form-group">
            <label for="host">Database Host</label>
            <input type="text" id="host" name="install_step_2_1" class="form-control" 
                   placeholder="localhost" value="<?php echo htmlspecialchars($_SESSION['install_sql_host'] ?? ''); ?>" required>
            <small style="color: var(--tx-3); margin-top: 4px; display: block;">IP address or hostname of your MSSQL server</small>
        </div>

        <div class="form-group">
            <label for="port">Database Port</label>
            <input type="number" id="port" name="install_step_2_7" class="form-control" 
                   placeholder="1433" value="<?php echo htmlspecialchars($_SESSION['install_sql_port'] ?? '1433'); ?>" required>
            <small style="color: var(--tx-3); margin-top: 4px; display: block;">Default MSSQL port is 1433</small>
        </div>

        <div class="form-group">
            <label for="user">Database Username</label>
            <input type="text" id="user" name="install_step_2_2" class="form-control" 
                   placeholder="sa" value="<?php echo htmlspecialchars($_SESSION['install_sql_user'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="pass">Database Password</label>
            <input type="password" id="pass" name="install_step_2_3" class="form-control" 
                   value="<?php echo htmlspecialchars($_SESSION['install_sql_pass'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="db">Database Name</label>
            <input type="text" id="db" name="install_step_2_4" class="form-control" 
                   placeholder="DarkCore" value="<?php echo htmlspecialchars($_SESSION['install_sql_db1'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="encrypt">Password Encryption</label>
            <select id="encrypt" name="install_step_2_6" class="form-control" required>
                <option value="">Select encryption method...</option>
                <?php foreach ($install['PDO_PWD_ENCRYPT'] as $method): ?>
                <option value="<?php echo htmlspecialchars($method); ?>" 
                    <?php echo (($_SESSION['install_sql_passwd_encrypt'] ?? '') === $method) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($method); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="salt">SHA256 Salt <small style="color: var(--tx-3);">(Optional)</small></label>
            <input type="text" id="salt" name="install_step_2_9" class="form-control" 
                   placeholder="Leave empty to generate automatically" 
                   value="<?php echo htmlspecialchars($_SESSION['install_sql_sha256_salt'] ?? ''); ?>">
        </div>

        <div class="info-box">
            <strong><i class="bi bi-info-circle"></i> Connection Test</strong><br>
            We'll test the connection before proceeding to the next step.
        </div>

        <div class="btn-group" style="margin-top: 28px;">
            <button type="submit" name="install_step_2_submit" class="btn btn-primary">
                <i class="bi bi-arrow-right"></i> Test & Continue
            </button>
        </div>
    </form>
</div>
