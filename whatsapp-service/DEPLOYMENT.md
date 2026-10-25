# Deploying the WhatsApp gateway to the VPS

The gateway runs on its own Hostinger VPS, not on the shared hosting that serves
Laravel. Shared hosting has no `npm` and kills long-running processes; the VPS
has neither problem.

```
 browser ──> dsdproperties.in (shared hosting, Laravel)
                 │   ▲
   HTTPS + token │   │ HTTPS + webhook token
                 ▼   │
         whatsapp.dsdproperties.in (VPS 187.77.156.154)
           nginx :443 ──> node index.js on 127.0.0.1:3001 (pm2)
                                   │
                                   ▼
                               WhatsApp
```

- Laravel calls the gateway at `https://whatsapp.dsdproperties.in` with
  `X-Api-Token`.
- The gateway posts incoming messages to `https://dsdproperties.in/api/whatsapp/webhook`
  with `X-WA-Token`.
- The browser never talks to the gateway. The admin panel only talks to Laravel.

Paths below assume the folder you already have: `/var/www/whatsapp.dsdproperties.in`.

**As actually deployed (2026-10-14):** the VPS already had an nginx site for
this domain, with a certbot certificate, proxying to `127.0.0.1:3000`. Rather
than edit it, which needs root, the gateway's `.env` sets `WA_PORT=3000`.
Steps 6 and the 3001 references below are for a fresh server only. The VPS
also hosts an unrelated site (converseiq, port 4000), so leave its nginx config
and port alone.

---

## 1. Prepare the VPS (once)

SSH in (`ssh dsdheer@187.77.156.154`) and check what is already there:

```bash
node -v          # needs 20 or newer
npm -v
nginx -v
pm2 -v           # may be missing
```

Install anything missing (Ubuntu/Debian):

```bash
# Node 20 LTS, if node is missing or older than 20
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs

sudo apt-get install -y nginx certbot python3-certbot-nginx
sudo npm install -g pm2
```

The placeholder page ("Server is ready. Upload the app…") is the current
`server.js`. Find what runs it and stop it, because it is probably holding the
port nginx points at:

```bash
pm2 list                         # if it shows server.js:  pm2 delete <name>
sudo ss -ltnp | grep -E ':3000|:3001|:80 '
```

---

## 2. Upload the code

From this folder, upload **only these files** to `/var/www/whatsapp.dsdproperties.in/`
(FileZilla is fine), and delete the placeholder `server.js` and `package.json`
first:

```
index.js
package.json
package-lock.json
ecosystem.config.cjs
.env.example
deploy/nginx-whatsapp.dsdproperties.in.conf
```

**Do not upload:**

- `node_modules/` — install it on the server instead (step 3). It is Linux there
  and Windows here, and `sharp` is a compiled binary.
- `auth/` — that is your *local* WhatsApp login. The server links its own with
  a fresh QR scan.
- `.env` — the server gets its own with different tokens (step 4).

---

## 3. Install the packages

```bash
cd /var/www/whatsapp.dsdproperties.in
npm ci --omit=dev
node -e "import('sharp').then(() => console.log('sharp ok'))"
```

---

## 4. Create the `.env` files

Make fresh secrets on the VPS. Do not reuse the local ones:

```bash
openssl rand -hex 24      # run twice: once for the API token, once for the webhook token
npx web-push generate-vapid-keys
```

**`/var/www/whatsapp.dsdproperties.in/.env`**

```ini
WA_PORT=3001
WA_API_TOKEN=<token 1>
WA_WEBHOOK_TOKEN=<token 2>
WA_WEBHOOK_URL=https://dsdproperties.in/api/whatsapp/webhook
WA_LOG_LEVEL=silent
WA_MAX_MEDIA_MB=25
WA_VAPID_SUBJECT=mailto:dheer725@gmail.com
WA_VAPID_PUBLIC_KEY=<public key>
WA_VAPID_PRIVATE_KEY=<private key — only here, never in Laravel>
```

```bash
chmod 600 .env
```

**Laravel `.env` on the shared hosting.** Edit these lines by hand. Production
`.env` is not deployed from here:

```ini
WHATSAPP_URL=https://whatsapp.dsdproperties.in
WHATSAPP_API_TOKEN=<token 1>
WHATSAPP_WEBHOOK_TOKEN=<token 2>
WHATSAPP_POLL_MS=6000
WHATSAPP_MAX_MEDIA_MB=25
WHATSAPP_VAPID_SUBJECT=mailto:dheer725@gmail.com
WHATSAPP_VAPID_PUBLIC_KEY=<public key>
```

