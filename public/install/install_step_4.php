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

try {
    if (isset($_POST['install_step_4_submit'])) {
        if (! isset($_POST['install_step_4_error'])) {
            if (empty($_POST['install_step_4_1'])) {
                throw new Exception('Admin username is required.');
            }
            if (empty($_POST['install_step_4_2'])) {
                throw new Exception('Admin password is required.');
            }
            if (empty($_POST['install_step_4_3'])) {
                throw new Exception('Admin email is required.');
            }

            $_SESSION['install_admin_user']  = trim($_POST['install_step_4_1']);
            $_SESSION['install_admin_pass']  = $_POST['install_step_4_2'];
            $_SESSION['install_admin_email'] = trim($_POST['install_step_4_3']);

            $_SESSION['install_cstep']++;
            header('Location: install.php');
            die();
        }
    }
    ?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-person-check"></i> Create Admin Account</h2>
    <p class="step-description">Set up the main administrator account for DarkCore.</p>

    <form method="post">
        <div class="form-group">
            <label for="admin_user">Admin Username</label>
            <input type="text" id="admin_user" name="install_step_4_1" class="form-control" 
                   placeholder="administrator" value="<?php echo htmlspecialchars($_SESSION['install_admin_user'] ?? ''); ?>" required>
            <small style="color: var(--tx-3); margin-top: 4px; display: block;">Must be unique and contain 3-20 characters</small>
        </div>

        <div class="form-group">
            <label for="admin_pass">Admin Password</label>
            <input type="password" id="admin_pass" name="install_step_4_2" class="form-control" 
                   placeholder="••••••••" required>
            <small style="color: var(--tx-3); margin-top: 4px; display: block;">Use a strong password with mixed case and numbers</small>
        </div>

        <div class="form-group">
            <label for="admin_email">Admin Email</label>
            <input type="email" id="admin_email" name="install_step_4_3" class="form-control" 
                   placeholder="admin@example.com" value="<?php echo htmlspecialchars($_SESSION['install_admin_email'] ?? ''); ?>" required>
            <small style="color: var(--tx-3); margin-top: 4px; display: block;">Used for account recovery and notifications</small>
        </div>

        <div class="info-box">
            <strong><i class="bi bi-shield-lock"></i> Security</strong><br>
            Keep these credentials safe. You'll need them to access the admin control panel after installation completes.
        </div>

        <div class="btn-group" style="margin-top: 28px;">
            <button type="submit" name="install_step_4_submit" class="btn btn-primary">
                <i class="bi bi-arrow-right"></i> Continue
            </button>
        </div>
    </form>
</div>

<?php
} catch (Exception $ex) {
    echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($ex->getMessage()) . '</div>';
}
?>
