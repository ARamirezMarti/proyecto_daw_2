CREATE DATABASE gec CHARACTER SET utf8 COLLATE utf8_general_ci;

use gec;

/* Tablas */

CREATE TABLE Departamento ( 
    Dep_ID INT NOT NULL,
    Dep_Nombre VARCHAR(100) NOT NULL,
    Dep_Telefono INT(10) NULL,
    PRIMARY KEY (Dep_ID)
 ) ENGINE = InnoDB;


CREATE TABLE Empleado (
    Empleado_ID int NOT NULL UNIQUE,
    Dep_ID int ,
    Emp_Nombre VARCHAR(50) NOT NULL,
    Emp_Apellido VARCHAR(75) NOT NULL,
    Emp_Password VARCHAR(255) NOT NULL,
    Emp_Telf int(25) ,
    Is_Emp_Respon int NOT NULL,
    PRIMARY KEY (Empleado_ID),
    FOREIGN KEY (Dep_ID) REFERENCES Departamento(Dep_ID)
    ON DELETE CASCADE
)ENGINE = InnoDB;



CREATE TABLE Pedidos (
    Pedido_ID VARCHAR(50) NOT NULL ,
    Empleado_ID int,
    Ped_Estado INT(1) NOT NULL,
    Ped_Descripcion TEXT NOT NULL,
    Ped_Fecha DATE NOT NULL,
    Ped_Precio_total DECIMAL(5,2) NOT NULL,

    PRIMARY KEY(Pedido_ID),
    FOREIGN KEY(Empleado_ID) REFERENCES Empleado(Empleado_ID) ON DELETE CASCADE
)ENGINE = InnoDB;

CREATE TABLE Mensaje (
    Mensaje_ID INT NOT NULL  AUTO_INCREMENT,
    Pedido_ID VARCHAR(50) NOT NULL,
    Contenido TEXT NOT NULL,
    Visto int(1) NOT NULL,
    PRIMARY KEY(Mensaje_ID),
    FOREIGN KEY(Pedido_ID) REFERENCES Pedidos(Pedido_ID)ON DELETE CASCADE


)ENGINE = InnoDB;

CREATE TABLE Categoria (
    Cat_ID INT NOT NULL AUTO_INCREMENT,
    Cat_Nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY(Cat_ID)
)ENGINE = InnoDB;

CREATE TABLE Prov_Direccion (
    Direccion_ID INT NOT NULL AUTO_INCREMENT,
    Dir_Calle VARCHAR(50) NOT NULL,
    Dir_Pais VARCHAR(20) NOT NULL,
    Dir_Cod_Postal INT(6) NOT NULL,
    Dir_Provincia VARCHAR(50) NOT NULL,
    Dir_Ciudad VARCHAR(50) NOT NULL,
    PRIMARY KEY(Direccion_ID)

)ENGINE = InnoDB;

CREATE TABLE Proveedor (
    Prov_ID INT NOT NULL AUTO_INCREMENT,
    Direccion_ID INT,
    Prov_Nombre VARCHAR(50) NOT NULL,
    Prov_CIF VARCHAR(25) NOT NULL,
    Prov_Telf INT NOT NULL,
    Prov_Web VARCHAR(100),
    Enabled INT NOT NULL DEFAULT 0,

    PRIMARY KEY(Prov_ID),
    FOREIGN KEY(Direccion_ID) REFERENCES Prov_Direccion(Direccion_ID) ON DELETE CASCADE  
)ENGINE = InnoDB;

CREATE TABLE Productos(
    Prod_ID INT NOT NULL AUTO_INCREMENT,
    Prov_ID INT,
    Cat_ID INT,
    Prod_Nombre VARCHAR(100) NOT NULL,
    Prod_Descripcion TEXT NOT NULL,
    Prod_Precio DECIMAL(5,2) NOT NULL,
    Enabled INT NOT NULL DEFAULT 0,
    PRIMARY KEY(Prod_ID),
    FOREIGN KEY(Prov_ID) REFERENCES Proveedor(Prov_ID),
    FOREIGN KEY(Cat_ID) REFERENCES Categoria(Cat_ID)
)ENGINE=InnoDB;

