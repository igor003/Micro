CREATE TABLE micro.part_configuration
(
    id int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    part_id int(11) NOT NULL,
    components varchar(20) NOT NULL,
    connecting_element varchar(30) NOT NULL,
    sez_components varchar(30) NOT NULL,
    nr_strand varchar(10),
    height varchar(10) NOT NULL,
    width varchar(10) NOT NULL
);
INSERT INTO micro.part_configuration (id, part_id, components, connecting_element, sez_components, nr_strand, height, width) VALUES (1, 6, 'AA2', 'W0827', '0,35+0,35+1', '44', '11.2', '22.3');
INSERT INTO micro.part_configuration (id, part_id, components, connecting_element, sez_components, nr_strand, height, width) VALUES (2, 6, 'AA4', 'W0714', '0,35+0,35+0.35+0,35+0,35+0,35', '44', '2,07', '2,95');
INSERT INTO micro.part_configuration (id, part_id, components, connecting_element, sez_components, nr_strand, height, width) VALUES (3, 14, 'AA4', 'W0827', '0,35+0,35+0.35+1+0,35+1', '49', '2,17', '2,22');