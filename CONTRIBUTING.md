# Contributing to DarkWeb CMS

Thank you for your interest in contributing to DarkWeb CMS!  
This document explains how to get started, how the codebase is structured, and what we expect from contributors.

---

## Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [Getting Started](#getting-started)
3. [Reporting Bugs](#reporting-bugs)
4. [Suggesting Features](#suggesting-features)
5. [Submitting a Pull Request](#submitting-a-pull-request)
6. [Coding Standards](#coding-standards)
7. [Running Tests & Analysis](#running-tests--analysis)
8. [Project Structure](#project-structure)
9. [License](#license)

---

## Code of Conduct

By participating in this project you agree to abide by the [Code of Conduct](CODE_OF_CONDUCT.md).  
Please be respectful and constructive in all interactions.

---

## Getting Started

### Prerequisites

- PHP 8.4+
- Composer 2
- Docker + Docker Compose (recommended)
- A MU Online database (X-Team / MuEmu / Louis / Darkheim Emulator)

### Local setup

```bash
git clone https://github.com/xDarkheim/DarkWeb DarkWeb
cd DarkWeb

cp includes/config/cms.json.default includes/config/cms.json
cp docker/config.env.example docker/config.env

# Edit both files with your credentials
docker compose up -d --build
```

Open `https://your-domain/install/` and complete the setup wizard.  
See [`docs/deployment.md`](docs/deployment.md) for the full guide.

---

## Reporting Bugs

1. Search [existing issues](https://github.com/xDarkheim/DarkWeb/issues) first — your bug may already be reported.
2. If not, open a new issue using the **Bug Report** template.
3. Provide as much detail as possible: PHP version, emulator type, steps to reproduce, error messages.

> **Never post credentials, database passwords, or private server data in issues.**

---

## Suggesting Features

1. Check [open issues](https://github.com/xDarkheim/DarkWeb/issues) and [discussions](https://github.com/xDarkheim/DarkWeb/discussions) to avoid duplicates.
2. Open a new issue using the **Feature Request** template.
3. Explain the problem the feature solves and how it should work.

For large features, please open an issue **before** submitting a PR so we can align on design.

---

## Submitting a Pull Request

1. **Fork** the repository and create a branch from `main` (or `develop` for experimental work):
   ```bash
   git checkout -b fix/your-bug-description
   # or
   git checkout -b feature/your-feature-name
   ```

2. Make your changes. Keep each PR focused on **one** bug fix or feature.

3. Ensure all tests and analysis pass:
   ```bash
   composer test
   composer analyse
   ```

4. Write or update unit tests in `tests/` for any logic changes.

5. Update documentation in `docs/` if your change affects behavior or configuration.

6. Commit with a clear, conventional message:
   ```
   fix: correct null pointer in NewsRepository::findById
   feat: add character class filter to rankings
   docs: update deployment guide for Nginx proxy
   ```

7. Push your branch and open a Pull Request against `main`.  
   Fill in the PR template — it helps us review faster.

8. A maintainer will review your PR. Please address any requested changes promptly.

---

## Coding Standards

- **Style:** [PSR-12](https://www.php-fig.org/psr/psr-12/) — enforced by PHP-CS-Fixer.
- **Autoload:** PSR-4, namespace `Darkheim\` maps to `src/`.
- **PHP:** Target PHP 8.4+. Use typed properties, match expressions, and null-safe operators where appropriate.
- **No hardcoded credentials** — use `cms.json` config.
- **No `vendor/` commits** — it is gitignored.
- **SQL:** Parameterised queries only — never concatenate user input into SQL strings.

Run the code style fixer before committing:
```bash
vendor/bin/php-cs-fixer fix
```

---

## Running Tests & Analysis

```bash
# Unit tests (PHPUnit)
composer test

# Static analysis (PHPStan level 6)
composer analyse

# Code style check (PHP-CS-Fixer, dry-run)
vendor/bin/php-cs-fixer fix --dry-run --diff
```

See [`docs/phpunit.md`](docs/phpunit.md) and [`docs/phpstan.md`](docs/phpstan.md) for details.

---

## Project Structure

| Path | Purpose |
|------|---------|
| `src/` | Domain / Application / Infrastructure classes (PSR-4) |
| `modules/` | Frontend page modules (home, news, rankings, …) |
| `admincp/` | Admin control panel |
| `templates/` | HTML/PHP templates |
| `includes/` | Core bootstrap, config, cache, cron, plugins |
| `api/` | Public API endpoints |
| `tests/` | PHPUnit test suites |
| `docs/` | Project documentation |

---

## License

By contributing, you agree that your contributions will be licensed under the [MIT License](LICENSE).

