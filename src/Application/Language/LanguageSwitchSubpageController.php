<?php

declare(strict_types=1);

namespace Darkheim\Application\Language;

use Darkheim\Application\Shared\Language\Translator;
use Darkheim\Application\Shared\UI\MessageRenderer;
use Darkheim\Domain\Validation\Validator;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Http\Redirector;

final class LanguageSwitchSubpageController
{
    public function render(): void
    {
        try {
            if (! BootstrapContext::cmsValue('language_switch_active', true)) {
                throw new \Exception(Translator::phrase('error_62'));
            }

            $target = (string) ($_GET['to'] ?? '');
            if (strlen($target) !== 2 || ! Validator::Alpha($target)) {
                throw new \Exception(Translator::phrase('error_63'));
            }
            if (! is_file(__PATH_LANGUAGES__ . $target . '/language.php')) {
                throw new \Exception(Translator::phrase('error_65'));
            }

            $_SESSION['language_display'] = $target;
            Redirector::go();
        } catch (\Exception $ex) {
            if (! BootstrapContext::cmsValue('error_reporting', true)) {
                Redirector::go();
                return;
            }
            MessageRenderer::inline('error', $ex->getMessage());
        }
    }
}
