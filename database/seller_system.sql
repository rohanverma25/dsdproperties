-- ============================================================
--  DSD Properties — Seller Listing System
--  Import this file via phpMyAdmin to set up all tables.
--  Safe to run on existing database — uses IF NOT EXISTS.
--  Generated: April 2026
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -------------------------------------------------------
-- Table: sellers
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sellers` (
  `id`                bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`              varchar(255) NOT NULL,
  `email`             varchar(255) NOT NULL,
  `phone`             varchar(20)  NOT NULL,
  `whatsapp`          varchar(20)  DEFAULT NULL,
  `password`          varchar(255) NOT NULL,
  `profile_photo`     varchar(255) DEFAULT NULL,
  `city`              varchar(100) NOT NULL DEFAULT 'Lucknow',
  `about`             text         DEFAULT NULL,
  `status`            enum('active','suspended') NOT NULL DEFAULT 'active',
  `remember_token`    varchar(100) DEFAULT NULL,
  `created_at`        timestamp NULL DEFAULT NULL,
  `updated_at`        timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `sellers_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Table: property_listings
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_listings` (
  `id`                bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_id`         bigint(20) UNSIGNED NOT NULL,
  `title`             varchar(255) NOT NULL,
  `slug`              varchar(300) NOT NULL,
  `property_type`     enum('flat','house','plot','commercial','office','builder_floor','villa') NOT NULL,
  `transaction_type`  enum('sell','rent') NOT NULL DEFAULT 'sell',
  `price`             bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `price_negotiable`  tinyint(1) NOT NULL DEFAULT 0,
  `price_on_request`  tinyint(1) NOT NULL DEFAULT 0,
  `area`              decimal(10,2) DEFAULT NULL,
  `area_unit`         enum('sqft','sqyard','sqmtr','bigha','acre') NOT NULL DEFAULT 'sqft',
  `bedrooms`          tinyint(3) UNSIGNED DEFAULT NULL,
  `bathrooms`         tinyint(3) UNSIGNED DEFAULT NULL,
  `balconies`         tinyint(3) UNSIGNED DEFAULT NULL,
  `floor_no`          tinyint(3) UNSIGNED DEFAULT NULL,
  `total_floors`      tinyint(3) UNSIGNED DEFAULT NULL,
  `furnishing`        enum('unfurnished','semi_furnished','fully_furnished') DEFAULT NULL,
  `property_age`      enum('new_construction','less_5','5_10','10_20','above_20') DEFAULT NULL,
  `facing`            varchar(50)  DEFAULT NULL,
  `parking`           varchar(50)  DEFAULT NULL,
  `address`           text         NOT NULL,
  `locality`          varchar(255) NOT NULL,
  `landmark`          varchar(255) DEFAULT NULL,
  `pincode`           varchar(10)  DEFAULT NULL,
  `description`       text         NOT NULL,
  `amenities`         longtext     CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `featured_image`    varchar(255) DEFAULT NULL,
  `status`            enum('draft','pending','published','rejected','archived') NOT NULL DEFAULT 'draft',
  `rejection_reason`  text         DEFAULT NULL,
  `views`             int(11) NOT NULL DEFAULT 0,
  `created_at`        timestamp NULL DEFAULT NULL,
  `updated_at`        timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `property_listings_slug_unique` (`slug`),
  KEY `property_listings_seller_id_foreign` (`seller_id`),
  KEY `property_listings_status_index` (`status`),
  KEY `property_listings_locality_index` (`locality`),
  CONSTRAINT `property_listings_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Table: property_images
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_images` (
  `id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_id`  bigint(20) UNSIGNED NOT NULL,
  `image_path`  varchar(255) NOT NULL,
  `caption`     varchar(255) DEFAULT NULL,
  `sort_order`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at`  timestamp NULL DEFAULT NULL,
  `updated_at`  timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `property_images_listing_id_foreign` (`listing_id`),
  CONSTRAINT `property_images_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `property_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Table: property_inquiries
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `property_inquiries` (
  `id`          bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `listing_id`  bigint(20) UNSIGNED NOT NULL,
  `name`        varchar(255) NOT NULL,
  `phone`       varchar(20)  NOT NULL,
  `email`       varchar(255) DEFAULT NULL,
  `message`     text         DEFAULT NULL,
  `ip_address`  varchar(50)  DEFAULT NULL,
  `created_at`  timestamp NULL DEFAULT NULL,
  `updated_at`  timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `property_inquiries_listing_id_foreign` (`listing_id`),
  CONSTRAINT `property_inquiries_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `property_listings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------
-- Done. Import complete.
-- -------------------------------------------------------
