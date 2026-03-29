<?php

declare(strict_types=1);

namespace Darkheim\Application\Auth;

use Darkheim\Application\Account\Account;
use Darkheim\Application\Shared\Language\Translator;
use Darkheim\Application\Shared\UI\MessageRenderer;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Http\Redirector;
use Darkheim\Infrastructure\View\ViewRenderer;

final class ForgotPasswordController
{
    private ViewRenderer $view;

    public function __construct(?ViewRenderer $view = null)
    {
        $this->view = $view ?? new ViewRenderer();
    }

    public function render(): void
    {
        if (SessionManager::websiteAuthenticated()) {
            Redirector::go();
            return;
        }

        try {
            if (! BootstrapContext::moduleValue('active')) {
                MessageRenderer::inline('error', Translator::phrase('error_47'));
                return;
            }

            $recoveryUserId = (string) ($_GET['ui'] ?? $_POST['recovery_ui'] ?? '');
            $recoveryToken  = (string) ($_GET['key'] ?? $_POST['recovery_key'] ?? '');
            $recoveryEmail  = (string) ($_GET['ue'] ?? $_POST['recovery_email'] ?? '');
            $recoveryMode   = $recoveryUserId !== '' && $recoveryToken !== '';

            if ($recoveryMode) {
                $account = new Account();
                try {
                    $account->passwordRecoveryVerificationProcess(
                        $recoveryUserId,
                        $recoveryToken,
                        $recoveryEmail !== '' ? $recoveryEmail : null,
                    );

                    if (isset($_POST['darkheimRecovery_submit'])) {
                        $account->passwordRecoveryResetProcess(
                            $recoveryUserId,
                            $recoveryToken,
                            $_POST['darkheimRecovery_new']     ?? '',
                            $_POST['darkheimRecovery_confirm'] ?? '',
                            $recoveryEmail !== '' ? $recoveryEmail : null,
                        );
                        Redirector::go(2, 'login/', 3);
                        return;
                    }
                } catch (\Exception $ex) {
                    MessageRenderer::inline('error', $ex->getMessage());
                    return;
                }
            }

            if (! $recoveryMode && isset($_POST['darkheimEmail_submit'])) {
                try {
                    new Account()->passwordRecoveryProcess(
                        $_POST['darkheimEmail_current'] ?? '',
                        $_SERVER['REMOTE_ADDR'],
                    );
                } catch (\Exception $ex) {
                    MessageRenderer::toast('error', $ex->getMessage());
                }
            }

            $this->view->render('forgotpassword', [
                'baseUrl'        => __BASE_URL__,
                'loginUrl'       => __BASE_URL__ . 'login',
                'recoveryMode'   => $recoveryMode,
                'recoveryUserId' => $recoveryUserId,
                'recoveryToken'  => $recoveryToken,
                'recoveryEmail'  => $recoveryEmail,
            ]);
        } catch (\Exception $ex) {
            MessageRenderer::inline('error', $ex->getMessage());
        }
    }
}
