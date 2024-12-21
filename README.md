# Contao Redirection Bundle

A simple Contao extension for URL redirects (301, 302) and 410 (Gone) responses.

- **Source URL**: Path without leading `/` (e.g., `test`).
- **Target URL**: Supports insert tags (e.g., `{{link_url::1}}`), absolute URLs, or relative paths.
- Manage via **System > Redirection** in the backend.

## Install
```bash
composer require respinar/contao-redirection-bundle
```

## Usage
Add redirects in the backend with source_url, target_url, status (301, 302, 410), and active checkbox.



## License
Licensed under the MIT License (LICENSE).


