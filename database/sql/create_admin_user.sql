-- ============================================================
--  Admin login for dsdproperties.in
--  Run once in phpMyAdmin (SQL tab) against the live database.
--  MariaDB 10.3+ / 11.x. Safe to re-run — it resets the password
--  rather than creating a duplicate.
-- ============================================================

-- 1. Create the users table if it isn't there at all.
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. If the table already existed but was incomplete, top up the columns.
--    (Your create_users_table migration only defines id + timestamps.)
ALTER TABLE `users`
  ADD COLUMN IF NOT EXISTS `name` varchar(255) NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `email` varchar(255) NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `email_verified_at` timestamp NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `password` varchar(255) NOT NULL DEFAULT '',
  ADD COLUMN IF NOT EXISTS `remember_token` varchar(100) DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `created_at` timestamp NULL DEFAULT NULL,
  ADD COLUMN IF NOT EXISTS `updated_at` timestamp NULL DEFAULT NULL;

ALTER TABLE `users`
  ADD UNIQUE KEY IF NOT EXISTS `users_email_unique` (`email`);

-- 3. Create the admin account (or reset its password if it already exists).
--    email_verified_at is set because /dashboard uses the `verified` middleware.
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `created_at`, `updated_at`)
VALUES (
  'Dheeraj',
  'dheer725@gmail.com',
  NOW(),
  '$2y$12$dhFRXiRGxENCe8dM23chwehafMOKn4jhPdc9EAl8oYLFEqYdNJGKq',
  NOW(),
  NOW()
)
ON DUPLICATE KEY UPDATE
  `password`          = VALUES(`password`),
  `email_verified_at` = COALESCE(`email_verified_at`, NOW()),
  `updated_at`        = NOW();

-- 4. Check it worked — should return exactly one row.
SELECT `id`, `name`, `email`, `email_verified_at` FROM `users` WHERE `email` = 'dheer725@gmail.com';

-- ============================================================
--  TO CHANGE THE PASSWORD LATER
--    UPDATE `users` SET `password` = '<new-bcrypt-hash>'
--    WHERE `email` = 'dheer725@gmail.com';
--  Never put a plain-text password in that column.
-- ============================================================
