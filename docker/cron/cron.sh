#!/bin/sh

PERIOD=14
NEW_FILE_NAME=b`date "+%Y%m%d"`.sql
OLD_FILE_NAME=b`date "+%Y%m%d" -d "-$PERIOD days"`.sql

mysqldump -h db -u $DB_USERNAME -p$DB_PASSWORD --databases $DB_DATABASE --no-tablespaces --single-transaction --master-data=2 > $NEW_FILE_NAME

ACCESS_TOKEN=`curl https://api.dropbox.com/oauth2/token \
    -d grant_type=refresh_token \
    -d refresh_token=$DROPBOX_REFRESH_TOKEN \
    -u $DROPBOX_APP_KEY:$DROPBOX_APP_SECRET | \
    jq '.access_token'`
ACCESS_TOKEN=${ACCESS_TOKEN:1:-1}

curl -X POST https://content.dropboxapi.com/2/files/upload \
  --header "Authorization: Bearer $ACCESS_TOKEN" \
  --header "Content-Type: application/octet-stream" \
  --header "Dropbox-API-Arg: {\"path\":\"/backups/$NEW_FILE_NAME\"}" \
  --data-binary @"$NEW_FILE_NAME"

rm $NEW_FILE_NAME

curl -X POST https://api.dropboxapi.com/2/files/delete_v2 \
  --header "Authorization: Bearer $ACCESS_TOKEN" \
  --header "Content-Type: application/json" \
  --data "{\"path\":\"/backups/$OLD_FILE_NAME\"}"
