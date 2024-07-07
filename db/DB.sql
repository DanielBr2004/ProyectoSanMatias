DROP DATABASE IF EXISTS GranjaSanMatias;
CREATE DATABASE GranjaSanMatias;
USE GranjaSanMatias;

-- ---------------------- Tabla de Personas ------------------------
CREATE TABLE personas 
(
	idpersona 		INT AUTO_INCREMENT PRIMARY KEY,
    apepaterno 		VARCHAR(60) NOT NULL,
    apematerno 		VARCHAR(60) NOT NULL,
    nombres 		VARCHAR(40) NOT NULL,
    nrodocumento 	CHAR(8) 	NOT NULL,
    create_at 		DATETIME 	NOT NULL DEFAULT NOW(),
    inactive_at		DATETIME 	NULL,
    CONSTRAINT uk_nrodocumento_per UNIQUE (nrodocumento)
) ENGINE = INNODB;
Select * from personas;

-- ---------------------- Tabla de Roles ------------------------
CREATE TABLE roles
(
	idrol INT AUTO_INCREMENT PRIMARY KEY,
    roles VARCHAR(50) NOT NULL
) ENGINE = INNODB; 
	INSERT INTO roles(roles)VALUES
		('Gerente General'),
        ('Jefe Encargado');
        SELECT * FROM ROLES;
-- ---------------------- Tabla de Colaboradores ------------------------
CREATE TABLE colaboradores 
(
	idcolaborador 	INT AUTO_INCREMENT PRIMARY KEY,
    idpersona 		INT 			NOT NULL,
    idrol			INT 			NOT NULL,
    nomusuario 		VARCHAR(150) 	NOT NULL,
    passusuario		VARCHAR(60) 	NOT NULL,
    create_at		DATETIME 		NOT NULL DEFAULT NOW(),
    inactive_at		DATETIME 		NULL,
    CONSTRAINT fk_persona_col FOREIGN KEY (idpersona) REFERENCES personas (idpersona),
    CONSTRAINT fk_rol_col	FOREIGN KEY (idrol) REFERENCES roles (idrol)
) ENGINE = INNODB; 
SELECT * FROM colaboradores;
-- ---------------------- Tabla de Productos ------------------------
CREATE TABLE productos
(
	idproducto 		INT AUTO_INCREMENT PRIMARY KEY,
    Producto 		varchar(100) 	NOT NULL,
    descripcion 	varchar(500) 	NOT NULL
) ENGINE = INNODB;
select * from productos;
-- ---------------------- Tabla de Kardex ------------------------
CREATE TABLE kardex 
(
	idalmacen 		INT AUTO_INCREMENT PRIMARY KEY,
    idcolaborador 	INT 		NOT NULL,
    idproducto 		INT 		NOT NULL,
    tipomovimiento 	CHAR(1) 	NOT NULL,
    stockactual 	DECIMAL(6,2) 	NOT NULL,
    cantidad 		SMALLINT 	NOT NULL,
    created_at 		DATETIME 	NOT NULL DEFAULT NOW(),
    CONSTRAINT fk_colaborador_kar FOREIGN KEY (idcolaborador) REFERENCES colaboradores (idcolaborador),
    CONSTRAINT fk_producto_kar FOREIGN KEY (idproducto) REFERENCES productos (idproducto)
) ENGINE = INNODB;
select * from kardex


