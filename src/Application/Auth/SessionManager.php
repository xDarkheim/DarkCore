<?php

declare(strict_types=1);

namespace Darkheim\Application\Auth;

use Darkheim\Infrastructure\Runtime\NativeSessionStore;
use Darkheim\Infrastructure\Runtime\SessionStore;

/**
 * Read/write interface for the CMS session state.
 * Intentionally does NOT start or destroy the session — that belongs to the
 * legacy bootstrap (includes/bootstrap/boot.php).  This class works with the already-started
 * PHP session.
 */
final class SessionManager
{
    private SessionStore $session;

    public function __construct(?SessionStore $session = null)
    {
        $this->session = $session ?? new NativeSessionStore();
    }

    /** True when all required session keys are present. */
    public function isAuthenticated(): bool
    {
        return $this->session->has('valid')
            && $this->session->has('userid')
            && $this->session->has('username')
            && $this->session->has('timeout');
    }

    public function userId(): ?int
    {
        $userId = $this->session->get('userid');
        return $userId !== null ? (int) $userId : null;
    }

    public function username(): ?string
    {
        $username = $this->session->get('username');
        return is_string($username) ? $username : null;
    }

    public function lastActivity(): int
    {
        $timeout = $this->session->get('timeout');
        return $timeout !== null ? (int) $timeout : 0;
    }

    /** Returns true when the idle time has exceeded $timeoutSeconds. */
    public function hasTimedOut(int $timeoutSeconds): bool
    {
        return (time() - $this->lastActivity()) > $timeoutSeconds;
    }

    /** Stamp the current time as the last activity timestamp. */
    public function refreshTimeout(): void
    {
        $this->session->set('timeout', time());
    }

    public function startAuthenticatedSession(mixed $userId, string $username): void
    {
        $this->session->set('valid', true);
        $this->session->set('timeout', time());
        $this->session->set('userid', $userId);
        $this->session->set('username', $username);
    }

    /** Clears session data without destroying the session itself. */
    public function clearSession(): void
    {
        $this->session->clear();
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}

