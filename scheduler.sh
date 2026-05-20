#!/bin/bash

PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/usr/local/php8.2/bin/php"
LOGFILE="$PROJECT/storage/logs/scheduler.log"

echo "$(date) - Démarrage scheduler Laravel" >> "$LOGFILE"

exec $PHP $PROJECT/artisan schedule:work \
    >> "$LOGFILE" 2>&1
