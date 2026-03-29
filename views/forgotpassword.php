<div class="page-title"><span><?php
        use Darkheim\Application\Shared\Language\Translator;

echo Translator::phrase('module_titles_txt_15', true); ?></span></div>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-header-icon">🔒</div>
            <div class="auth-header-title"><?php echo Translator::phrase('module_titles_txt_15', true); ?></div>
            <div class="auth-header-sub">
                <?php if (! empty($recoveryMode)): ?>
                Choose a new password for your account.
                <?php else: ?>
                Enter your registered email address and we will send you a password reset link.
                <?php endif; ?>
            </div>
        </div>

        <?php if (! empty($recoveryMode)): ?>
        <form action="" method="post" class="auth-form">
            <input type="hidden" name="recovery_ui" value="<?php echo htmlspecialchars((string) ($recoveryUserId ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="recovery_key" value="<?php echo htmlspecialchars((string) ($recoveryToken ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="recovery_email" value="<?php echo htmlspecialchars((string) ($recoveryEmail ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            <div class="auth-field">
                <label for="darkheimRecovery_new"><?php echo Translator::phrase('changepassword_txt_2', true); ?></label>
                <input type="password" id="darkheimRecovery_new" name="darkheimRecovery_new" required autocomplete="new-password">
            </div>
            <div class="auth-field">
                <label for="darkheimRecovery_confirm"><?php echo Translator::phrase('changepassword_txt_3', true); ?></label>
                <input type="password" id="darkheimRecovery_confirm" name="darkheimRecovery_confirm" required autocomplete="new-password">
            </div>
            <button type="submit" name="darkheimRecovery_submit" value="submit" class="auth-btn"><?php echo Translator::phrase('changepassword_txt_4', true); ?></button>
        </form>
        <?php else: ?>
        <form action="" method="post" class="auth-form">
            <div class="auth-field">
                <label for="darkheimEmail"><?php echo Translator::phrase('forgotpass_txt_1', true); ?></label>
                <input type="text" id="darkheimEmail" name="darkheimEmail_current" required autocomplete="email">
            </div>
            <button type="submit" name="darkheimEmail_submit" value="submit" class="auth-btn"><?php echo Translator::phrase('forgotpass_txt_2', true); ?></button>
        </form>
        <?php endif; ?>

        <div class="auth-footer">Remembered your password? <a href="<?php echo $loginUrl; ?>"><?php echo Translator::phrase('menu_txt_4', true); ?></a></div>
    </div>

    <div class="auth-security">
        <div class="auth-security-title">
            <span class="auth-security-icon">🛡️</span>
            Security Notice
        </div>
        <ul class="auth-security-list">
            <li>
                <span class="auth-sec-bullet">⚠️</span>
                <span>The administration will <strong>never</strong> ask for your password — not by email, Discord or in-game.</span>
            </li>
            <li>
                <span class="auth-sec-bullet">🚫</span>
                <span>If someone sent you a "password reset" link you did not request, do not click it.</span>
            </li>
            <li>
                <span class="auth-sec-bullet">📧</span>
                <span>Password reset emails come only from our official domain. Check the sender address carefully.</span>
            </li>
            <li>
                <span class="auth-sec-bullet">🔗</span>
                <span>Always verify the URL in your browser before entering any account information.</span>
            </li>
            <li>
                <span class="auth-sec-bullet">🔒</span>
                <span>After recovering access, set a new strong password and do not reuse old ones.</span>
            </li>
        </ul>
        <div class="auth-security-footer">
            Suspect a phishing attempt? <strong>Contact support immediately</strong> through official channels.
        </div>
    </div>

</div>
