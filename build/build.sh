#!/bin/bash

rm -Rf ./src
mkdir src
rsync -av ../src/ ./src/

docker build --no-cache --pull -t kaplarn/salesautopilot .
#docker push kaplarn/salesautopilot

rm -Rf ./src