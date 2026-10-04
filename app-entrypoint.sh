#!/bin/sh
set -eu

WRITABLE_PATHS="
/var/www/storage
/var/www/storage/app
/var/www/storage/app/public
/var/www/storage/app/private
/var/www/storage/app/livewire-tmp
/var/www/storage/framework
/var/www/storage/framework/cache
/var/www/storage/framework/sessions
/var/www/storage/framework/views
/var/www/storage/logs
/var/www/bootstrap/cache
"

for writable_path in $WRITABLE_PATHS; do
    mkdir -p "$writable_path"
    chmod 0777 "$writable_path"

    if command -v setfacl >/dev/null 2>&1; then
        setfacl -R -m u:www-data:rwX "$writable_path"
        setfacl -R -d -m u:www-data:rwX "$writable_path"
    fi
done

exec docker-php-entrypoint "$@"
