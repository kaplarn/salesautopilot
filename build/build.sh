#!/bin/bash

rm -Rf ./src
rm -Rf ./schema.sql

mkdir src
rsync -av ../src/ ./src/
rsync -av ../schema.sql ./schema.sql

docker build --no-cache --pull -t kaplarn/salesautopilot .
#docker push kaplarn/salesautopilot

rm -Rf ./src
rm -Rf ./schema.sql