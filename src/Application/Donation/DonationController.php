<?php

declare(strict_types=1);

namespace Darkheim\Application\Donation;

use Darkheim\Application\Shared\Language\Translator;
use Darkheim\Application\Shared\UI\MessageRenderer;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\View\ViewRenderer;

final class DonationController
{
    private ViewRenderer $view;

    public function __construct(?ViewRenderer $view = null)
    {
        $this->view = $view ?? new ViewRenderer();
    }

    public function render(): void
    {
        try {
            if (! BootstrapContext::moduleValue('active')) {
                MessageRenderer::inline('error', Translator::phrase('error_47'));
                return;
            }
            $this->view->render('donation', [
                'paypalImageUrl' => __PATH_THEME_IMG__ . 'donation/paypal.jpg',
                'paypalUrl'      => __BASE_URL__ . 'donation/paypal/',
            ]);
        } catch (\Exception $ex) {
            MessageRenderer::inline('error', $ex->getMessage());
        }
    }
}
