#!/usr/bin/bash
php artisan optimize:clear && \
vendor/bin/phpstan analyze && \
php artisan test
