<?php

declare(strict_types=1);

namespace Darkheim\Application\Admincp;

use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\View\ViewRenderer;

final class PhrasesController
{
    private ViewRenderer $view;

    public function __construct(?ViewRenderer $view = null)
    {
        $this->view = $view ?? new ViewRenderer();
    }

    public function render(): void
    {
        $lang  = BootstrapContext::runtimeState()?->languagePhrases() ?? [];
        $rows  = [];

        foreach ($lang as $key => $value) {
            $rows[] = [
                'key'   => (string) $key,
                'value' => (string) $value,
            ];
        }

        $this->view->render('admincp/phrases', [
            'rows'  => $rows,
            'count' => count($rows),
            'error' => $rows === [] ? 'Language file is empty.' : null,
        ]);
    }
}
