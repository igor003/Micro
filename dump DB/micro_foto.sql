CREATE TABLE micro.foto
(
    id int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT,
    configuration_id int(11) NOT NULL,
    foto1 varchar(80) NOT NULL,
    foto2 varchar(80) NOT NULL,
    foto3 varchar(80) NOT NULL,
    maked_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp
);
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (5, 1, 'Maserati M 157/49830939/AA2/2018-09-23 19:51/0_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 19:51/1_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 19:51/2_2018-09-23.png', '2018-09-01 00:00:00', '2018-09-23 19:51:32', '2018-09-23 19:51:32');
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (6, 1, 'Maserati M 157/49830939/AA2/2018-09-23 19:56/0_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 19:56/1_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 19:56/2_2018-09-23.png', '2018-09-01 19:56:00', '2018-09-23 19:56:06', '2018-09-23 19:56:06');
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (7, 1, 'Maserati M 157/49830939/AA2/2018-09-23 20:24/0_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:24/1_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:24/2_2018-09-23.png', '2018-09-01 09:13:00', '2018-09-23 20:24:05', '2018-09-23 20:24:05');
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (8, 1, 'Maserati M 157/49830939/AA2/2018-09-23 20:27/0_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:27/1_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:27/2_2018-09-23.png', '2018-09-23 20:27:00', '2018-09-23 20:27:18', '2018-09-23 20:27:18');
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (9, 1, 'Maserati M 157/49830939/AA2/2018-09-23 20:31/0_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:31/1_2018-09-23.png', 'Maserati M 157/49830939/AA2/2018-09-23 20:31/2_2018-09-23.png', '2018-09-12 09:15:00', '2018-09-23 20:31:43', '2018-09-23 20:31:43');
INSERT INTO micro.foto (id, configuration_id, foto1, foto2, foto3, maked_at, created_at, updated_at) VALUES (10, 2, 'Maserati M 157/49830939/AA4/2018-09-24 19:31/0_2018-09-24.png', 'Maserati M 157/49830939/AA4/2018-09-24 19:31/1_2018-09-24.png', 'Maserati M 157/49830939/AA4/2018-09-24 19:31/2_2018-09-24.png', '2018-09-24 19:31:00', '2018-09-24 19:31:57', '2018-09-24 19:31:57');