CREATE TABLE task_types(
    `id` BIGINT UNSIGNED PRIMARY,
    `type` VARCHAR(255)
);

CREATE TABLE tasks(
    `id` BIGINT UNSIGNED PRIMARY,
    `task_type_id` BIGINT UNSIGNED,
    `priority`INT,
    `result` TEXT,
    `executing` BOOLEAN,
    `executed` BOOLEAN,
    `failed` BOOLEAN
    `created_at` TIMESTAMP,
    `started_at` TIMESTAMP,
    `failed_at` TIMESTAMP,
    `succeded_at` TIMESTAMP
)