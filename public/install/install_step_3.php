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

/** @var array $install */

/**
 * Installer-local helpers for idempotent SQL Server table creation.
 */
function installerTableExists(dB $database, string $tableName): bool
{
    $result = $database->query_fetch_single(
        "SELECT TOP 1 name FROM sys.tables WHERE name = ? AND schema_id = SCHEMA_ID('dbo')",
        [$tableName],
    );

    return is_array($result);
}

function installerIsAlreadyExistsError(?string $error): bool
{
    if (! is_string($error) || $error === '') {
        return false;
    }

    return str_contains($error, 'There is already an object named')
        || str_contains($error, '[SQL 42S01]')
        || str_contains($error, ' 2714]');
}

try {
    if (isset($_POST['install_step_3_submit'])) {
        if (! isset($_POST['install_step_3_error'])) {
            $_SESSION['install_cstep']++;
            header('Location: install.php');
            die();
        }
        echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> One or more errors occurred. Fix them before continuing.</div>';
    }

    if (! isset($_SESSION['install_sql_db1'])) {
        throw new Exception('Database connection info missing. Please restart the installation.');
    }

    /** @phpstan-ignore-next-line */
    $mudb = new dB(
        $_SESSION['install_sql_host'],
        $_SESSION['install_sql_port'],
        $_SESSION['install_sql_db1'],
        $_SESSION['install_sql_user'],
        $_SESSION['install_sql_pass'],
    );

    if ($mudb->dead) {
        throw new Exception('Could not connect to database: ' . htmlspecialchars($_SESSION['install_sql_db1']));
    }
    if (! is_array($install['sql_list'])) {
        throw new Exception('Could not load CMS SQL tables list.');
    }

    foreach ($install['sql_list'] as $sqlFileName => $sqlTableName) {
        $sqlPath = __INSTALL_ROOT__ . 'sql/' . $sqlFileName . '.txt';
        if (! file_exists($sqlPath)) {
            throw new Exception('Missing SQL file: sql/' . $sqlFileName . '.txt');
        }
    }

    $errors         = [];
    $createdTables  = [];
    $existingTables = [];
    foreach ($install['sql_list'] as $sqlFileName => $sqlTableName) {
        $sqlPath       = __INSTALL_ROOT__ . 'sql/' . $sqlFileName . '.txt';
        $queryTemplate = file_get_contents($sqlPath);
        if ($queryTemplate === false) {
            $errors[$sqlFileName] = 'Could not read SQL file: ' . $sqlFileName . '.txt';
            continue;
        }

        $tableName = (string) $sqlTableName;
        $query     = trim(str_replace('{TABLE_NAME}', $tableName, $queryTemplate));

        if (installerTableExists($mudb, $tableName)) {
            $existingTables[$sqlFileName] = $tableName;
            continue;
        }

        if (! $mudb->query($query)) {
            if (installerIsAlreadyExistsError($mudb->error)) {
                $existingTables[$sqlFileName] = $tableName;
                continue;
            }

            $errors[$sqlFileName] = $mudb->error;
            continue;
        }

        $createdTables[$sqlFileName] = $tableName;
    }
    ?>

<div class="step-section active">
    <h2 class="step-title"><i class="bi bi-table"></i> Create Database Tables</h2>
    <p class="step-description">Setting up the required database tables...</p>

    <?php if (empty($errors)): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            <?php if ($existingTables === []): ?>
                All database tables created successfully!
            <?php elseif ($createdTables === []): ?>
                All required database tables already exist. You can continue safely.
            <?php else: ?>
                Database tables are ready. New tables were created and existing ones were preserved.
            <?php endif; ?>
        </div>

        <?php if ($createdTables !== []): ?>
        <div class="info-box">
            <strong>Created Tables</strong><br>
            <ul class="checklist" style="margin-top: 10px;">
                <?php foreach ($createdTables as $fileName => $tableName): ?>
                <li><?php echo htmlspecialchars($tableName); ?> <small style="color: var(--tx-3);">(<?php echo htmlspecialchars($fileName); ?>)</small></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($existingTables !== []): ?>
        <div class="info-box">
            <strong>Skipped Existing Tables</strong><br>
            <ul class="checklist" style="margin-top: 10px;">
                <?php foreach ($existingTables as $fileName => $tableName): ?>
                <li class="warning"><?php echo htmlspecialchars($tableName); ?> <small style="color: var(--tx-3);">(<?php echo htmlspecialchars($fileName); ?>)</small></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="info-box">
            <strong>Next Step</strong><br>
            Configure your admin account and server settings.
        </div>

        <form method="post" style="margin-top: 28px;">
            <div class="btn-group">
                <button type="submit" name="install_step_3_submit" class="btn btn-primary">
                    <i class="bi bi-arrow-right"></i> Continue
                </button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Errors Creating Tables</strong>
        </div>

        <ul class="checklist">
            <?php foreach ($errors as $fileName => $error): ?>
            <li class="error">
                <strong><?php echo htmlspecialchars($fileName); ?></strong><br>
                <small style="color: var(--tx-3);"><?php echo htmlspecialchars($error); ?></small>
            </li>
            <?php endforeach; ?>
        </ul>

        <form method="post" style="margin-top: 28px;">
            <input type="hidden" name="install_step_3_error" value="1">
            <div class="btn-group">
                <button type="submit" name="install_step_3_submit" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Go Back
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php
} catch (Exception $ex) {
    echo '<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($ex->getMessage()) . '</div>';
}
?>
