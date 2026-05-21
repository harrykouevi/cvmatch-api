#!/bin/bash

PROJECT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP="/usr/local/php8.2/bin/php"
LOGFILE="$PROJECT/storage/logs/worker.log"

echo "$(date) - Démarrage worker ai Laravel" >> "$LOGFILE"

while true
do
  if ! pgrep -f "artisan queue:work  database --queue=ai" > /dev/null
  then
    echo "$(date) - Worker ai absent, démarrage..." >> "$LOGFILE"

    $PHP $PROJECT/artisan queue:work database --queue=ai --sleep=3 --tries=3 --timeout=90 >> "$LOGFILE" 2>&1 &
else
    echo "$(date) - Worker ai déjà en cours d'exécution." >> "$LOGFILE"
  fi
  sleep 10
done

