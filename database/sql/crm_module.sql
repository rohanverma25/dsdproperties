-- ============================================================
--  CRM follow-up module — schema install
--  Generated from Laravel's MySqlGrammar, identical to what
--  `php artisan migrate` would have executed.
--
--  Creates: crm_leads, crm_lead_activities
--  Touches nothing else. The legacy `leads` table is unaffected.
--  Safe to run once. Run the whole file in one go.
-- ============================================================

-- ---------- 1. crm_leads ----------
CREATE TABLE `crm_leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `alt_phone` varchar(255) NULL,
  `source_page` varchar(255) NULL,
  `source_channel` enum('whatsapp','form','referral','walkin') NULL,
  `intent` enum('buy','rent','sell','verification') NULL,
  `scheme_interest` varchar(255) NULL,
  `area` varchar(255) NULL,
  `budget_min` bigint unsigned NULL,
  `budget_max` bigint unsigned NULL,
  `flexible` tinyint(1) NULL,
  `stage` enum('new','qualified','site_visit','negotiation','won','lost','dormant') NOT NULL DEFAULT 'new',
  `next_followup_at` date NULL,
  `last_contact_at` datetime NULL,
  `no_answer_count` int unsigned NOT NULL DEFAULT '0',
  `notes` text NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  `deleted_at` timestamp NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `crm_leads` ADD UNIQUE `crm_leads_phone_unique`(`phone`);
ALTER TABLE `crm_leads` ADD INDEX `crm_leads_next_followup_at_index`(`next_followup_at`);


-- ---------- 2. crm_lead_activities ----------
CREATE TABLE `crm_lead_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `crm_lead_id` bigint unsigned NOT NULL,
  `type` enum('call','whatsapp','visit','note') NOT NULL,
  `outcome` enum('no_answer','call_later','interested','site_visit_fixed','not_interested') NULL,
  `note` text NULL,
  `happened_at` datetime NOT NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE 'utf8mb4_unicode_ci';

ALTER TABLE `crm_lead_activities`
  ADD CONSTRAINT `crm_lead_activities_crm_lead_id_foreign`
  FOREIGN KEY (`crm_lead_id`) REFERENCES `crm_leads` (`id`) ON DELETE CASCADE;


-- ---------- 3. Mark the migrations as already run ----------
-- Without this, a future `php artisan migrate` will try to create
-- these tables again and fail.
INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('2026_09_20_100000_create_crm_leads_table',           (SELECT * FROM (SELECT COALESCE(MAX(b.batch),0)+1 FROM `migrations` b) AS t)),
  ('2026_09_20_100100_create_crm_lead_activities_table', (SELECT * FROM (SELECT COALESCE(MAX(b.batch),0)   FROM `migrations` b) AS t));


-- ============================================================
--  ROLLBACK (only if you need to undo the above)
-- ============================================================
-- SET FOREIGN_KEY_CHECKS = 0;
-- DROP TABLE IF EXISTS `crm_lead_activities`;
-- DROP TABLE IF EXISTS `crm_leads`;
-- SET FOREIGN_KEY_CHECKS = 1;
-- DELETE FROM `migrations` WHERE `migration` IN (
--   '2026_09_20_100000_create_crm_leads_table',
--   '2026_09_20_100100_create_crm_lead_activities_table'
-- );
