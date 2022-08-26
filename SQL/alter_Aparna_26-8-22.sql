ALTER TABLE `employees` ADD `WhatsApp` VARCHAR(15) NOT NULL AFTER `Contact`;
ALTER TABLE `complaints` ADD `ComplaintRaisedBy` VARCHAR(255) NOT NULL AFTER `AssignedNote`;
ALTER TABLE `complaints` ADD `Material` VARCHAR(255) NOT NULL AFTER `ComplaintRaisedBy`;