#!/bin/bash
cd /var/www/capitalspace.quicktum.ru && \
docker exec apache bash -c "cd /var/www//capitalspace.quicktum.ru && \
        php artisan cache:clear && \
        php artisan optimize && \
        php artisan view:cache"
