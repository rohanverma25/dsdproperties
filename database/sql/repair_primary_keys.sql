-- Repair primary keys and AUTO_INCREMENT after the live-DB import.
-- Generated 2026-09-24 12:13 for database `lucknow_properties`.
--
-- The import created every table WITHOUT its PRIMARY KEY or AUTO_INCREMENT,
-- so Laravel can read rows but cannot insert any. These statements restore
-- only the key definitions - no row data is read, changed or deleted.
--
-- Skipped on purpose: listing_tag and password_resets have no id column
-- and Laravel does not give them a primary key.

SET FOREIGN_KEY_CHECKS = 0;

-- blogs (0 rows, next id 1)
ALTER TABLE `blogs`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

-- blog_comments (47 rows, next id 51)
ALTER TABLE `blog_comments`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 51;

-- blog_feedbacks (251 rows, next id 255)
ALTER TABLE `blog_feedbacks`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 255;

-- blog_posts (94 rows, next id 163)
ALTER TABLE `blog_posts`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 163;

-- blog_posts_backup_glyphfix (9 rows, next id 157)
ALTER TABLE `blog_posts_backup_glyphfix`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 157;

-- crm_leads (8 rows, next id 9)
ALTER TABLE `crm_leads`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

-- crm_lead_activities (3 rows, next id 4)
ALTER TABLE `crm_lead_activities`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

-- email_logs (0 rows, next id 1)
ALTER TABLE `email_logs`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

-- email_templates (6 rows, next id 9)
ALTER TABLE `email_templates`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

-- enquiry_form_submissions (379 rows, next id 474)
ALTER TABLE `enquiry_form_submissions`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 474;

-- failed_jobs (1 rows, next id 2)
ALTER TABLE `failed_jobs`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

-- galleries (5 rows, next id 7)
ALTER TABLE `galleries`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;

-- gallery_images (20 rows, next id 25)
ALTER TABLE `gallery_images`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 25;

-- gallery_page_links (3 rows, next id 4)
ALTER TABLE `gallery_page_links`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

-- google_reviews (14 rows, next id 15)
ALTER TABLE `google_reviews`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 15;

-- jobs (11 rows, next id 13)
ALTER TABLE `jobs`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 13;

-- leads (8761 rows, next id 8775)
ALTER TABLE `leads`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 8775;

-- listing_drafts (0 rows, next id 1)
ALTER TABLE `listing_drafts`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

-- migrations (13 rows, next id 14)
ALTER TABLE `migrations`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 14;

-- news_articles (105 rows, next id 141)
ALTER TABLE `news_articles`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 141;

-- personal_access_tokens (0 rows, next id 1)
ALTER TABLE `personal_access_tokens`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 1;

-- property_images (109 rows, next id 115)
ALTER TABLE `property_images`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 115;

-- property_inquiries (15 rows, next id 23)
ALTER TABLE `property_inquiries`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 23;

-- property_listings (28 rows, next id 35)
ALTER TABLE `property_listings`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 35;

-- sellers (123 rows, next id 130)
ALTER TABLE `sellers`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 130;

-- tags (25 rows, next id 26)
ALTER TABLE `tags`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 26;

-- users (2 rows, next id 3)
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

SET FOREIGN_KEY_CHECKS = 1;

-- 27 tables repaired.
