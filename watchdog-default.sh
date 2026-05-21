#!/bin/bash

PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/usr/local/php8.2/bin/php"
LOGFILE="$PROJECT/storage/logs/worker.log"

echo "$(date) - Démarrage worker default Laravel" >> "$LOGFILE"

# while true
# do
#   if ! pgrep -f "artisan queue:work redis --queue=default" > /dev/null
#   then
    echo "$(date) - Worker default absent, démarrage..." >> "$LOGFILE"

    $PHP $PROJECT/artisan queue:work redis --queue=default --sleep=3 --tries=3 --timeout=90 >> "$LOGFILE" 2>&1 &
# else
#     echo "$(date) - Worker default déjà en cours d'exécution." >> "$LOGFILE"
#   fi
#   sleep 3000
# done

