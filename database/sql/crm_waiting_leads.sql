-- ============================================================================
-- crm_leads: "waiting" leads (registry not open yet, plot not in stock, ...).
--
-- Hand-run equivalent of the migration
--     2026_11_02_000001_add_waiting_to_crm_leads
-- for servers where artisan cannot be run. Run it in phpMyAdmin BEFORE
-- deploying the code that uses these columns.
--
-- Only adds two empty, nullable columns; no existing data is changed.
-- ============================================================================

-- 0. Check first. No rows = not added yet, go ahead. One row = already done, stop.
SHOW COLUMNS FROM `crm_leads` LIKE 'waiting_for';

-- 1. The columns.
ALTER TABLE `crm_leads`
    ADD COLUMN `waiting_for` VARCHAR(40) NULL DEFAULT NULL AFTER `stage`,
    ADD COLUMN `requirement` VARCHAR(255) NULL DEFAULT NULL AFTER `waiting_for`,
    ADD INDEX `crm_leads_waiting_for_index` (`waiting_for`);

-- 2. Tell Laravel the migration is applied, so a later `artisan migrate` skips it.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_11_02_000001_add_waiting_to_crm_leads', `b` FROM
    (SELECT COALESCE(MAX(`batch`), 0) + 1 AS `b` FROM `migrations`) AS `t`;
