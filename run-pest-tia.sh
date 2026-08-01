#!/usr/bin/env bash

set -euo pipefail

if [[ "${CI:-}" =~ ^(1|true)$ ]]; then
    exec php ./vendor/bin/pest --no-tia "$@"
fi

if command -v herd >/dev/null 2>&1 && herd list --raw 2>/dev/null | grep -q '^coverage '; then
    php_version="$(php -r 'echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;')"
    herd_ini="${HOME}/Library/Application Support/Herd/config/php/${php_version}/php.ini"

    if [[ -f "${herd_ini}" ]]; then
        PHP_INI_SCAN_DIR="$(dirname "${herd_ini}")"
        export PHP_INI_SCAN_DIR
        exec herd coverage -d memory_limit=512M ./vendor/bin/pest --tia --locally "$@"
    fi

    exec herd coverage -d memory_limit=512M ./vendor/bin/pest --tia --locally "$@"
fi

if php -r 'exit(extension_loaded("pcov") || extension_loaded("xdebug") ? 0 : 1);'; then
    export XDEBUG_MODE=coverage
    exec php -d memory_limit=512M ./vendor/bin/pest --tia --locally "$@"
fi

echo 'Pest TIA requires PCOV or Xdebug coverage. Install a coverage driver or run through Laravel Herd.' >&2
exit 1
