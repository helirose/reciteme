/*

Columns and tables derived from https://validator.w3.org/feed/docs/rss2.html

TextInput ignored as this is rarely used.
Whilst this may be overkill, it demonstrates how I would look to design and implement a relational
database for complex data.

*/

CREATE DATABASE IF NOT EXISTS `reciteme`;

USE `reciteme`;

CREATE TABLE IF NOT EXISTS `rss`
(
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(500) NOT NULL,
    `link` VARCHAR(500) NOT NULL,
    `description` VARCHAR(500) NOT NULL,
    `language` VARCHAR(100),
    `copyright` VARCHAR(500),
    `managing_editor` VARCHAR(100),
    `web_master` VARCHAR(100),
    `pub_date` DATETIME,
    `last_build_date` DATETIME,
    `generator` VARCHAR(500),
    `docs` VARCHAR(500),
    `cloud_id` BIGINT,
    `ttl` SMALLINT UNSIGNED,
    `image_id` BIGINT,
    `skip_hours` JSON,
    `skip_days` JSON
) ENGINE = `InnoDB` DEFAULT CHARSET = `utf8mb4` COLLATE = `utf8mb4_unicode_ci`;

CREATE TABLE IF NOT EXISTS `category`
(
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(500) NOT NULL,
    `domain` VARCHAR(500)
) ENGINE = `InnoDB` DEFAULT CHARSET = `utf8mb4` COLLATE = `utf8mb4_unicode_ci`;

CREATE TABLE IF NOT EXISTS `rss_category`
(
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `category_id` BIGINT NOT NULL,
    `rss_id` BIGINT NOT NULL
) ENGINE = `InnoDB` DEFAULT CHARSET = `utf8mb4` COLLATE = `utf8mb4_unicode_ci`;

CREATE TABLE IF NOT EXISTS `image`
(
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `url` VARCHAR(500),
    `title` VARCHAR(500),
    `link` VARCHAR(500),
    `width` SMALLINT UNSIGNED DEFAULT 88,
    `height` SMALLINT UNSIGNED DEFAULT 31,
    `description` VARCHAR(500)
) ENGINE = `InnoDB` DEFAULT CHARSET = `utf8mb4` COLLATE = `utf8mb4_unicode_ci`;

CREATE TABLE IF NOT EXISTS `cloud`
(
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `domain` VARCHAR(500),
    `port` VARCHAR(5),
    `path` VARCHAR(100),
    `register_procedure` VARCHAR(500),
    `protocol` VARCHAR(100)
) ENGINE = `InnoDB` DEFAULT CHARSET = `utf8mb4` COLLATE = `utf8mb4_unicode_ci`;


ALTER TABLE rss_category ADD CONSTRAINT fk_category_id FOREIGN KEY (category_id) REFERENCES category(id);
ALTER TABLE rss_category ADD CONSTRAINT fk_rss_id FOREIGN KEY (rss_id) REFERENCES rss(id);