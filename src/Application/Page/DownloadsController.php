<?php

declare(strict_types=1);

namespace Darkheim\Application\Page;

use Darkheim\Application\Shared\Language\Translator;
use Darkheim\Application\Shared\UI\MessageRenderer;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Cache\CacheRepository;
use Darkheim\Infrastructure\View\ViewRenderer;

final class DownloadsController
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

            $clients = [];
            $patches = [];
            $tools   = [];

            $cache = new CacheRepository(__PATH_CACHE__)->load('downloads.cache');
            if (is_array($cache)) {
                foreach ($cache as $d) {
                    if ($d['download_type'] == 1) {
                        $clients[] = $d;
                    } elseif ($d['download_type'] == 2) {
                        $patches[] = $d;
                    } elseif ($d['download_type'] == 3) {
                        $tools[] = $d;
                    }
                }
            }

            $this->view->render('downloads', [
                'showClients' => (bool) BootstrapContext::moduleValue('show_client_downloads'),
                'showPatches' => (bool) BootstrapContext::moduleValue('show_patch_downloads'),
                'showTools'   => (bool) BootstrapContext::moduleValue('show_tool_downloads'),
                'clients'     => $clients,
                'patches'     => $patches,
                'tools'       => $tools,
            ]);
        } catch (\Exception $ex) {
            MessageRenderer::inline('error', $ex->getMessage());
        }
    }
}
