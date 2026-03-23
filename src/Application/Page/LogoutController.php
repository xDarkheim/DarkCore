<?php

declare(strict_types=1);

namespace Darkheim\Application\Page;

use Darkheim\Application\Auth\AuthService;
use Darkheim\Application\Auth\SessionManager;
use Darkheim\Infrastructure\Http\Redirector;

final class LogoutController
{
    public function render(): void
    {
        if (! SessionManager::websiteAuthenticated()) {
            Redirector::go();
            return;
        }
        new AuthService()->logout();
        Redirector::go();
    }
}
