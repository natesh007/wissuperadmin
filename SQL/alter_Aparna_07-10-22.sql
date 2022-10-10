ALTER TABLE `complaints` ADD `AssignedTime` DATETIME NOT NULL AFTER `UpdatedDate`;
ALTER TABLE `complaints` ADD `CompletedTime` DATETIME NOT NULL AFTER `AssignedTime`;
