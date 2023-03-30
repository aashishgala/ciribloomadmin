ALTER TABLE `module` ADD `stage` INT(2) NULL AFTER `is_quiz_mod`;

ALTER TABLE `module` ADD `modcolor` VARCHAR(11) NOT NULL DEFAULT '#4066D4' COMMENT 'Set Different colour for background' AFTER `modulename`;