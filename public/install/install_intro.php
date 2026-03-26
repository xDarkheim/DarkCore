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

/** @var array|null $writablePaths */

if (isset($_GET['action']) && $_GET['action'] === 'install') {
    $_SESSION['install_cstep']++;
    header('Location: install.php');
    die();
}
?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-info-circle"></i> Welcome to DarkCore</h2>
    <p class="step-description">
        This installer will guide you through the setup process. Make sure you have the following information ready:
    </p>
    
    <ul class="checklist" style="margin-bottom: 20px;">
        <li>Database host, port, and credentials</li>
        <li>Database name for DarkCore</li>
        <li>Admin account information</li>
        <li>Server timezone</li>
    </ul>

    <div class="info-box">
        <strong><i class="bi bi-lightning-fill"></i> Before You Start</strong><br>
        Ensure your web server can connect to your MSSQL database server on port 1433. If you're on shared hosting, ask your provider to enable outgoing TCP connections.
    </div>

    <div class="btn-group" style="margin-top: 28px;">
        <a href="?action=install" class="btn btn-primary">
            <i class="bi bi-arrow-right"></i> Start Installation
        </a>
    </div>
</div>
