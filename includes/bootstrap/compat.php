<?php

/**
 * DarkCore — Global function compatibility shim.
 *
 * Every function here is a one-to-three-line wrapper that delegates to a
 * proper namespaced class in src/.  No business logic lives here.
 *
 * Legacy modules/themes may continue using the global functions unchanged;
 * new code should call the underlying classes directly.
 *
 * @package     DarkCore
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 * @copyright   2026 Dmytro Hovenko (Darkheim)
 * @license     MIT
 * @link        https://darkheim.net
 */

use Darkheim\Application\Admincp\AdmincpUrlGenerator;
use Darkheim\Application\Auth\AdminGuard;
use Darkheim\Application\Auth\SessionManager;
use Darkheim\Application\Language\Translator;
use Darkheim\Application\View\MessageRenderer;
use Darkheim\Domain\Validator;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Bootstrap\ConfigProvider;
use Darkheim\Infrastructure\Bootstrap\RuntimeState;
use Darkheim\Infrastructure\Cache\CacheBuilder;
use Darkheim\Infrastructure\Cache\CacheRepository;
use Darkheim\Infrastructure\Http\Redirector;

// ---------------------------------------------------------------------------
// Value / validation
// ---------------------------------------------------------------------------

function check_value($value): bool
{
    return Validator::hasValue($value);
}

// ---------------------------------------------------------------------------
// HTTP
// ---------------------------------------------------------------------------

function redirect($type = 1, $location = null, $delay = 0): void
{
    Redirector::go((int) $type, $location !== null ? (string) $location : null, (int) $delay);
}

// ---------------------------------------------------------------------------
// Auth / session
// ---------------------------------------------------------------------------

function isLoggedIn(): ?bool
{
    $session = new SessionManager();
    if (! $session->isAuthenticated()) {
        return null;
    }

    $loginConfigs = loadConfigurations('login');
    if (
        is_array($loginConfigs)
        && ($loginConfigs['enable_session_timeout'] ?? false)
        && $session->hasTimedOut((int) ($loginConfigs['session_timeout'] ?? 0))
    ) {
        $session->clearSession();
        return null;
    }

    $session->refreshTimeout();
    return true;
}


function canAccessAdminCP($username): bool
{
    return AdminGuard::canAccess((string) $username);
}

function admincp_base($module = ''): string
{
    return new AdmincpUrlGenerator()->base((string) $module);
}

function enabledisableCheckboxes($name, $checked, $e_txt, $d_txt): void
{
    $normalized = in_array($checked, [true, 1, '1', 'true'], true) ? '1' : '0';
    echo '<div class="radio">';
    echo '<label class="radio">';
    echo '<input type="radio" name="' . $name . '" value="1" ' . ($normalized === '1' ? 'checked' : '') . '>';
    echo $e_txt;
    echo '</label>';
    echo '<label class="radio">';
    echo '<input type="radio" name="' . $name . '" value="0" ' . ($normalized === '0' ? 'checked' : '') . '>';
    echo $d_txt;
    echo '</label>';
    echo '</div>';
}

function weekDaySelectOptions($selected = 'Monday'): string
{
    $days   = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $result = '';
    foreach ($days as $day) {
        $isSelected = ((string) $selected === $day) ? ' selected' : '';
        $result .= '<option value="' . $day . '"' . $isSelected . '>' . $day . '</option>';
    }
    return $result;
}

// ---------------------------------------------------------------------------
// UI messages
// ---------------------------------------------------------------------------

function message($type = 'info', $message = '', $title = ''): void
{
    MessageRenderer::toast((string) $type, (string) $message, (string) $title);
}

function inline_message($type = 'info', $message = '', $title = ''): void
{
    MessageRenderer::inline((string) $type, (string) $message, (string) $title);
}

// ---------------------------------------------------------------------------
// Language / translation
// ---------------------------------------------------------------------------

function lang($phrase, $return = true): ?string
{
    $result = Translator::phrase((string) $phrase);
    if ($return) {
        return $result;
    }
    echo $result;
    return null;
}

function langf($phrase, $args = [], $print = false): ?string
{
    $result = Translator::phraseFmt((string) $phrase, (array) $args);
    if ($print) {
        echo $result;
        return null;
    }
    return $result;
}