CREATE TABLE Contiene(
    Pedido_ID VARCHAR(50),
    Prod_ID INT,
    Ped_Cantidad INT NOT NULL,
    FOREIGN KEY(Pedido_ID) REFERENCES Pedidos(Pedido_ID) ON DELETE CASCADE,
    FOREIGN KEY(Prod_ID) REFERENCES Productos(Prod_ID) ON DELETE CASCADE
)ENGINE=InnoDB;


ALTER TABLE Departamento CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Empleado CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Pedidos CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Mensaje CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Prov_Direccion CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Proveedor CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Productos CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE Contiene CHARACTER SET utf8 COLLATE utf8_general_ci;

/* Añadimos proveedores */
INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) 
VALUES (NULL, 'Primer de Maig, 5 Pol. Ind, Carrer d\'Armenteres', 'España', ' 08980 ', 'Barcelona', 'Sant feliu de llobregat');
INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_CIF`, `Prov_Nombre`, `Prov_Telf`, `Prov_Web`) VALUES (NULL, '1', '34443311Y', 'CONSUMO suministros ', '689290212', NULL);

INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) 
VALUES (NULL, 'Carrer de Muntaner, 63', 'España', ' 08011 ', 'Barcelona', 'Barcelona');
INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_CIF`, `Prov_Nombre`, `Prov_Telf`, `Prov_Web`) VALUES (NULL, '2', '55555533Y', 'Emilio Segarra S. A.  ', '941923321', 'https://papeleriasegarra.com/');

INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) 
VALUES (NULL, ' Carrer d\'Aribau, 60', 'España', ' 08011 ', 'Barcelona', 'Barcelona');
INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_CIF`, `Prov_Nombre`, `Prov_Telf`, `Prov_Web`) VALUES (NULL, '3', '111422253Z', 'Todo Oficina', '959982231', 'https://www.todooficina.net/');

INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) 
VALUES (NULL, ' Carrer de Rabassa, 50-52, planta 4', 'España', ' 08024 ', 'Barcelona', 'Barcelona');
INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_CIF`, `Prov_Nombre`, `Prov_Telf`, `Prov_Web`) VALUES (NULL, '4', '88776690R', 'DESKIDEA', '982321231', 'https://www.deskidea.com/');


INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) 
VALUES (NULL, 'Av. Onze de Setembre, 269', 'España', ' 08820 ', 'El prat de llobregat', 'Barcelona');
INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_CIF`, `Prov_Nombre`, `Prov_Telf`, `Prov_Web`) VALUES (NULL, '5', '67985422U', 'Ofiexperts', '965543210', 'https://www.ofiexperts.es/');

/* Añadir Categorias */

INSERT INTO `Categoria` (`Cat_ID`, `Cat_Nombre`) VALUES (NULL, 'Muebles de oficina');
INSERT INTO `Categoria` (`Cat_ID`, `Cat_Nombre`) VALUES (NULL, 'Informatica');
INSERT INTO `Categoria` (`Cat_ID`, `Cat_Nombre`) VALUES (NULL, 'Consumibles');
INSERT INTO `Categoria` (`Cat_ID`, `Cat_Nombre`) VALUES (NULL, 'Material de oficina');


/* Añadir Productos */

INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '4', 'Archivador palanca Exacompta', 'El archivador de palanca Prem\'Touch está equipado de una mecánica más fuerte, es más resistente, más ergonómico gracias a su nuevo pulsador, tiene refuerzos en los cantos, etiqueta soldada en el lomo, rado y ollao.', '4.20');INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '4', 'Archivador palanca EXACOMPTA', 'El archivador de palanca Prem\'Touch está equipado de una mecánica más fuerte, es más resistente, más ergonómico gracias a su nuevo pulsador, tiene refuerzos en los cantos, etiqueta soldada en el lomo, rado y ollao.', '4.20');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Caja de 5 paquetes 500 hojas de papel Premium', 'Excelente calidad, ideal para presentaciones e impresiones profesionales y apto para todos los tipos de impresoras', '89.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Paquete 500 hojas de papel Premium', 'Excelente calidad, ideal para presentaciones e impresiones profesionales y apto para todos los tipos de impresoras', '19.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Paquete 500 hojas de papel Lyreco Premium - A3', 'Excelente calidad, ideal para presentaciones e impresiones profesionales y apto para todos los tipos de impresoras', '4.20');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Caja de 5 paquetes 500 papel', 'Excelente calidad, ideal para presentaciones e impresiones profesionales y apto para todos los tipos de impresoras', '119.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Carpeta Esselte - folio - 4 anillas', 'Carpeta de 4 anillas, PVC, formato folio, color negro. Lomo 60 mm.Material plástico forrado de una sola pieza.', '9.50');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Tijeras para ambidiestros- 21 cm ', 'Hojas de acero templado inoxidable.Con ojos de plástico ergonómicos de gran tamaño para una mayor comodidad de manejo.', '24.50');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Cúter de seguridad - 18 mm - azul ', 'Cúter ergonómico con cuerpo de polipropileno para una sujeción cómoda en mano.', '12.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Taladro de sobremesa Petrus 52', 'Taladro de 2 agujeros, color azul.Con punzones más afilados para perforar con más facilidad.', '5.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '1', '3', 'Taladro de sobremesa - 4 agujeros - negro', 'Completamente de metal, para una mayor durabilidad.Base metálica con compartimento extraíble de plástico para confeti.', '34.90');





INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Silla piqueras y crespo Albacete confidente', 'Sillón confidente ergonómico con asiento y respaldo tapizados en color, brazos cromados regulables en altura y patín de tubo oval cromado.', '325.85');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Silla piqueras y crespo Bogarra ', 'Silla de oficina con respaldo y asiento ergonómico acolchado, para una mayor comodidad del usuario. ', '225.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Silla con mecanismo de contacto', 'Silla de oficina de contacto permanente, fabricada con base de poliuretano y tapizada en tela ignífuga.', '120');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Cajón archivador Bisley', 'Archivador de 2 cajones que permite clasificar carpetas tamaño folio. Guías telescópicas resistentes, su calidad permite una apertura y cierre suave.', '182.00');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Torre de almacenamiento Cep', 'Material ligero y resistente a los golpes', '58.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '2', '1', 'Buck con ruedas Ofitres', 'Buck móvil con tres cajones. Estructura de melamina de 19 mm y 10 mm de espesor.', '150.90');


INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Ratón Kensington Mouse','Diseñado para ambidiestros', '9.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Teclado Kensington Value ','Diseño moderno que permite ahorrar espacio en el escritorio', '29.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Ratón óptico inalámbrico Kensington ProFit','Tecnología inalámbrica sin desorden', '19.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Ratón ergonómico Trust- VERTO', 'Cómodo reposa pulgares y revestimiento de goma para un agarre perfecto','29.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Memoria USB Verbatim Pinstripe - USB 2.0 - 32 Gb', 'Mecanismo retráctil y se puede colgar de una anilla o llavero','59.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Memoria USB Verbatim Pinstripe - USB 2.0 - 16 Gb', 'Mecanismo retráctil y se puede colgar de una anilla o llavero','29.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Memoria USB Verbatim Pinstripe - USB 2.0 - 8 Gb', 'Mecanismo retráctil y se puede colgar de una anilla o llavero','19.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Auriculares para pc Trust Mauro', 'Elevada calidad de audio con un diseño cómodo y auriculares blandos','14.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Auricular Sennheiser Pc chat 3 ', 'Auricular especialmente pensado para conectarlo a tu ordenador y chatear. Fácil instalación y uso con su sistema Plug and Play','24.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Auriculares Kensington - USC-C  ', 'Los auriculares Hi-Fi USB-C con micrófono, que se han diseñado teniendo en cuenta la claridad del sonido y la compatibilidad del dispositivo, es una combinación económica y de alta calidad de auriculares y micrófono perfecta para el aprendizaje a distancia.','8.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Alfombrilla antibacterias para ratón Fellowes', 'Su superficie de poliéster permite una mayor tracción del ratón.Tratamiento especial Microban que protege contra los gérmenes.','34.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Reposamuñecas mini Fellowes', 'Fabricado en gel flexible transparente de color azul translúcido.Base antideslizante adaptable a cualquier superficie.','18.90');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '3', '2', 'Alfombrilla Antifatiga sit&stand', 'Alivia la presión en las muñecas.Mejora el deslizamiento y el control del ratón','21.90');



INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Bolígrafo Bic Cristal Original - azul', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo.','0.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Bolígrafo Bic Cristal Original - rojo', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo.','0.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Bolígrafo Bic Cristal Original - negro', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo.','0.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Pack de 90 + 10 bolígrafos Bic Cristal - azul', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo y esta caja contiene 90 unidades con tinta azul.','89.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Pack de 90 + 10 bolígrafos Bic Cristal - rojo', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo y esta caja contiene 90 unidades con tinta rojo.','89.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Pack de 90 + 10 bolígrafos Bic Cristal - negro', 'El clásico Bic Cristal Original con cuerpo transparente es el bolígrafo más vendido del mundo y esta caja contiene 90 unidades con tinta negro.','89.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Marcador fluorescente - amarillo', 'Marcador amarillo fluorescente con tinta base alcohol.','2.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Marcador fluorescente - naranja', 'Marcador amarillo fluorescente con tinta base alcohol.','2.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Marcador fluorescente - azul', 'Marcador amarillo fluorescente con tinta base alcohol.','2.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Marcador fluorescente - purpura', 'Marcador amarillo fluorescente con tinta base alcohol.','2.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Estuche de 8 marcadores fluorescentes Stabilo', 'Estuche de 8 marcadores fluorescente con tinta base agua.','28.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Estuche de 4 marcadores fluorescentes Stabilo', 'Estuche de 8 marcadores fluorescente con tinta base agua.','13.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Grapadora de sobremesa Rapid F16', 'Grapadora fabricada en plástico ABS y goma.Base antideslizante.','19.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Grapadora de sobremesa Petrus 226 ', 'Grapadora fabricada en metal.Apertura frontal.Con cargador de doble guía.','49.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Caja de 1000 grapas Rapid 23/10', 'Caja de 1000 grapas Rapid 23/10 Standard.','9.99');
INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`) VALUES (NULL, '4', '4', 'Caja de 5000 grapas', 'Caja de 5000 grapas 26/6.','9.99');


INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('001', 'Producción', '676898901');
INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('002', 'Calidad', '676898902');
INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('003', 'IT', '676898903');
INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('004', 'Mantenimiento', '676898904');
INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('005', 'RRHH', '676898905');
INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('006', 'Compras', '676898906');

/* 
   Password Admin: admin
   Password Carla : clopez
   Password Miguel Angel : magomez 
 */
INSERT INTO `Empleado` (`Empleado_ID`, `Dep_ID`, `Emp_Nombre`, `Emp_Apellido`, `Emp_Password`, `Emp_Telf`, `Is_Emp_Respon`) VALUES ('4000', '6', 'Admin', 'Admin', '$2y$12$34mTgMoS8QitZ1zvdAQqDuiHMaJb1UvaW2VoBEYLUJXk5gUnLJZbW', NULL, '1');
INSERT INTO `Empleado` (`Empleado_ID`, `Dep_ID`, `Emp_Nombre`, `Emp_Apellido`, `Emp_Password`, `Emp_Telf`, `Is_Emp_Respon`) VALUES ('4002', '6', 'Carla', 'Lopez Diaz', '$2a$12$ACtNyY.vWOTTE/gjsdUQOutGTYw7qRbOogemSkDdUEiZLdvBPUl22', NULL, '1');
INSERT INTO `Empleado` (`Empleado_ID`, `Dep_ID`, `Emp_Nombre`, `Emp_Apellido`, `Emp_Password`, `Emp_Telf`, `Is_Emp_Respon`) VALUES ('4001', '1', 'Miguel Angel', 'Gomez Cortez', '$2a$12$Evj711dVVLp1Sx4DeRhCGOLgDRexjgxcSZvFaBwKlKTZoGEPsbIZq', NULL, '0');

