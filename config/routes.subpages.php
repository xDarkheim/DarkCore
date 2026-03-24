<?php

declare(strict_types=1);

use Darkheim\Application\Donation\DonationPaypalSubpageController;
use Darkheim\Application\Language\LanguageSwitchSubpageController;
use Darkheim\Application\Profile\ProfileGuildSubpageController;
use Darkheim\Application\Profile\ProfilePlayerSubpageController;
use Darkheim\Application\Rankings\RankingsSectionController;
use Darkheim\Application\Usercp\Subpage\AddStatsSubpageController;
use Darkheim\Application\Usercp\Subpage\BuyZenSubpageController;
use Darkheim\Application\Usercp\Subpage\ClearPkSubpageController;
use Darkheim\Application\Usercp\Subpage\ClearSkillTreeSubpageController;
use Darkheim\Application\Usercp\Subpage\MyAccountSubpageController;
use Darkheim\Application\Usercp\Subpage\MyEmailSubpageController;
use Darkheim\Application\Usercp\Subpage\MyPasswordSubpageController;
use Darkheim\Application\Usercp\Subpage\ResetStatsSubpageController;
use Darkheim\Application\Usercp\Subpage\ResetSubpageController;
use Darkheim\Application\Usercp\Subpage\UnstickSubpageController;
use Darkheim\Application\Usercp\Subpage\VoteSubpageController;

/**
 * Subpage route registry.
 *
 * Key format: "{page}/{subpage}".
 */
return [
    'donation/paypal' => [
        'module_config' => 'donation-paypal',
        'controller'    => DonationPaypalSubpageController::class,
    ],
    'language/switch' => [
        'module_config' => null,
        'controller'    => LanguageSwitchSubpageController::class,
    ],
    'profile/guild' => [
        'module_config' => 'profiles',
        'controller'    => ProfileGuildSubpageController::class,
    ],
    'profile/player' => [
        'module_config' => 'profiles',
        'controller'    => ProfilePlayerSubpageController::class,
    ],
    'rankings/gens' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/grandresets' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/guilds' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/killers' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/level' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/master' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/online' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/resets' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'rankings/votes' => [
        'module_config' => 'rankings',
        'controller'    => RankingsSectionController::class,
    ],
    'usercp/addstats' => [
        'module_config' => 'usercp.addstats',
        'controller'    => AddStatsSubpageController::class,
    ],
    'usercp/buyzen' => [
        'module_config' => 'usercp.buyzen',
        'controller'    => BuyZenSubpageController::class,
    ],
    'usercp/clearpk' => [
        'module_config' => 'usercp.clearpk',
        'controller'    => ClearPkSubpageController::class,
    ],
    'usercp/clearskilltree' => [
        'module_config' => 'usercp.clearskilltree',
        'controller'    => ClearSkillTreeSubpageController::class,
    ],
    'usercp/myaccount' => [
        'module_config' => 'usercp.myaccount',
        'controller'    => MyAccountSubpageController::class,
    ],
    'usercp/myemail' => [
        'module_config' => 'usercp.myemail',
        'controller'    => MyEmailSubpageController::class,
    ],
    'usercp/mypassword' => [
        'module_config' => 'usercp.mypassword',
        'controller'    => MyPasswordSubpageController::class,
    ],
    'usercp/reset' => [
        'module_config' => 'usercp.reset',
        'controller'    => ResetSubpageController::class,
    ],
    'usercp/resetstats' => [
        'module_config' => 'usercp.resetstats',
        'controller'    => ResetStatsSubpageController::class,
    ],
    'usercp/unstick' => [
        'module_config' => 'usercp.unstick',
        'controller'    => UnstickSubpageController::class,
    ],
    'usercp/vote' => [
        'module_config' => 'usercp.vote',
        'controller'    => VoteSubpageController::class,
    ],
];
