# Changelog

All notable changes to DarkWeb CMS will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [0.0.1] — 2026-03-15

### Added

#### Core
- PSR-4 autoloaded architecture under `src/` (`Darkheim\Application`, `Darkheim\Domain`, `Darkheim\Infrastructure`)
- Plugin system with runtime-loadable plugins from `includes/plugins/`
- CMS bootstrap (`includes/cms.php`) with config, session, language, and module routing
- JSON-based config (`includes/config/cms.json`)

#### Frontend modules
- **Home** — news feed with styled cards, pagination, date and author meta
- **News** — single article view with translations support
- **Rankings** — player and guild rankings with character class filter
- **Info** — server rates, 10 character classes (Dark Wizard, Soul Master, Grand Master, Dark Knight, Blade Knight, Blade Master, Fairy Elf, Muse Elf, High Elf, Magic Gladiator, Duel Master, Dark Lord, Lord Emperor, Summoner, Dimension Master, Rage Fighter, Fist Master, Grow Lancer, Mirage Lancer, Rune Wizard, Slayer), game features, maps
- **Donations** — PayPal integration with credits system
- **User CP** — character management, password change, email change, avatar upload
- **Profile** — public character profile page
- **Login / Register / Forgot Password / Email Verification** — full auth flow
- **Contact** — contact form
- **Downloads** — downloads page
- **Privacy Policy / ToS / Refunds** — static legal pages
- **Castle Siege** — castle siege status page

#### Admin Panel (`admincp/`)
- Account management (info, ban, IP lookup)
- Character editor
- News management with multi-language translations
- Credits & donations manager
- Rankings cache manager
- Blocked IPs management
- Latest bans & PayPal transactions log
- Connection settings editor
- Cron manager
- AdminCP access control

#### News system
- Cache-backed `NewsRepository` with `findAll()`, `findById()`, `loadContent()`
- Full content and short excerpt cache files
- Per-language translation cache
- Styled news cards on home page (thumbnail, title, date, author, excerpt)

#### Multi-language
- Built-in language support: **EN**, **RU**, **CN**, **ES**, **PT**, **RO**
- Per-module language files under `modules/language/`

#### Templates
- Default responsive template (Bootstrap 3)
- Mobile hamburger menu
- Header with UserCP and AdminCP buttons

#### API
- `api/cron.php` — scheduled task runner
- `api/events.php` — game events status
- `api/castlesiege.php` — castle siege data
- `api/guildmark.php` — guild mark image endpoint
- `api/servertime.php` — server time
- `api/version.php` — CMS version endpoint

#### Infrastructure
- Docker environment (`docker/`, `docker-compose.yml`, `docker/config.env.example`)
- PHPUnit 11 test suite (`tests/`)
- PHPStan level 6 static analysis (`phpstan.neon`)
- PHP-CS-Fixer config (`.php-cs-fixer.php`)
- Web installer (`install/`)

#### Documentation (`docs/`)
- `project-structure.md` — directory layout and module routing
- `configuration.md` — `cms.json` keys, `docker/config.env`
- `build.md` — frontend assets and cache busting
- `css-architecture.md` — layout classes, CSS naming, mobile
- `deployment.md` — Docker setup, reverse proxy
- `phpunit.md` — running tests and coverage
- `phpstan.md` — static analysis guide

### Fixed
- N/A (initial release)

### Removed
- Lithuanian (LT) and Filipino (PH) language stubs removed from source
- `webengine` variables removed; replaced by `darkheim`-namespaced config variables

---

[0.0.1]: https://github.com/xDarkheim/DarkWeb/releases/tag/0.0.1

