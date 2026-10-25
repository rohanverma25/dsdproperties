# DSD Properties — Verification Module Setup

## Step 1 — Run SQL in phpMyAdmin

Open phpMyAdmin → select your database → SQL tab → paste and run:

```sql
-- 1. Counter table (generates DSD-VER-YYYY-NNNN IDs)
CREATE TABLE `verification_counters` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` int(4) NOT NULL,
  `last_seq` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `verification_counters_year_unique` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed current year
INSERT INTO `verification_counters` (`year`, `last_seq`) VALUES (YEAR(NOW()), 0);


-- 2. Main reports table
CREATE TABLE `verification_reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_id` varchar(20) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `property_address` text NOT NULL,
  `property_khasra` varchar(100) DEFAULT NULL,
  `property_gata` varchar(100) DEFAULT NULL,
  `property_area` varchar(100) NOT NULL,
  `property_type` enum('plot','flat','house','commercial') NOT NULL DEFAULT 'plot',
  `seller_name` varchar(255) NOT NULL,
  `asking_price` bigint(20) DEFAULT NULL,
  `tehsil` enum('sadar','bkt','mohanlalganj','malihabad','other') NOT NULL DEFAULT 'sadar',
  `verifier_name` varchar(255) DEFAULT NULL,
  `verifier_visit_date` date DEFAULT NULL,
  `verdict` enum('green','amber','red') DEFAULT NULL,
  `verdict_summary_hindi` text DEFAULT NULL,
  `status` enum('draft','in_progress','ready_to_deliver','delivered') NOT NULL DEFAULT 'draft',
  `pdf_path` varchar(500) DEFAULT NULL,
  `pdf_password` varchar(10) DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `delivery_channel` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `verification_reports_report_id_unique` (`report_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 3. Findings (one row per check per report, 9 rows total)
CREATE TABLE `verification_findings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `verification_report_id` bigint(20) UNSIGNED NOT NULL,
  `check_slug` varchar(100) NOT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('clear','note','issue','not_applicable') NOT NULL DEFAULT 'clear',
  `what_checked_hindi` text DEFAULT NULL,
  `where_checked_hindi` text DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` varchar(20) DEFAULT NULL,
  `findings_hindi` text DEFAULT NULL,
  `red_flags_hindi` text DEFAULT NULL,
  `evidence_reference` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_findings_report_id_foreign` (`verification_report_id`),
  CONSTRAINT `vf_report_fk` FOREIGN KEY (`verification_report_id`) REFERENCES `verification_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 4. Evidence files
CREATE TABLE `verification_evidences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `verification_report_id` bigint(20) UNSIGNED NOT NULL,
  `evidence_code` varchar(10) NOT NULL,
  `check_slug` varchar(100) DEFAULT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_type_hindi` varchar(500) NOT NULL,
  `source_office_hindi` varchar(500) NOT NULL,
  `extracted_by` varchar(255) NOT NULL,
  `extracted_on` date NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_mime` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` bigint(20) NOT NULL DEFAULT 0,
  `page_count` int(11) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_evidences_report_id_foreign` (`verification_report_id`),
  CONSTRAINT `ve_report_fk` FOREIGN KEY (`verification_report_id`) REFERENCES `verification_reports` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Step 2 — Add env variable

In `.env` add:

```
VER_ADMIN_PASSWORD=dsd@admin2026
```

Change the password to something strong.

---

## Step 3 — Create storage directories

On shared hosting via File Manager, create these directories (if they don't exist):

```
storage/app/private/reports/
storage/app/private/evidences/
storage/fonts/
```

Set permissions to 755.

---

## Step 4 — Download Hindi fonts (one-time)

Visit this URL while logged into admin:

```
https://dsdproperties.in/admin/verifications/setup/fonts
```

This downloads `NotoSansDevanagari-Regular.ttf` and `NotoSansDevanagari-Bold.ttf`
into `public/fonts/` using Guzzle. Takes ~30 seconds.

After downloading, you'll see the font warning disappear from the edit page.

---

## Step 5 — Test

1. Go to `/admin/verifications/login`
2. Enter your `VER_ADMIN_PASSWORD`
3. Click "नई रिपोर्ट" → fill and submit
4. Fill all 9 findings in the edit page
5. Upload at least one evidence
6. Set verdict + summary → click "PDF बनाएं"
7. Click "वितरित करें" → open WhatsApp link

---

## Module URLs

| URL | Purpose |
|-----|---------|
| `/admin/verifications/login` | Admin login |
| `/admin/verifications` | Report list |
| `/admin/verifications/create` | New report |
| `/admin/verifications/{id}/edit` | Edit report (5 tabs) |
| `/admin/verifications/setup/fonts` | Download Hindi fonts |
| `/verify/{DSD-VER-YYYY-NNNN}` | Public authenticity check |
| `/verification-download/{id}?signature=...` | Customer PDF download (signed URL) |
