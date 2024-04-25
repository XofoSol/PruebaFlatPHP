CREATE TABLE task_types(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(255),
    PRIMARY KEY(`id`)
);

INSERT INTO task_types(id, type) VALUES (1,'Get the title from an url');
INSERT INTO task_types(id, type) VALUES (2,'Get a joke from joke service');
INSERT INTO task_types(id, type) VALUES (3,'Get the date (Warning: could fail)');

CREATE TABLE tasks(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `task_type_id` BIGINT UNSIGNED NOT NULL,
    `priority`INT DEFAULT 0,
    `result` TEXT,
    `executing` BOOLEAN DEFAULT false,
    `executed` BOOLEAN DEFAULT false,
    `failed` BOOLEAN DEFAULT false,
    `intent` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `start_at` TIMESTAMP NULL DEFAULT NULL,
    `failed_at` TIMESTAMP NULL DEFAULT NULL,
    `succeded_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE task_metas(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `task_id` BIGINT UNSIGNED NOT NULL,
    `key` VARCHAR(255),
    `value` TEXT,
    PRIMARY KEY(`id`)
);