# PHPUnit — Testing

Unit tests verify that individual classes and methods work correctly in isolation.
Tests live in `tests/Unit/` and mirror the `src/` directory structure.

## Quick start

```bash
# Inside the container
docker compose exec web composer test

# Or directly
docker compose exec web ./vendor/bin/phpunit --no-coverage
```

A passing run prints `OK (N tests, N assertions)`.

## What's tested

| Layer | Classes | Tests |
| :--- | :--- | :---: |
| Domain | `Validator` | 24 |
| Application | `Account`, `Auth/*`, `News/*`, `Rankings/*`, `Vote/*` | 68 |
| Infrastructure | `Cache/*`, `Config/*`, `Cron/*`, `Database/*`, `Email`, `Payment/*`, `Plugins`, `Routing/*` | 104 |
| **Total** | 31 classes | **196 tests, 271 assertions** |

## Writing tests

Tests are split into three tiers by dependency complexity.

### Tier 1 — Pure classes (no dependencies)

No mocking, no filesystem, fully deterministic. Examples: `Validator`, `NewsItem`, `RankingCache`.

```php
use Darkheim\Domain\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testEmailValid(): void
    {
        $this->assertTrue(Validator::Email('user@example.com'));
    }
}
```

### Tier 2 — Filesystem classes

Use real instances backed by `sys_get_temp_dir()`. Note: `CacheRepository`, `JsonConfigReader`,
and `XmlConfigReader` are declared `final` and cannot be mocked — use real instances with temp files.

```php
protected function setUp(): void
{
    $this->dir = sys_get_temp_dir() . '/test_' . uniqid() . '/';
    mkdir($this->dir, 0777, true);
}

protected function tearDown(): void
{
    // remove temp files
}
```

### Tier 3 — Classes with DB or external dependencies

Use PHPUnit mock objects. Example: `NewsRepository` with a mocked `dB` instance.

```php
$db = $this->createMock(\Darkheim\Infrastructure\Database\dB::class);
$db->method('query_fetch')->willReturn([...]);
$repo = new NewsRepository($db, $cacheRepo);
```

### Adding a new test

1. Create `tests/Unit/<Layer>/<ClassName>Test.php`
2. Extend `PHPUnit\Framework\TestCase`
3. Use `setUp()` / `tearDown()` for isolation
4. One assertion per concept — keep tests focused

## IDE integration

### PHPStorm

1. **Settings → PHP → Test Frameworks** → add PHPUnit by path: `vendor/bin/phpunit`
2. Set default configuration file: `phpunit.xml`
3. Right-click any test class or method → **Run**
4. For Docker interpreter: **Settings → PHP → CLI Interpreter** → add Docker compose interpreter (`web` service)

### VS Code

Install the **PHP Test Explorer** extension (by `recca0120`), then add to `.vscode/settings.json`:

```json
{
    "phpunit.phpunit": "vendor/bin/phpunit",
    "phpunit.args": ["--configuration", "phpunit.xml"]
}
```

## Xdebug

### Enable Xdebug

Set in `docker/config.env`:

```env
DOCKER_XDEBUG_MODE=debug
```

Restart the container (no rebuild required):

```bash
docker compose restart
```

### PHPStorm setup

1. **Settings → PHP → Debug** — confirm port is `9003`
2. **Settings → PHP → Servers** — add server with path mapping: `/home/you/DarkWeb` → `/var/www/html`
3. Click **Start Listening for PHP Debug Connections** (phone icon)
4. Set a breakpoint and open the page in the browser

### Xdebug modes

| Mode | Use case |
| :--- | :--- |
| `off` | Production / CI — zero overhead |
| `debug` | Step debugging with IDE |
| `profile` | Generate cachegrind profiling files |
| `coverage` | Code coverage for PHPUnit |
| `debug,coverage` | Debugging + coverage together |

### Coverage report

```bash
# Requires DOCKER_XDEBUG_MODE=coverage
docker compose exec web ./vendor/bin/phpunit --coverage-text
```

## Configuration files

| File | Purpose |
| :--- | :--- |
| `phpunit.xml` | Test suite definition, bootstrap path |
| `tests/bootstrap.php` | Loaded before every test — stubs globals, defines constants |
| `tests/Stubs/` | Test helpers: `DbTestHelper`, `RedirectException` |
