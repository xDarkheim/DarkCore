# Security Policy

## Supported Versions

| Version | Supported |
|---------|-----------|
| 0.0.1   | ✅ Active |

## Reporting a Vulnerability

**Please do NOT report security vulnerabilities through public GitHub issues.**

If you discover a security vulnerability in DarkWeb CMS, please report it responsibly:

1. **Open a [GitHub Security Advisory](https://github.com/xDarkheim/DarkWeb/security/advisories/new)** — this is the preferred channel.
2. Alternatively, contact the maintainer directly via the GitHub profile: [@xDarkheim](https://github.com/xDarkheim).

Please include as much of the following information as possible:

- Type of vulnerability (e.g. SQL injection, XSS, CSRF, path traversal)
- Affected file(s) and line numbers
- Steps to reproduce
- Proof-of-concept code or screenshots (if applicable)
- Potential impact assessment

## Response Timeline

| Stage | Target Time |
|-------|-------------|
| Initial acknowledgement | Within **72 hours** |
| Triage & severity assessment | Within **7 days** |
| Fix / patch release | Depends on severity (critical: ASAP) |
| Public disclosure | After the fix is released |

We follow a **coordinated disclosure** policy. We ask that you give us a reasonable amount of time to fix the issue before any public disclosure.

## Security Best Practices for Self-Hosters

- Always keep `install/` **removed** after installation.
- Keep your `includes/config/cms.json` outside the web root or protected by `.htaccess`.
- Use HTTPS (TLS) for all traffic.
- Keep PHP, Apache/Nginx, and the OS up to date.
- Restrict database user permissions to the minimum required.
- Regularly rotate database credentials.

## Scope

This policy covers the DarkWeb CMS codebase only.  
Third-party libraries in `vendor/` are subject to their own security policies. Report those vulnerabilities to their respective maintainers.

