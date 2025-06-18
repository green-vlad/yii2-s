#!/bin/bash
set -e

ENV_FILE=".env"

# Создать .env только если его нет
if [ ! -f "$ENV_FILE" ]; then
  echo "UID=$(id -u)" > "$ENV_FILE"
  echo "GID=$(id -g)" >> "$ENV_FILE"
  echo "Создан файл .env с UID и GID"
fi

docker compose up -d