Then run `php artisan config:clear` on the shared hosting. If the site uses
`config:cache`, run that again too.

The gateway refuses to start if `WA_API_TOKEN` is shorter than 32 characters,
because it is now reachable from the internet.

---

## 5. Start it with pm2

```bash
cd /var/www/whatsapp.dsdproperties.in
pm2 start ecosystem.config.cjs
pm2 save
pm2 startup          # prints one sudo command: run it so pm2 comes back after a reboot
curl -s http://127.0.0.1:3001/health
```

Useful later:

```bash
pm2 logs dsd-whatsapp        # live log
pm2 restart dsd-whatsapp     # after uploading a new index.js
```

Run exactly **one** instance. Two processes on the same `auth/` folder fight over
the session and WhatsApp logs the device out.

---

## 6. nginx + HTTPS

DNS first: `whatsapp.dsdproperties.in` must have an **A record → 187.77.156.154**.
It already resolves, since the placeholder page loads.

```bash
sudo cp deploy/nginx-whatsapp.dsdproperties.in.conf /etc/nginx/sites-available/whatsapp.dsdproperties.in
sudo ln -sf /etc/nginx/sites-available/whatsapp.dsdproperties.in /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d whatsapp.dsdproperties.in --redirect
```

If an older site config for this domain already exists in `sites-enabled/` (the
one serving the placeholder), remove it, or `nginx -t` warns about a conflicting
server name.

Firewall: open only SSH, 80 and 443. **Never open 3001.**

```bash
sudo ufw allow OpenSSH && sudo ufw allow 'Nginx Full' && sudo ufw enable
```

---

## 7. Verify, in this order

```bash
# on the VPS: gateway is up
curl -s http://127.0.0.1:3001/health

# from anywhere: nginx + HTTPS work, and the token is enforced (expect 401)
curl -s -o /dev/null -w "%{http_code}\n" https://whatsapp.dsdproperties.in/status

# from anywhere: the webhook on Laravel enforces its token (expect 401)
curl -s -o /dev/null -w "%{http_code}\n" -X POST https://dsdproperties.in/api/whatsapp/webhook -H "X-WA-Token: wrong"
```

Then open **https://dsdproperties.in/admin/whatsapp/connect**. The QR should appear
within a few seconds. Scan it from the business phone (WhatsApp → Settings →
Linked devices → Link a device).

- Message the business number from another phone. It should appear in the inbox.
- Reply from the panel with text, then with a photo.

If the connect page says the service is offline, check `last_error` on that page.
"Gateway returned HTTP 401" means the tokens differ between the two `.env` files.
A timeout means nginx or DNS.

---

## Laravel side (if not already live)

The inbox code, migrations and built assets have to be on the shared hosting.
Check that `/admin/whatsapp` loads before debugging the gateway. If it does not,
the Laravel files, the six `wa_*` migrations and `public/build/` still need
uploading. Run the migrations one by one with `--path` (plain `migrate` fails on
a duplicate `jobs` migration):

```bash
for m in 2026_09_24_000001_create_wa_chats_table \
         2026_09_24_000002_create_wa_messages_table \
         2026_09_25_000001_add_media_to_wa_messages \
         2026_09_25_000002_create_wa_quick_replies_table \
         2026_09_25_000003_create_wa_labels_table \
         2026_09_25_000004_create_wa_push_subscriptions_table; do
  php artisan migrate --force --path=database/migrations/$m.php
done
```

Incoming photos are posted to Laravel as uploads, so PHP's `upload_max_filesize`
and `post_max_size` on the shared hosting must be above `WA_MAX_MEDIA_MB`. If
they cannot be raised, lower `WA_MAX_MEDIA_MB` and `WHATSAPP_MAX_MEDIA_MB` to fit.

---

## Things that will bite you

- **Back up `auth/` on the VPS.** It is the WhatsApp login. Losing it means
  scanning again. Anyone who gets a copy has your WhatsApp.
- **The phone must stay online.** If it is off for days, WhatsApp drops the
  linked device and the panel needs a fresh scan.
- **Hostinger shared hosting must be able to reach the VPS over HTTPS.** If
  sending fails with a timeout while `curl` from your own PC works, ask Hostinger
  whether outbound connections from the shared plan are restricted.
- **This is WhatsApp Web, not the official Business API.** Bulk unsolicited
  messages are how numbers get banned. Keep it to replies and follow-ups.
