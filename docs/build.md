# Frontend Assets

CSS and JS source files are served directly. There is no bundler, transpiler, or build CLI in this repository.

## CSS

All stylesheets are injected with individual `<link>` tags directly in `public/templates/default/index.php`.  
No `main.css` entry point or `@import` bundling is used.

Assets from `assets/css/` are loaded dynamically:

```php
$_cssFiles = ['variables','toast','auth','ucp','myaccount','profiles',
              'info','tos','news','rankings','panels','paypal','downloads','castlesiege'];
foreach($_cssFiles as $_f) { /* inject <link> if file exists */ }
```

See [CSS Architecture](css-architecture.md) for the full load order and naming conventions.

## JS

Each JS file is included with its own `<script>` tag at the bottom of `<body>` in `public/templates/default/index.php`.

| # | File | Purpose |
| :---: | :--- | :--- |
| 1 | jQuery 3.7.1 (CDN) | DOM manipulation |
| 2 | `main.js` | Server time clock, castle siege countdown, PayPal calculator |
| 3 | `events.js` | Event schedule feed (`/api/events.php`) |
| 4 | Bootstrap 3 JS (CDN) | Dropdowns, tooltips, modals |
| 5 | `public/assets/js/components.js` | DarkCore UI components (toasts, theme toggle, etc.) |

## Cache busting

Cache busting is automatic: `filemtime()` is appended as a query string to every local asset URL. No manual version bumping is needed.

```text
css/style.css?v=1741819200
js/main.js?v=1741820000
```

## Adding a new CSS file

1. Create the file in `public/assets/css/` (for page/component styles) or `public/templates/default/css/` (for template-level layout).
2. For `public/assets/css/`: add the filename (without `.css`) to the `$_cssFiles` array in `public/templates/default/index.php`.
3. For `public/templates/default/css/`: add a new `<link>` tag in `public/templates/default/index.php` **before** `override.css`.

## Adding a new JS file

1. Create the file in `public/templates/default/js/` or `public/assets/js/`.
2. Add a `<script>` tag at the bottom of `<body>` in `public/templates/default/index.php`.
