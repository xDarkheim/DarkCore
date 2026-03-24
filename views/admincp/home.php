<?php
/**
 * AdminCP dashboard view.
 *
 * Variables provided by Darkheim\Application\Admincp\Controller\Dashboard\HomeController:
 * - bool $showInstallWarning
 * - string $installWarningHtml
 * - array<int,array{iconClass:string,iconStyle:string,backgroundStyle:string,value:string,label:string}> $statCards
 * - array<int,array{label:string,value:string,valueClass:string}> $systemRows
 * - array<int,array{url:string,iconClass:string,label:string}> $quickActions
 * - array<int,array{name:string,level:string}> $admins
 */
?>

<!-- Hero banner -->
<section class="acp-home-hero">
    <h1 style="color:var(--tx-head);font-size:20px;font-weight:700;margin:0;display:flex;align-items:center;gap:10px;">
        <i class="bi bi-speedometer2" style="color:var(--indigo-2);"></i>
        Admin Dashboard
    </h1>
    <p class="acp-home-subtitle">Manage server settings, players, modules, and automation — all from one place.</p>
</section>

<?php if ($showInstallWarning): ?>
<div class="acp-alert-wrap">
    <?php echo $installWarningHtml; ?>
</div>
<?php endif; ?>

<!-- Stat cards row -->
<div class="acp-stat-grid">
    <?php foreach ($statCards as $card): ?>
    <article class="acp-stat-card">
        <div class="acp-stat-icon">
            <i class="<?php echo htmlspecialchars($card['iconClass'], ENT_QUOTES, 'UTF-8'); ?>"></i>
        </div>
        <div>
            <div class="dash-card-value"><?php echo htmlspecialchars($card['value'], ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="dash-card-label"><?php echo htmlspecialchars($card['label'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
    </article>
    <?php endforeach; ?>
</div>

<!-- Info grid -->
<div class="acp-home-grid">

    <!-- System info -->
    <section class="dash-block">
        <div class="dash-block-header"><i class="bi bi-cpu"></i> System</div>
        <table class="dash-table">
            <?php foreach ($systemRows as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <?php if ($row['valueClass'] !== ''): ?>
                        <span class="<?php echo htmlspecialchars($row['valueClass'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($row['value'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    <?php else: ?>
                        <?php echo htmlspecialchars($row['value'], ENT_QUOTES, 'UTF-8'); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <!-- Quick actions -->
    <section class="dash-block">
        <div class="dash-block-header"><i class="bi bi-lightning-fill"></i> Quick Actions</div>
        <div class="dash-actions">
            <?php foreach ($quickActions as $action): ?>
            <a href="<?php echo htmlspecialchars($action['url'], ENT_QUOTES, 'UTF-8'); ?>" class="dash-action-btn">
                <i class="<?php echo htmlspecialchars($action['iconClass'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                <?php echo htmlspecialchars($action['label'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Administrators -->
    <section class="dash-block">
        <div class="dash-block-header"><i class="bi bi-shield-fill"></i> Administrators</div>
        <table class="dash-table">
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td>
                    <i class="bi bi-person-fill me-1" style="color:var(--indigo-2);"></i>
                    <?php echo htmlspecialchars($admin['name'], ENT_QUOTES, 'UTF-8'); ?>
                </td>
                <td>
                    <span class="badge-level"><?php echo htmlspecialchars($admin['level'], ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>

</div>

