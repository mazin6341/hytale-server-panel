#!/bin/sh

CONTAINER="${CONTAINER:-hytale-web-panel}"
docker compose exec $CONTAINER php $@