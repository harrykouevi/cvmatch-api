#!/bin/bash

PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/usr/local/php8.2/bin/php"
LOGFILE="$PROJECT/storage/logs/queue.log"

echo "$(date) - Démarrage worker Laravel" >> "$LOGFILE"

exec $PHP $PROJECT/artisan queue:work \
    --queue=notifications,upload \
    --sleep=3 \
    --tries=3 \
    --timeout=90 \
    >> "$LOGFILE" 2>&1
