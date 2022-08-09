ALTER TABLE `employees` ADD `Shift` INT NOT NULL AFTER `Status`;
ALTER TABLE `shifts` CHANGE `ShType` `ShiftName` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `shifts` CHANGE `ShCode` `ShiftDesc` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;