function setLanguagePhrases(array $phrases): void
{
    BootstrapContext::runtimeState()?->setLanguagePhrases($phrases);
}

function getLanguagePhrases(): array
{
    return BootstrapContext::runtimeState()?->languagePhrases() ?? [];
}

// ---------------------------------------------------------------------------
// Bootstrap context helpers
// ---------------------------------------------------------------------------

function bootstrapConfigProvider(): ConfigProvider
{
    $provider = BootstrapContext::configProvider();
    if ($provider instanceof ConfigProvider) {
        return $provider;
    }

    static $fallback = null;
    if (! $fallback instanceof ConfigProvider) {
        $fallback = new ConfigProvider(__PATH_CONFIGS__);
    }
    return $fallback;
}

function bootstrapRuntimeState(): RuntimeState
{
    $state = BootstrapContext::runtimeState();
    if ($state instanceof RuntimeState) {
        return $state;
    }

    static $fallback = null;
    if (! $fallback instanceof RuntimeState) {
        $fallback = new RuntimeState();
    }
    return $fallback;
}

// ---------------------------------------------------------------------------
// Config accessors
// ---------------------------------------------------------------------------

function cmsConfigs(): array
{
    return bootstrapConfigProvider()->cms();
}

function config($config_name, $return = false)
{
    $config = cmsConfigs();
    if (! array_key_exists($config_name, $config)) {
        return null;
    }
    if ($return) {
        return $config[$config_name];
    }
    echo $config[$config_name];
    return null;
}

function loadModuleConfigs($module): void
{
    if (! moduleConfigExists($module)) {
        bootstrapRuntimeState()->setModuleConfig([]);
        return;
    }
    $result = bootstrapConfigProvider()->moduleConfig((string) $module);
    bootstrapRuntimeState()->setModuleConfig(is_array($result) ? $result : []);
}

function moduleConfigExists($module): bool
{
    if (! check_value($module)) {
        return false;
    }

    return bootstrapConfigProvider()->moduleConfig((string) $module) !== null;
}

function mconfig($configuration)
{
    $mconfig = moduleConfigData();
    return $mconfig[$configuration] ?? null;
}

function moduleConfigData(): array
{
    return bootstrapRuntimeState()->moduleConfig();
}

function gconfig($config_file, $return = true): ?array
{
    $result = bootstrapConfigProvider()->globalXml((string) $config_file);
    if (! is_array($result)) {
        return null;
    }
    if ($return) {
        return $result;
    }
    bootstrapRuntimeState()->setGlobalConfig($result);
    return null;
}

function loadConfigurations($file): ?array
{
    if (! check_value($file) || ! moduleConfigExists($file)) {
        return null;
    }
    return bootstrapConfigProvider()->moduleConfig((string) $file);
}

function loadConfig($name = 'cms'): ?array
{
    if (! check_value($name)) {
        return null;
    }
    return bootstrapConfigProvider()->config((string) $name);
}

// ---------------------------------------------------------------------------
// Cache
// ---------------------------------------------------------------------------

function encodeCache($data, $pretty = false): string
{
    return CacheBuilder::encode($data, (bool) $pretty);
}

// ---------------------------------------------------------------------------
// Time
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Cron
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Game helpers
// ---------------------------------------------------------------------------


// ---------------------------------------------------------------------------
// Profiles
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// IP / security
// ---------------------------------------------------------------------------


// ---------------------------------------------------------------------------
// Geo / flags
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// File / filesystem
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// XML / JSON
// ---------------------------------------------------------------------------

// ---------------------------------------------------------------------------
// Custom / runtime data
// ---------------------------------------------------------------------------


// ---------------------------------------------------------------------------
// Encoding
// ---------------------------------------------------------------------------

// https://base64.guru/developers/php/examples/base64url


// ---------------------------------------------------------------------------
// Debug
// ---------------------------------------------------------------------------

function debug($value): void
{
    // Intentional legacy helper for manual local diagnostics.
    $output = is_scalar($value) || $value === null
        ? (string) $value
        : var_export($value, true);

    echo '<pre>';
    echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    echo '</pre>';
}
