<?php

declare(strict_types=1);

namespace Darkheim\Application\Admincp\Support;

final class ModuleConfigCatalog
{
    /**
     * @return array{xml:string,fields:array<string,string>,base?:string,success?:string,error?:string}|null
     */
    public function definition(string $configKey): ?array
    {
        $moduleConfigsBasePath      = $this->moduleConfigsBasePath();
        $moduleConfigsUsercpBasePath = $this->moduleConfigsUsercpBasePath();
        $configsBasePath            = $this->configsBasePath();

        $simpleMap = [
            'contact' => [
                'xml'    => 'contact.xml',
                'fields' => ['setting_1' => 'active', 'setting_2' => 'subject', 'setting_3' => 'sendto'],
            ],
            'donation' => [
                'xml'     => 'donation.xml',
                'fields'  => ['setting_1' => 'active'],
                'success' => '[Donation] Settings successfully saved.',
                'error'   => '[Donation] There has been an error while saving changes.',
            ],
            'forgotpassword' => [
                'xml'    => 'forgot-password.xml',
                'fields' => ['setting_1' => 'active'],
            ],
            'login' => [
                'xml'    => 'login.xml',
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'enable_session_timeout',
                    'setting_3' => 'session_timeout',
                    'setting_4' => 'max_login_attempts',
                    'setting_5' => 'failed_login_timeout',
                ],
            ],
            'news' => [
                'xml'    => 'news.xml',
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'news_expanded',
                    'setting_3' => 'news_list_limit',
                    'setting_6' => 'news_short',
                    'setting_7' => 'news_short_char_limit',
                ],
            ],
            'paypal' => [
                'xml'    => 'donation-paypal.xml',
                'fields' => [
                    'setting_2'  => 'active',
                    'setting_3'  => 'paypal_enable_sandbox',
                    'setting_4'  => 'paypal_email',
                    'setting_5'  => 'paypal_title',
                    'setting_6'  => 'paypal_currency',
                    'setting_7'  => 'paypal_return_url',
                    'setting_8'  => 'paypal_notify_url',
                    'setting_9'  => 'paypal_conversion_rate',
                    'setting_10' => 'credit_config',
                ],
                'success' => '[PayPal] Settings successfully saved.',
                'error'   => '[PayPal] There has been an error while saving changes.',
            ],
            'profiles' => [
                'xml'    => 'profiles.xml',
                'fields' => ['setting_1' => 'active', 'setting_2' => 'encode'],
            ],
            'email' => [
                'xml'    => 'email-templates.xml',
                'base'   => $configsBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'send_from',
                    'setting_3' => 'send_name',
                    'setting_4' => 'smtp_active',
                    'setting_5' => 'smtp_host',
                    'setting_6' => 'smtp_port',
                    'setting_7' => 'smtp_user',
                    'setting_8' => 'smtp_pass',
                ],
            ],
            'rankings' => [
                'xml'    => 'rankings.xml',
                'fields' => [
                    'setting_1'  => 'active',
                    'setting_2'  => 'rankings_results',
                    'setting_3'  => 'rankings_show_date',
                    'setting_4'  => 'rankings_show_default',
                    'setting_5'  => 'rankings_show_place_number',
                    'setting_6'  => 'rankings_enable_level',
                    'setting_7'  => 'rankings_enable_resets',
                    'setting_8'  => 'rankings_enable_pk',
                    'setting_9'  => 'rankings_enable_gr',
                    'setting_10' => 'rankings_enable_online',
                    'setting_11' => 'rankings_enable_guilds',
                    'setting_12' => 'rankings_enable_master',
                    'setting_14' => 'rankings_enable_gens',
                    'setting_15' => 'rankings_enable_votes',
                    'setting_16' => 'rankings_excluded_characters',
                    'setting_17' => 'combine_level_masterlevel',
                    'setting_18' => 'show_country_flags',
                    'setting_19' => 'show_location',
                    'setting_20' => 'show_online_status',
                    'setting_21' => 'guild_score_formula',
                    'setting_22' => 'guild_score_multiplier',
                    'setting_23' => 'rankings_excluded_guilds',
                    'setting_24' => 'rankings_class_filter',
                ],
            ],
            'clearpk' => [
                'xml'    => 'clear-pk.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'zen_cost',
                    'setting_3' => 'credit_config',
                    'setting_4' => 'credit_cost',
                ],
            ],
            'buyzen' => [
                'xml'    => 'buy-zen.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'max_zen',
                    'setting_3' => 'exchange_ratio',
                    'setting_4' => 'credit_config',
                    'setting_5' => 'increment_rate',
                ],
            ],
            'myaccount' => [
                'xml'    => 'my-account.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                ],
            ],
            'myemail' => [
                'xml'    => 'my-email.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'require_verification',
                ],
            ],
            'mypassword' => [
                'xml'    => 'my-password.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'change_password_email_verification',
                    'setting_3' => 'change_password_request_timeout',
                ],
            ],
            'resetstats' => [
                'xml'    => 'reset-stats.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'zen_cost',
                    'setting_3' => 'credit_config',
                    'setting_4' => 'credit_cost',
                ],
            ],
            'unstick' => [
                'xml'    => 'unstick.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'zen_cost',
                    'setting_3' => 'credit_config',
                    'setting_4' => 'credit_cost',
                ],
            ],
            'register' => [
                'xml'    => 'register.xml',
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'register_enable_recaptcha',
                    'setting_3' => 'register_recaptcha_site_key',
                    'setting_4' => 'register_recaptcha_secret_key',
                    'setting_5' => 'verify_email',
                    'setting_6' => 'send_welcome_email',
                    'setting_7' => 'verification_timelimit',
                    'setting_8' => 'automatic_login',
                ],
            ],
            'downloads' => [
                'xml'    => 'downloads.xml',
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'show_client_downloads',
                    'setting_3' => 'show_patch_downloads',
                    'setting_4' => 'show_tool_downloads',
                ],
            ],
            'vote' => [
                'xml'    => 'vote.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'vote_save_logs',
                    'setting_3' => 'credit_config',
                ],
            ],
            'addstats' => [
                'xml'    => 'add-stats.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'zen_cost',
                    'setting_3' => 'credit_config',
                    'setting_4' => 'credit_cost',
                    'setting_5' => 'required_level',
                    'setting_6' => 'required_master_level',
                    'setting_7' => 'max_stats',
                    'setting_8' => 'minimum_limit',
                ],
            ],
            'clearskilltree' => [
                'xml'    => 'clear-skill-tree.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1' => 'active',
                    'setting_2' => 'zen_cost',
                    'setting_3' => 'credit_config',
                    'setting_4' => 'credit_cost',
                    'setting_5' => 'required_level',
                    'setting_6' => 'required_master_level',
                ],
            ],
            'reset' => [
                'xml'    => 'reset.xml',
                'base'   => $moduleConfigsUsercpBasePath,
                'fields' => [
                    'setting_1'  => 'active',
                    'setting_2'  => 'zen_cost',
                    'setting_3'  => 'credit_config',
                    'setting_4'  => 'credit_cost',
                    'setting_5'  => 'required_level',
                    'setting_6'  => 'maximum_resets',
                    'setting_7'  => 'keep_stats',
                    'setting_8'  => 'points_reward',
                    'setting_9'  => 'multiply_points_by_resets',
                    'setting_10' => 'clear_inventory',
                    'setting_11' => 'revert_class_evolution',
                    'setting_12' => 'credit_reward',
                    'setting_13' => 'credit_reward_config',
                ],
            ],
        ];

        return $simpleMap[$configKey] ?? null;
    }

    public function moduleConfigNameFromKey(string $configKey): string
    {
        $map = [
            'buyzen'         => 'buy-zen',
            'clearpk'        => 'clear-pk',
            'clearskilltree' => 'clear-skill-tree',
            'forgotpassword' => 'forgot-password',
            'myaccount'      => 'my-account',
            'myemail'        => 'my-email',
            'mypassword'     => 'my-password',
            'paypal'         => 'donation-paypal',
            'addstats'       => 'add-stats',
            'resetstats'     => 'reset-stats',
        ];

        return $map[$configKey] ?? $configKey;
    }

    private function moduleConfigsBasePath(): string
    {
        if (defined('__PATH_MODULE_CONFIGS__')) {
            return (string) constant('__PATH_MODULE_CONFIGS__');
        }

        return '';
    }

    private function moduleConfigsUsercpBasePath(): string
    {
        if (defined('__PATH_MODULE_CONFIGS_USERCP__')) {
            return (string) constant('__PATH_MODULE_CONFIGS_USERCP__');
        }

        return '';
    }

    private function configsBasePath(): string
    {
        if (defined('__PATH_CONFIGS__')) {
            return (string) constant('__PATH_CONFIGS__');
        }

        return '';
    }
}

