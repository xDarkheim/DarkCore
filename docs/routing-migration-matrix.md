# Routing Migration Matrix

This matrix tracks frontend top-level module routing through controllers and subpage routing through the subpage registry.

## Status meanings

- `migrated`: module is routed by a `*Controller` registered in `config/routes.web.php`. Regression is caught by `HandlerMigrationGateTest`.
- `subpage`: route is registered in `config/routes.subpages.php` and dispatched by `SubpageRouteDispatcher`; it may render either a dedicated subpage template or a shared controller-backed view.

## Source of truth

Machine-readable status lives in `config/routing-migration.json`.
Top-level controller routes are registered in `config/routes.web.php` (`WebRouteRegistry`).
Sub-page routes are registered in `config/routes.subpages.php` (`SubpageRouteRegistry`).

## Current matrix (v1)

| Page           | Status   | Controller                                              |
|----------------|----------|---------------------------------------------------------|
| castlesiege    | migrated | `Darkheim\\Application\\CastleSiege\\CastleSiegeController` |
| contact        | migrated | `Darkheim\\Application\\Website\\ContactController`     |
| donation       | migrated | `Darkheim\\Application\\Donation\\DonationController`   |
| downloads      | migrated | `Darkheim\\Application\\Website\\DownloadsController`   |
| forgotpassword | migrated | `Darkheim\\Application\\Auth\\ForgotPasswordController` |
| home           | migrated | `Darkheim\\Application\\Website\\HomeController`        |
| info           | migrated | `Darkheim\\Application\\Website\\InfoController`        |
| login          | migrated | `Darkheim\\Application\\Auth\\LoginController`          |
| logout         | migrated | `Darkheim\\Application\\Auth\\LogoutController`         |
| news           | migrated | `Darkheim\\Application\\News\\NewsController`           |
| privacy        | migrated | `Darkheim\\Application\\Website\\PrivacyController`     |
| rankings       | migrated | `Darkheim\\Application\\Rankings\\RankingsController`   |
| refunds        | migrated | `Darkheim\\Application\\Website\\RefundsController`     |
| register       | migrated | `Darkheim\\Application\\Auth\\RegisterController`       |
| tos            | migrated | `Darkheim\\Application\\Website\\TosController`         |
| usercp         | migrated | `Darkheim\\Application\\Usercp\\UsercpController`       |
| verifyemail    | migrated | `Darkheim\\Application\\Auth\\VerifyEmailController`    |

## Update rules

When migrating a top-level page to a controller:

1. Create a `*Controller` under the matching feature namespace (for example `src/Application/Website/`, `src/Application/Auth/`, `src/Application/Rankings/`) with a `render(): void` method.
2. Add/update the route entry in `config/routes.web.php`.
3. Update `config/routing-migration.json` status → `migrated` + controller FQCN.
4. Add or update tests in `tests/Unit/Infrastructure/Routing/`.

When adding a sub-page route:

1. Register the route in `config/routes.subpages.php`.
2. If the route is controller-backed, prepare the full view-model in the controller and render the final template with `ViewRenderer`.
3. Use a dedicated template only when the markup is unique; otherwise prefer a shared template.
4. Mark status `subpage` in `config/routing-migration.json` if tracked.

Current shared-template examples:

- `rankings/*` → `Darkheim\Application\Rankings\RankingsSectionController` → `views/ranking.php`
- repeated UserCP character actions → `Darkheim\Application\Usercp\Subpage\AbstractCharacterActionTableSubpageController` → `views/subpages/usercp/actiontables.php`
