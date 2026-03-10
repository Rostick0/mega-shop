#!/bin/sh
set -e

echo "==> Running migrations..."
/usr/local/bin/migrate

echo "==> Starting app..."
exec /usr/local/bin/app