#!/bin/sh
#
# Keep the WhatsApp gateway running on hosting that has no service manager.
#
# Shared hosts kill long-lived processes on reboots, memory pressure and panel
# restarts. This asks the gateway whether it is alive and starts it if not, so a
# cron entry every few minutes is enough to keep the inbox working:
#
#   */5 * * * * /home/USER/whatsapp-service/keepalive.sh >> /home/USER/whatsapp-service/keepalive.log 2>&1
#
# It is safe to run while the gateway is up: it exits immediately.
# Make it executable once with:  chmod +x keepalive.sh

set -eu

DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$DIR"

# Read WA_PORT from .env without sourcing the whole file (values may hold '#').
PORT="$(sed -n 's/^WA_PORT=\([0-9]\{1,\}\).*/\1/p' .env 2>/dev/null | head -n 1)"
PORT="${PORT:-3001}"

# Some shared hosts do not put node on cron's PATH. Set NODE_BIN in the
# environment, or edit this line to the absolute path from `which node`.
NODE="${NODE_BIN:-node}"
command -v "$NODE" >/dev/null 2>&1 || NODE="/usr/bin/node"

stamp() { date '+%Y-%m-%d %H:%M:%S'; }

# /health needs no token, which is exactly what it is for.
if curl -fsS --max-time 10 "http://127.0.0.1:${PORT}/health" >/dev/null 2>&1; then
    exit 0
fi

echo "$(stamp) gateway not answering on port ${PORT} — starting it"

# setsid detaches it from cron's process group, so it is not killed when cron
# finishes. nohup alone is not always enough for that.
if command -v setsid >/dev/null 2>&1; then
    setsid "$NODE" index.js >> gateway.log 2>&1 &
else
    nohup "$NODE" index.js >> gateway.log 2>&1 &
fi

sleep 8

if curl -fsS --max-time 10 "http://127.0.0.1:${PORT}/health" >/dev/null 2>&1; then
    echo "$(stamp) gateway is up"
else
    echo "$(stamp) gateway still down — check gateway.log"
    exit 1
fi
