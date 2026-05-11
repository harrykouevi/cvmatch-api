#!/bin/bash

PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/usr/local/php8.2/bin/php"
LOGFILE="$PROJECT/storage/logs/queue.log"

while true
do
    if ! pgrep -f "artisan queue:work database" > /dev/null
    then
        echo "$(date) - Worker arrêté. Redémarrage..." >> "$LOGFILE"

        $PHP $PROJECT/artisan queue:work database \
        --queue=notifications,upload \
        --sleep=3 \
        --tries=3 \
        --timeout=90 \
        >> "$LOGFILE" 2>&1 &
    else
        echo "$(date) - Worker déjà actif." >> "$LOGFILE"
    fi

  sleep 60
done
