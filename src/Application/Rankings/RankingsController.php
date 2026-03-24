<?php

declare(strict_types=1);

namespace Darkheim\Application\Rankings;

use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Http\Redirector;

final class RankingsController
{
    public function render(): void
    {
        if (empty($_REQUEST['subpage'])) {
            Redirector::go(1, $_REQUEST['page'] . '/' . BootstrapContext::moduleValue('rankings_show_default') . '/');
        }
    }
}
