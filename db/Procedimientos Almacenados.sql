USE granjasanmatias
-- ------------------------------------------------------------- LOGIN ------------------------------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_colaboradores_login(IN _nomusuario VARCHAR(150))
BEGIN 
	SELECT 
		COL.idcolaborador,
        PER.apepaterno, 
        PER.apematerno,
        PER.nombres,
        ROL.roles,
        COL.nomusuario, COL.passusuario
		FROM colaboradores COL 
        INNER JOIN personas PER ON PER.idpersona = COL.idpersona
        INNER JOIN roles ROL ON ROL.idrol = COL.idrol
        WHERE COL.nomusuario = _nomusuario AND COL.inactive_at IS NULL; 
END $$
CALL spu_colaboradores_login('DanielBr');
-- ------------------------------------------------------- Procedimiento Registrar Persona -------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_personas_registrar
(
	IN _apepaterno		VARCHAR(60),
    IN _apematerno		VARCHAR(60),
    IN _nombres			VARCHAR(40),
    IN _nrodocumento	CHAR(8)
) 
BEGIN
	INSERT INTO personas 
		(apepaterno, apematerno, nombres, nrodocumento) VALUES 
        (_apepaterno, _apematerno, _nombres, _nrodocumento);
	SELECT @@last_insert_id 'idpersona';
END $$
CALL spu_personas_registrar ('Buleje','Rojas','Daniel',123456788);

-- ----------------------------------------- Procedimiento Registrar Colaborador -------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_colaboradores_registrar
(
	IN _idpersona 		INT,
    IN _idrol 			INT,
    IN _nomusuario 		VARCHAR(150),
    IN _passusuario		VARCHAR(60)
)
BEGIN 
	INSERT INTO colaboradores 
		(idpersona, idrol, nomusuario, passusuario) VALUES
        (_idpersona, _idrol, _nomusuario, _passusuario);
	SELECT @@last_insert_id 'idcolaborador';
END $$
CALL spu_colaboradores_registrar(1,2,'DanielBr','');
UPDATE colaboradores SET passusuario = '$2y$10$86IWpKbDSQDGRJjoIt2EYuSZtesF2ShaFnKNzeZWABJnib5wCADKK' WHERE idcolaborador = 1;
 -- ------------------------------------------- Buscar Colaborador por su DNI ----------------------------------------------------- 
DELIMITER $$
CREATE PROCEDURE spu_colaborador_buscar_dni(IN _nrodocumento CHAR(8))
BEGIN
	SELECT 
		PER.idpersona,
        COL.idcolaborador,
        PER.apepaterno, 
        PER.apematerno,
        PER.nombres
		FROM personas PER 
        LEFT JOIN colaboradores COL
        ON COL.idpersona = PER.idpersona 
        WHERE nrodocumento = _nrodocumento;
END $$
CALL spu_colaborador_buscar_dni(12345678);
 -- ------------------------------------------- Buscar Persona por su ROL ----------------------------------------------------- 
DELIMITER $$
CREATE PROCEDURE spu_persona_buscar_por_rol(IN _idrol INT)
BEGIN
    SELECT 
        P.idpersona,
        C.idcolaborador,
        R.roles,
        P.apepaterno, 
        P.apematerno,
        P.nombres
    FROM personas P 
    LEFT JOIN colaboradores C ON C.idpersona = P.idpersona
    LEFT JOIN roles R ON C.idrol = R.idrol
    WHERE C.idrol = _idrol;
END $$
CALL spu_persona_buscar_por_rol(1);
-- ------------------------------------------ Procedimiento de Registrar Productos --------------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_productos_registrar 
(
    IN _Producto 	VARCHAR(100),
    IN _descripcion 	VARCHAR(500)
)
BEGIN 
    INSERT INTO productos
		(Producto, descripcion) VALUES 
        (_Producto, _descripcion);
	SELECT @@last_insert_id 'idproducto';
END $$
CALL spu_productos_registrar('Soya','Torta de soya presentacion de 50 kg');

-- ------------------------------------------ Procedimiento de Validaciones para el Kardex --------------------------------------------------
DELIMITER $$
CREATE PROCEDURE spu_kardex_registrar
(
    IN _idcolaborador INT,
    IN _idproducto INT,
    IN _tipomovimiento CHAR(1),
    IN _cantidad SMALLINT
)
BEGIN
	-- Stock Actual declarada por defecto en 0
    DECLARE _stockactual INT DEFAULT 0;

    -- Se obtendrá el stock actual dependiendo que producto se seleccione 
    SELECT stockactual INTO _stockactual FROM kardex WHERE idproducto = _idproducto ORDER BY created_at DESC LIMIT 1;

    -- Se realiza una condicion dependiendo del tipo movimiento E(entrada) S(salida) 
    IF _tipomovimiento = 'E' THEN
        SET _stockactual = _stockactual + _cantidad;
    ELSEIF _tipomovimiento = 'S' THEN
        SET _stockactual = _stockactual - _cantidad;
    END IF;

    -- Registramos el kardex 
    INSERT INTO kardex (idcolaborador, idproducto, tipomovimiento, stockactual, cantidad, created_at)
    VALUES (_idcolaborador, _idproducto, _tipomovimiento, _stockactual, _cantidad, NOW());
END $$
CALL spu_kardex_registrar(1,1,'E',100);
-- ----------------------------------------- Procedimiento para Reporte PDF -------------------------------------------------------- 
DELIMITER $$
CREATE PROCEDURE spu_producto_pdf(IN _idproducto INT)
BEGIN 
    SELECT 
        KAR.idalmacen,
        PRO.producto,
        COL.nomusuario,
        KAR.tipomovimiento,
        KAR.stockactual,
        KAR.cantidad,
        KAR.created_at 
    FROM 
        kardex KAR
        LEFT JOIN productos PRO ON PRO.idproducto = KAR.idproducto
        LEFT JOIN colaboradores COL ON COL.idcolaborador = KAR.idcolaborador
    WHERE 
        PRO.idproducto = _idproducto; 
END $$

CALL spu_producto_pdf(1)