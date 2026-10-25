-- ============================================================================
-- form_submissions — one inbox for every public form on the site.
--
-- Hand-run equivalent of these two migrations, for servers where artisan
-- cannot be run:
--     2026_09_26_000000_create_form_submissions_table
--     2026_09_26_000100_backfill_form_submissions
--
-- Run the sections IN ORDER. Section 0 is a check, not a change.
-- Take a database backup first: section 2 derives ~600 rows from live data.
--
-- Neither source table is modified or dropped. They stay as the way back.
-- Requires MySQL 5.7+ or MariaDB 10.2+ (for the JSON functions in section 2b).
-- ============================================================================


-- ─────────────────────────────────────────────────────────────────────────────
-- 0. PRE-FLIGHT — run these three on their own and read the answers first.
-- ─────────────────────────────────────────────────────────────────────────────

-- 0a. `Key` MUST say PRI. If it is blank, crm_leads has lost its primary key
--     and section 1 will fail with errno 150 ("Foreign key constraint is
--     incorrectly formed"). Run database/sql/repair_primary_keys.sql first.
SHOW COLUMNS FROM `crm_leads` LIKE 'id';

-- 0b. Does blog_feedbacks have the email column? The answer decides whether you
--     run section 2a-WITH-EMAIL or 2a-NO-EMAIL. One row = yes, no rows = no.
SHOW COLUMNS FROM `blog_feedbacks` LIKE 'email';

-- 0c. How many rows you should end up with in section 3.
SELECT
    (SELECT COUNT(*) FROM `blog_feedbacks`)            AS blog_feedbacks_rows,
    (SELECT COUNT(*) FROM `enquiry_form_submissions`)  AS enquiry_form_rows,
    (SELECT COUNT(*) FROM `blog_feedbacks`)
  + (SELECT COUNT(*) FROM `enquiry_form_submissions`)  AS expected_total;


-- ─────────────────────────────────────────────────────────────────────────────
-- 1. CREATE THE TABLE
-- ─────────────────────────────────────────────────────────────────────────────

CREATE TABLE `form_submissions` (
  `id`           bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name`         varchar(160) DEFAULT NULL,
  `phone`        varchar(20)  DEFAULT NULL,
  `email`        varchar(191) DEFAULT NULL,
  `message`      text         DEFAULT NULL,
  `source_form`  varchar(40)  NOT NULL,
  `source_page`  varchar(500) DEFAULT NULL,
  `referrer_url` varchar(500) DEFAULT NULL,
  `ip_address`   varchar(45)  DEFAULT NULL,
  `status`       varchar(20)  NOT NULL DEFAULT 'new',
  `crm_lead_id`  bigint(20) unsigned DEFAULT NULL,
  `converted_at` datetime     DEFAULT NULL,
  `created_at`   timestamp NULL DEFAULT NULL,
  `updated_at`   timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_submissions_crm_lead_id_foreign` (`crm_lead_id`),
  KEY `form_submissions_source_form_status_created_at_index` (`source_form`,`status`,`created_at`),
  KEY `form_submissions_phone_index` (`phone`),
  KEY `form_submissions_email_index` (`email`),
  KEY `form_submissions_source_form_index` (`source_form`),
  KEY `form_submissions_status_index` (`status`),
  CONSTRAINT `form_submissions_crm_lead_id_foreign`
      FOREIGN KEY (`crm_lead_id`) REFERENCES `crm_leads` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ─────────────────────────────────────────────────────────────────────────────
-- 2. BACKFILL
--
-- Run 2a (ONE of the two versions, per check 0b) and then 2b.
-- Run each exactly once — running one twice duplicates every row it copies.
-- ─────────────────────────────────────────────────────────────────────────────

-- 2a-WITH-EMAIL — use this if check 0b returned a row.
-- Exit-intent popup. A clean one-to-one mapping.
INSERT INTO `form_submissions`
    (`name`, `phone`, `email`, `message`, `source_form`,
     `source_page`, `referrer_url`, `ip_address`, `status`,
     `crm_lead_id`, `converted_at`, `created_at`, `updated_at`)
SELECT
    `name`,
    `mobile`,
    NULLIF(`email`, ''),
    `suggestion`,
    'exit_intent',
    NULLIF(`page_url`, ''),
    NULL,
    `ip_address`,
    'new',
    NULL,
    NULL,
    `created_at`,
    `updated_at`
FROM `blog_feedbacks`
ORDER BY `id`;

-- 2a-NO-EMAIL — use this INSTEAD if check 0b returned no rows.
-- (Identical, but does not read a column that is not there yet.)
--
-- INSERT INTO `form_submissions`
--     (`name`, `phone`, `email`, `message`, `source_form`,
--      `source_page`, `referrer_url`, `ip_address`, `status`,
--      `crm_lead_id`, `converted_at`, `created_at`, `updated_at`)
-- SELECT
--     `name`, `mobile`, NULL, `suggestion`, 'exit_intent',
--     NULLIF(`page_url`, ''), NULL, `ip_address`, 'new',
--     NULL, NULL, `created_at`, `updated_at`
-- FROM `blog_feedbacks`
-- ORDER BY `id`;


-- 2b. Legacy JSON table.
--
-- Contact-us and the blog sidebar both wrote form_name = 'Ebook Form', so those
-- rows genuinely cannot be attributed to one form or the other. They are marked
-- 'legacy_inquiry' rather than guessed at. New submissions carry a source_form
-- field and are labelled correctly.
--
-- Rows whose params will not parse as JSON hold nothing usable and are skipped
-- by the JSON_VALID guard.
INSERT INTO `form_submissions`
    (`name`, `phone`, `email`, `message`, `source_form`,
     `source_page`, `referrer_url`, `ip_address`, `status`,
     `crm_lead_id`, `converted_at`, `created_at`, `updated_at`)
SELECT
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.full_name')),
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.phone_number')),
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.email')),
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.message')),
    CASE WHEN LOWER(TRIM(`form_name`)) = 'newsletter'
         THEN 'newsletter'
         ELSE 'legacy_inquiry'
    END,
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.page_url')),
    JSON_UNQUOTE(JSON_EXTRACT(`params`, '$.referrer_url')),
    NULL,
    'new',
    NULL,
    NULL,
    `created_at`,
    `updated_at`
FROM `enquiry_form_submissions`
WHERE `params` IS NOT NULL
  AND JSON_VALID(`params`)
ORDER BY `id`;


-- ─────────────────────────────────────────────────────────────────────────────
-- 3. VERIFY — check these before section 4.
-- ─────────────────────────────────────────────────────────────────────────────

-- Total must equal `expected_total` from 0c (minus any unparseable params rows).
SELECT COUNT(*) AS total FROM `form_submissions`;

-- Expected shape: exit_intent = blog_feedbacks count,
-- legacy_inquiry + newsletter = enquiry_form_submissions count.
SELECT `source_form`, COUNT(*) AS rows_copied
FROM `form_submissions`
GROUP BY `source_form`
ORDER BY `source_form`;

-- Spot-check the JSON mapping actually landed in the right columns.
SELECT `id`, `name`, `phone`, `email`, `source_form`, `created_at`
FROM `form_submissions`
WHERE `source_form` = 'legacy_inquiry'
ORDER BY `id`
LIMIT 5;


-- ─────────────────────────────────────────────────────────────────────────────
-- 4. RECORD THE MIGRATIONS
--
-- Tells Laravel both migrations are already applied, so a later `artisan
-- migrate` does not try to create the table again or double the backfill.
-- Do NOT run this until sections 1–3 have succeeded.
-- ─────────────────────────────────────────────────────────────────────────────

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_09_26_000000_create_form_submissions_table', `b` FROM
    (SELECT COALESCE(MAX(`batch`), 0) + 1 AS `b` FROM `migrations`) AS `t`;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_09_26_000100_backfill_form_submissions', MAX(`batch`) FROM `migrations`;

-- Both rows should come back, sharing one batch number.
SELECT * FROM `migrations` WHERE `migration` LIKE '2026_09_26_%';


-- ============================================================================
-- ROLLBACK, if the inbox turns out wrong.
--
-- blog_feedbacks and enquiry_form_submissions were never touched, so nothing is
-- lost except submissions received after the cutover. Revert the PHP files too,
-- or the forms will write to a table that is no longer there.
--
--   DELETE FROM `migrations` WHERE `migration` LIKE '2026_09_26_%';
--   DROP TABLE `form_submissions`;
-- ============================================================================
