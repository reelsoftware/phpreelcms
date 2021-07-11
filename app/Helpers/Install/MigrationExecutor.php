<?php
namespace App\Helpers\Install; 

use DB;

class MigrationExecutor
{
    /**
     * Helper function to create the required tables
     *
     */
    public static function migrateDatabase()
    {
        DB::statement("CREATE TABLE IF NOT EXISTS `videos` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
            `storage` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `premium` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        )");

        DB::statement("CREATE TABLE IF NOT EXISTS `failed_jobs` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
           ) ");

        DB::statement("CREATE TABLE IF NOT EXISTS `images` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
            `storage` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `migrations` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `batch` int(11) NOT NULL,
            PRIMARY KEY (`id`)
           ) ");

        DB::statement("CREATE TABLE IF NOT EXISTS `movies` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `year` smallint(5) unsigned NOT NULL,
            `rating` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `length` mediumint(8) unsigned NOT NULL,
            `cast` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `genre` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `thumbnail` bigint(20) unsigned NOT NULL,
            `video` bigint(20) unsigned NOT NULL,
            `public` tinyint(1) NOT NULL DEFAULT '0',
            `trailer` bigint(20) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `movies_thumbnail_foreign` (`thumbnail`),
            KEY `movies_video_foreign` (`video`),
            KEY `movies_trailer_foreign` (`trailer`),
            CONSTRAINT `movies_thumbnail_foreign` FOREIGN KEY (`thumbnail`) REFERENCES `images` (`id`),
            CONSTRAINT `movies_trailer_foreign` FOREIGN KEY (`trailer`) REFERENCES `videos` (`id`),
            CONSTRAINT `movies_video_foreign` FOREIGN KEY (`video`) REFERENCES `videos` (`id`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `password_resets` (
            `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            KEY `password_resets_email_index` (`email`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `series` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `year` smallint(5) unsigned NOT NULL,
            `rating` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `cast` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `genre` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `public` tinyint(1) NOT NULL DEFAULT '0',
            `thumbnail` bigint(20) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `series_thumbnail_foreign` (`thumbnail`),
            CONSTRAINT `series_thumbnail_foreign` FOREIGN KEY (`thumbnail`) REFERENCES `images` (`id`)
           ) ");

        DB::statement("CREATE TABLE IF NOT EXISTS `settings` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `setting` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`)
           )");

        DB::statement("	CREATE TABLE IF NOT EXISTS `subscriptions` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) unsigned NOT NULL,
            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `stripe_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `quantity` int(11) DEFAULT NULL,
            `trial_ends_at` timestamp NULL DEFAULT NULL,
            `ends_at` timestamp NULL DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `subscription_items` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `subscription_id` bigint(20) unsigned NOT NULL,
            `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `quantity` int(11) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `subscription_items_subscription_id_stripe_plan_unique` (`subscription_id`,`stripe_plan`),
            KEY `subscription_items_stripe_id_index` (`stripe_id`)
           ) ");

        DB::statement("CREATE TABLE IF NOT EXISTS `subscription_types` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `product_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            `public` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ");

        DB::statement("CREATE TABLE IF NOT EXISTS `subscription_plans` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `stripe_price_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
            `benefits` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `subscription_type_id` bigint(20) unsigned NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `price` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
            `billing_interval` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
            `public` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `subscription_plans_subscription_type_id_foreign` (`subscription_type_id`),
            CONSTRAINT `subscription_plans_subscription_type_id_foreign` FOREIGN KEY (`subscription_type_id`) REFERENCES `subscription_types` (`id`)
        )");

        DB::statement("	CREATE TABLE IF NOT EXISTS `translations` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `language` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `users` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email_verified_at` timestamp NULL DEFAULT NULL,
            `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
            `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `card_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `trial_ends_at` timestamp NULL DEFAULT NULL,
            `roles` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
            `language` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `users_email_unique` (`email`),
            KEY `users_stripe_id_index` (`stripe_id`)
           )");

        DB::statement("CREATE TABLE IF NOT EXISTS `seasons` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `order` smallint(6) NOT NULL,
            `series_id` bigint(20) unsigned NOT NULL,
            `thumbnail` bigint(20) unsigned NOT NULL,
            `trailer` bigint(20) unsigned NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `year` smallint(5) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            KEY `seasons_series_id_foreign` (`series_id`),
            KEY `seasons_thumbnail_foreign` (`thumbnail`),
            KEY `seasons_trailer_foreign` (`trailer`),
            CONSTRAINT `seasons_series_id_foreign` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`),
            CONSTRAINT `seasons_thumbnail_foreign` FOREIGN KEY (`thumbnail`) REFERENCES `images` (`id`),
            CONSTRAINT `seasons_trailer_foreign` FOREIGN KEY (`trailer`) REFERENCES `videos` (`id`)
        )");

        DB::statement("CREATE TABLE IF NOT EXISTS `episodes` (
            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
            `season_id` bigint(20) unsigned NOT NULL,
            `thumbnail` bigint(20) unsigned NOT NULL,
            `video` bigint(20) unsigned NOT NULL,
            `length` mediumint(8) unsigned NOT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `public` tinyint(1) NOT NULL DEFAULT '0',
            `order` smallint(6) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `episodes_season_id_foreign` (`season_id`),
            KEY `episodes_thumbnail_foreign` (`thumbnail`),
            KEY `episodes_video_foreign` (`video`),
            CONSTRAINT `episodes_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`),
            CONSTRAINT `episodes_thumbnail_foreign` FOREIGN KEY (`thumbnail`) REFERENCES `images` (`id`),
            CONSTRAINT `episodes_video_foreign` FOREIGN KEY (`video`) REFERENCES `videos` (`id`)
        )");

        //v0.2.0 
        DB::statement("ALTER TABLE movies ADD premium BOOLEAN NOT NULL DEFAULT 1");
        DB::statement("ALTER TABLE movies ADD auth BOOLEAN NOT NULL DEFAULT 1");
        DB::statement("ALTER TABLE episodes ADD premium BOOLEAN NOT NULL DEFAULT 1");
        DB::statement("ALTER TABLE episodes ADD auth BOOLEAN NOT NULL DEFAULT 1");
        DB::statement("ALTER TABLE videos ADD auth BOOLEAN NOT NULL DEFAULT 1");
        
    }
}