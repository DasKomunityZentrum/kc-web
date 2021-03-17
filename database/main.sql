-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 17. bře 2021, 15:19
-- Verze serveru: 10.4.17-MariaDB
-- Verze PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kc`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `branch`
--

CREATE TABLE `branch` (
                          `id` int(11) NOT NULL COMMENT 'ID',
                          `name` varchar(512) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                          `city` varchar(512) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'City',
                          `description` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci COMMENT='Branches';

-- --------------------------------------------------------

--
-- Struktura tabulky `car`
--

CREATE TABLE `car` (
                       `id` int(11) NOT NULL,
                       `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                       `active` tinyint(1) NOT NULL COMMENT 'Active?',
                       `nick` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Nick of car',
                       `ccc` float NOT NULL,
                       `kw` int(11) NOT NULL,
                       `note` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Cars';

-- --------------------------------------------------------

--
-- Struktura tabulky `cause`
--

CREATE TABLE `cause` (
                         `id` int(11) NOT NULL COMMENT 'ID',
                         `memberId` int(11) NOT NULL COMMENT 'Member ID',
                         `departmentId` int(11) NOT NULL COMMENT 'Departement ID',
                         `state` int(11) NOT NULL COMMENT 'State',
                         `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                         `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Desription',
                         `conclusion` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Conclusion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Causes';

-- --------------------------------------------------------

--
-- Struktura tabulky `department`
--

CREATE TABLE `department` (
                              `id` int(11) NOT NULL COMMENT 'ID',
                              `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                              `description` text COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Description',
                              `onStrike` tinyint(1) NOT NULL COMMENT 'On strike?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `department2function`
--

CREATE TABLE `department2function` (
                                       `departmentId` int(11) NOT NULL COMMENT 'Department ID',
                                       `functionId` int(11) NOT NULL COMMENT 'Function ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `department2function2member`
--

CREATE TABLE `department2function2member` (
                                              `departmentId` int(11) NOT NULL COMMENT 'Department ID',
                                              `functionId` int(11) NOT NULL COMMENT 'Function ID',
                                              `memberId` int(11) NOT NULL COMMENT 'Member ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `function`
--

CREATE TABLE `function` (
                            `id` int(11) NOT NULL COMMENT 'ID',
                            `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                            `type` int(11) NOT NULL COMMENT 'Type',
                            `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions';

-- --------------------------------------------------------

--
-- Struktura tabulky `meeting`
--

CREATE TABLE `meeting` (
                           `id` int(11) NOT NULL COMMENT 'ID',
                           `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'name',
                           `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description',
                           `date` date NOT NULL DEFAULT current_timestamp() COMMENT 'Date',
                           `type` int(11) NOT NULL COMMENT 'Type',
                           `isRegular` tinyint(1) NOT NULL COMMENT 'Is Regular?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Meetings';

-- --------------------------------------------------------

--
-- Struktura tabulky `member`
--

CREATE TABLE `member` (
                          `id` int(11) NOT NULL COMMENT 'ID',
                          `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                          `surname` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Surname',
                          `nick` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Nick',
                          `birthYear` year(4) DEFAULT NULL COMMENT 'Yaer of birth',
                          `gender` varchar(1) COLLATE utf8_czech_ci NOT NULL COMMENT 'Gender',
                          `active` tinyint(1) NOT NULL COMMENT 'Active?',
                          `type` int(11) NOT NULL COMMENT 'Member type',
                          `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description',
                          `carId` int(11) DEFAULT NULL COMMENT 'Car ID',
                          `branchId` int(11) DEFAULT NULL COMMENT 'Branch ID',
                          `profilePhoto` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Profile photo file name',
                          `profilePhotoExtension` varchar(25) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Profile photo file extension'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Members';

-- --------------------------------------------------------

--
-- Struktura tabulky `member2function`
--

CREATE TABLE `member2function` (
                                   `memberId` int(11) NOT NULL COMMENT 'Member ID',
                                   `functionId` int(11) NOT NULL COMMENT 'Function ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Members';

-- --------------------------------------------------------

--
-- Struktura tabulky `member2meeting`
--

CREATE TABLE `member2meeting` (
                                  `memberId` int(11) NOT NULL COMMENT 'Member ID',
                                  `meetingId` int(11) NOT NULL COMMENT 'Meeting ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Meetings of Members';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `branch`
--
ALTER TABLE `branch`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `car`
--
ALTER TABLE `car`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `cause`
--
ALTER TABLE `cause`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Cause_MemberId` (`memberId`),
  ADD KEY `K_Cause_DepartmentId` (`departmentId`);

--
-- Klíče pro tabulku `department`
--
ALTER TABLE `department`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `department2function`
--
ALTER TABLE `department2function`
    ADD PRIMARY KEY (`departmentId`,`functionId`) USING BTREE,
  ADD KEY `FK_Department2function_Function_Id` (`functionId`) USING BTREE;

--
-- Klíče pro tabulku `department2function2member`
--
ALTER TABLE `department2function2member`
    ADD PRIMARY KEY (`departmentId`,`functionId`,`memberId`) USING BTREE,
  ADD KEY `FK_Department2function2member2member_Function_Id` (`functionId`),
  ADD KEY `FK_Department2function2member2member_Member_Id` (`memberId`);

--
-- Klíče pro tabulku `function`
--
ALTER TABLE `function`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `meeting`
--
ALTER TABLE `meeting`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `member`
--
ALTER TABLE `member`
    ADD PRIMARY KEY (`id`),
  ADD KEY `K_Member_CarId` (`carId`),
  ADD KEY `K_Member_BranchId` (`branchId`);

--
-- Klíče pro tabulku `member2function`
--
ALTER TABLE `member2function`
    ADD PRIMARY KEY (`memberId`,`functionId`),
  ADD KEY `FK_Function_Id` (`functionId`);

--
-- Klíče pro tabulku `member2meeting`
--
ALTER TABLE `member2meeting`
    ADD PRIMARY KEY (`memberId`,`meetingId`),
  ADD KEY `FK_Member2Meeting_MeetingId` (`meetingId`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `branch`
--
ALTER TABLE `branch`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `car`
--
ALTER TABLE `car`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `cause`
--
ALTER TABLE `cause`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `department`
--
ALTER TABLE `department`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `function`
--
ALTER TABLE `function`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `meeting`
--
ALTER TABLE `meeting`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `member`
--
ALTER TABLE `member`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- Omezení pro exportované tabulky
---- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 17. bře 2021, 15:19
-- Verze serveru: 10.4.17-MariaDB
-- Verze PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kc`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `branch`
--

CREATE TABLE `branch` (
                          `id` int(11) NOT NULL COMMENT 'ID',
                          `name` varchar(512) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                          `city` varchar(512) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'City',
                          `description` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci COMMENT='Branches';

-- --------------------------------------------------------

--
-- Struktura tabulky `car`
--

CREATE TABLE `car` (
                       `id` int(11) NOT NULL,
                       `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                       `active` tinyint(1) NOT NULL COMMENT 'Active?',
                       `nick` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Nick of car',
                       `ccc` float NOT NULL,
                       `kw` int(11) NOT NULL,
                       `note` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Note'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Cars';

-- --------------------------------------------------------

--
-- Struktura tabulky `cause`
--

CREATE TABLE `cause` (
                         `id` int(11) NOT NULL COMMENT 'ID',
                         `memberId` int(11) NOT NULL COMMENT 'Member ID',
                         `departmentId` int(11) NOT NULL COMMENT 'Departement ID',
                         `state` int(11) NOT NULL COMMENT 'State',
                         `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                         `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Desription',
                         `conclusion` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Conclusion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Causes';

-- --------------------------------------------------------

--
-- Struktura tabulky `department`
--

CREATE TABLE `department` (
                              `id` int(11) NOT NULL COMMENT 'ID',
                              `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                              `description` text COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Description',
                              `onStrike` tinyint(1) NOT NULL COMMENT 'On strike?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `department2function`
--

CREATE TABLE `department2function` (
                                       `departmentId` int(11) NOT NULL COMMENT 'Department ID',
                                       `functionId` int(11) NOT NULL COMMENT 'Function ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `department2function2member`
--

CREATE TABLE `department2function2member` (
                                              `departmentId` int(11) NOT NULL COMMENT 'Department ID',
                                              `functionId` int(11) NOT NULL COMMENT 'Function ID',
                                              `memberId` int(11) NOT NULL COMMENT 'Member ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Departments';

-- --------------------------------------------------------

--
-- Struktura tabulky `function`
--

CREATE TABLE `function` (
                            `id` int(11) NOT NULL COMMENT 'ID',
                            `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                            `type` int(11) NOT NULL COMMENT 'Type',
                            `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions';

-- --------------------------------------------------------

--
-- Struktura tabulky `meeting`
--

CREATE TABLE `meeting` (
                           `id` int(11) NOT NULL COMMENT 'ID',
                           `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'name',
                           `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description',
                           `date` date NOT NULL DEFAULT current_timestamp() COMMENT 'Date',
                           `type` int(11) NOT NULL COMMENT 'Type',
                           `isRegular` tinyint(1) NOT NULL COMMENT 'Is Regular?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Meetings';

-- --------------------------------------------------------

--
-- Struktura tabulky `member`
--

CREATE TABLE `member` (
                          `id` int(11) NOT NULL COMMENT 'ID',
                          `name` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Name',
                          `surname` varchar(512) COLLATE utf8_czech_ci NOT NULL COMMENT 'Surname',
                          `nick` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Nick',
                          `birthYear` year(4) DEFAULT NULL COMMENT 'Yaer of birth',
                          `gender` varchar(1) COLLATE utf8_czech_ci NOT NULL COMMENT 'Gender',
                          `active` tinyint(1) NOT NULL COMMENT 'Active?',
                          `type` int(11) NOT NULL COMMENT 'Member type',
                          `description` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Description',
                          `carId` int(11) DEFAULT NULL COMMENT 'Car ID',
                          `branchId` int(11) DEFAULT NULL COMMENT 'Branch ID',
                          `profilePhoto` varchar(512) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Profile photo file name',
                          `profilePhotoExtension` varchar(25) COLLATE utf8_czech_ci DEFAULT NULL COMMENT 'Profile photo file extension'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Members';

-- --------------------------------------------------------

--
-- Struktura tabulky `member2function`
--

CREATE TABLE `member2function` (
                                   `memberId` int(11) NOT NULL COMMENT 'Member ID',
                                   `functionId` int(11) NOT NULL COMMENT 'Function ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Functions of Members';

-- --------------------------------------------------------

--
-- Struktura tabulky `member2meeting`
--

CREATE TABLE `member2meeting` (
                                  `memberId` int(11) NOT NULL COMMENT 'Member ID',
                                  `meetingId` int(11) NOT NULL COMMENT 'Meeting ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Meetings of Members';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `branch`
--
ALTER TABLE `branch`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `car`
--
ALTER TABLE `car`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `cause`
--
ALTER TABLE `cause`
    ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Cause_MemberId` (`memberId`),
  ADD KEY `K_Cause_DepartmentId` (`departmentId`);

--
-- Klíče pro tabulku `department`
--
ALTER TABLE `department`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `department2function`
--
ALTER TABLE `department2function`
    ADD PRIMARY KEY (`departmentId`,`functionId`) USING BTREE,
  ADD KEY `FK_Department2function_Function_Id` (`functionId`) USING BTREE;

--
-- Klíče pro tabulku `department2function2member`
--
ALTER TABLE `department2function2member`
    ADD PRIMARY KEY (`departmentId`,`functionId`,`memberId`) USING BTREE,
  ADD KEY `FK_Department2function2member2member_Function_Id` (`functionId`),
  ADD KEY `FK_Department2function2member2member_Member_Id` (`memberId`);

--
-- Klíče pro tabulku `function`
--
ALTER TABLE `function`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `meeting`
--
ALTER TABLE `meeting`
    ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `member`
--
ALTER TABLE `member`
    ADD PRIMARY KEY (`id`),
  ADD KEY `K_Member_CarId` (`carId`),
  ADD KEY `K_Member_BranchId` (`branchId`);

--
-- Klíče pro tabulku `member2function`
--
ALTER TABLE `member2function`
    ADD PRIMARY KEY (`memberId`,`functionId`),
  ADD KEY `FK_Function_Id` (`functionId`);

--
-- Klíče pro tabulku `member2meeting`
--
ALTER TABLE `member2meeting`
    ADD PRIMARY KEY (`memberId`,`meetingId`),
  ADD KEY `FK_Member2Meeting_MeetingId` (`meetingId`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `branch`
--
ALTER TABLE `branch`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `car`
--
ALTER TABLE `car`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `cause`
--
ALTER TABLE `cause`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `department`
--
ALTER TABLE `department`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `function`
--
ALTER TABLE `function`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `meeting`
--
ALTER TABLE `meeting`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT pro tabulku `member`
--
ALTER TABLE `member`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `cause`
--
ALTER TABLE `cause`
    ADD CONSTRAINT `FK_Cause_MemberId` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);

--
-- Omezení pro tabulku `department2function2member`
--
ALTER TABLE `department2function2member`
    ADD CONSTRAINT `FK_Department2function2member2member_Department_id` FOREIGN KEY (`departmentId`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `FK_Department2function2member2member_Function_Id` FOREIGN KEY (`functionId`) REFERENCES `function` (`id`),
  ADD CONSTRAINT `FK_Department2function2member2member_Member_Id` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `member2function`
--
ALTER TABLE `member2function`
    ADD CONSTRAINT `FK_Function_Id` FOREIGN KEY (`functionId`) REFERENCES `function` (`id`),
  ADD CONSTRAINT `FK_Member_Id` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);

--
-- Omezení pro tabulku `member2meeting`
--
ALTER TABLE `member2meeting`
    ADD CONSTRAINT `FK_Member2Meeting_MeetingId` FOREIGN KEY (`meetingId`) REFERENCES `meeting` (`id`),
  ADD CONSTRAINT `FK_Member2Meeting_MemberId` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Omezení pro tabulku `cause`
--
ALTER TABLE `cause`
    ADD CONSTRAINT `FK_Cause_MemberId` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);

--
-- Omezení pro tabulku `department2function2member`
--
ALTER TABLE `department2function2member`
    ADD CONSTRAINT `FK_Department2function2member2member_Department_id` FOREIGN KEY (`departmentId`) REFERENCES `department` (`id`),
  ADD CONSTRAINT `FK_Department2function2member2member_Function_Id` FOREIGN KEY (`functionId`) REFERENCES `function` (`id`),
  ADD CONSTRAINT `FK_Department2function2member2member_Member_Id` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `member2function`
--
ALTER TABLE `member2function`
    ADD CONSTRAINT `FK_Function_Id` FOREIGN KEY (`functionId`) REFERENCES `function` (`id`),
  ADD CONSTRAINT `FK_Member_Id` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);

--
-- Omezení pro tabulku `member2meeting`
--
ALTER TABLE `member2meeting`
    ADD CONSTRAINT `FK_Member2Meeting_MeetingId` FOREIGN KEY (`meetingId`) REFERENCES `meeting` (`id`),
  ADD CONSTRAINT `FK_Member2Meeting_MemberId` FOREIGN KEY (`memberId`) REFERENCES `member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
