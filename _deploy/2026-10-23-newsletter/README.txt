Weekly newsletter — upload bundle (23 Oct 2026)

1. Upload everything inside "upload/" to the site root, keeping the folders
   (upload/app/... -> app/..., upload/config/... -> config/..., etc.).
   The migration file is included for the record only: the tables already exist on
   the production database, so do NOT run php artisan migrate.
2. Run /run-route-cache (routes/web.php changed).
3. Add to the server .env:
     NEWSLETTER_MAIL_USERNAME=your-mailbox@dsdproperties.in
     NEWSLETTER_MAIL_PASSWORD=mailbox-password
     NEWSLETTER_FROM_NAME="DSD Properties"
   then clear the config cache if the site caches config.
4. hPanel -> Cron Jobs, every minute:
     php /home/<user>/<site-path>/artisan schedule:run
5. Open /admin/newsletter -> save draft -> Preview -> Send test to your Gmail -> Start.
