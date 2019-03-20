CREATE TABLE `spjs_JO`.`parts` (
	`pnum` VARCHAR(2) NOT NULL,
	`pname` VARCHAR(10) NOT NULL,
	`color` VARCHAR(10) NOT NULL,
	`weight` INTEGER(2) NOT NULL,
    `city` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`pnum`)
);


INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P1', 'Nut', 'Red', '12', 'London');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P2', 'Bolt', 'Green', '17', 'Paris');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P3', 'Screw', 'Blue', '17', 'Rome');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P4', 'Screw', 'Red', '14', 'London');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P5', 'Cam', 'Blue', '12', 'Paris');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P6', 'Cog', 'Red', '19', 'London');
INSERT INTO `spjs_JO`.`parts` (`pnum`, `pname`, `color`, `weight`, `city`) VALUES ('P7', 'Gear', 'Yellow', '18', 'Berlin');

CREATE TABLE `spjs_JO`.`suppliers` (
	`snum` VARCHAR(2) NOT NULL,
    `sname` VARCHAR(20) NOT NULL,
    `status` INTEGER(2) NOT NULL,
    `city` VARCHAR(20) NOT NULL,
    PRIMARY KEY(`snum`)
);

INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S1', 'Smith', '20', 'London');
INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S2 ', 'Jones', '10 ', 'Paris');
INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S3', 'Blake', '30', 'Paris');
INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S4', 'Clark', '20', 'London');
INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S5', 'Adams', '30', 'Athens');
INSERT INTO `spjs_JO`.`suppliers` (`snum`, `sname`, `status`, `city`) VALUES ('S6', 'Brown', '15', 'Berlin');


CREATE TABLE `spjs_JO`.`projects` (
  `jnum` varchar(2) NOT NULL,
  `jname` varchar(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  PRIMARY KEY (`jnum`)
);

INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J1', 'Sorter', 'Paris');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J2', 'Punch', 'Rome');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J3', 'Reader', 'Athens');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J4', 'Console', 'Athens');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J5', 'Filler', 'London');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J6', 'Layer', 'Oslo');
INSERT INTO `spjs_JO`.`projects` (`jnum`, `jname`, `city`) VALUES ('J7', 'Tape', 'London');

CREATE TABLE `spjs_JO`.`shipments` (
  `snum` VARCHAR(2) NOT NULL,
  `pnum` VARCHAR(2) NOT NULL,
  `jnum` VARCHAR(2) NOT NULL,
  `qty` INT NOT NULL,
  CONSTRAINT `snum`
    FOREIGN KEY (`snum`)
    REFERENCES `spjs_JO`.`suppliers` (`snum`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `pnum`
    FOREIGN KEY (`pnum`)
    REFERENCES `spjs_JO`.`parts` (`pnum`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `jnum`
    FOREIGN KEY (`pnum`)
    REFERENCES `spjs_JO`.`projects` (`jnum`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S1', 'P1', 'J4', '700');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J1', '400');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J2', '200');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J3', '200');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J4', '500');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J5', '600');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J6', '400');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P3', 'J7', '800');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S2', 'P5', 'J2', '100');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S3', 'P3', 'J1', '200');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S3', 'P4', 'J2', '500');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S4', 'P6', 'J3', '300');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S4', 'P6', 'J7', '300');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S5', 'P2', 'J2', '200');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S5', 'P2', 'J4', '100');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S5', 'P5', 'J5', '500');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S5', 'P5', 'J7', '100');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S1', 'P4', 'J1', '100');
INSERT INTO `spjs_JO`.`shipments` (`snum`, `pnum`, `jnum`, `qty`) VALUES ('S1', 'P6', 'J2', '200');


/*
SELECT <attribute list>
FROM <table list>
[WHERE <condition>
HAVING <group condition>
ORDER BY <attribute list>]
*/



/*
SUBQUERIES(this part is just a normal query we've bene writing, original return table)
// helpful in JOINS to keep tables 'clear'
x IN(subquery)

x NOT IN(subquery)

EXISTS(subquery)

NOT EXISTS(subquery)

x *comparison-op* (subq)

x *comparison-op* ALL (subq)

x *comparison-op* SOME (subq)


*/


/*
SELECT sname, snum
FROM suppliers,
WHERE snum NOT IN (SELECT DISTINCT snum FROM shipments);
*/

-- sub query
SELECT 
select snum
from shipments
where pnum = "P6"

