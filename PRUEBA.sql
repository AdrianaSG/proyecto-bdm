create database bprueba;
use bprueba;

CREATE TABLE multimedia (
    ID_Multimedia INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('imagen', 'video') NOT NULL,  -- tipo de archivo
    contenido LONGBLOB NOT NULL             -- archivo binario (imagen o video)
);

CREATE TABLE usuario (
    ID_Usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE,
    genero VARCHAR(50),
    pais_nacimiento VARCHAR(50),
    nacionalidad VARCHAR(50),
    correo_electronico VARCHAR(100) UNIQUE,
    contrasena VARCHAR(255),
    estatus BIT DEFAULT 1,   -- 1 = activo, 0 = dado de baja
    rol BIT DEFAULT 1,        -- 1 = usuario, 0 = admin 
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    foto INT NULL,
    FOREIGN KEY (foto) REFERENCES multimedia(ID_Multimedia) ON DELETE CASCADE
);

SELECT * FROM usuario;
SELECT * FROM multimedia;
TRUNCATE TABLE usuario;
TRUNCATE TABLE multimedia;

SET FOREIGN_KEY_CHECKS = 0;
SET FOREIGN_KEY_CHECKS = 1;

DELIMITER //
CREATE TRIGGER trg_chk_edad_usuario_insert
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
    IF TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE()) <= 12 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario debe tener más de 12 años para registrarse.';
    END IF;
END;
//
DELIMITER ;

-- 🔹 TRIGGER para validar edad al actualizar (opcional pero recomendable)
DELIMITER //
CREATE TRIGGER trg_chk_edad_usuario_update
BEFORE UPDATE ON usuario
FOR EACH ROW
BEGIN
    IF TIMESTAMPDIFF(YEAR, NEW.fecha_nacimiento, CURDATE()) <= 12 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario no puede tener menos de 13 años.';
    END IF;
END;
//
DELIMITER 

-- 🔹 Procedure de Registro
-- 🔹 FALTA VALIDAR MAYOR 99,VALIDAR SI SE SUBE FOTO, VALIDAR SI TIENE ENE, QUE SE GUARDE EL GENERO EN TEXTO
DELIMITER $$

CREATE PROCEDURE sp_registrar_usuario(
    IN p_nombre VARCHAR(50),
    IN p_fecha_nacimiento DATE,
    IN p_genero VARCHAR(50),
    IN p_pais_nacimiento VARCHAR(50),
    IN p_nacionalidad VARCHAR(50),
    IN p_correo_electronico VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_tipo_multimedia ENUM('imagen','video'),
    IN p_contenido LONGBLOB
)
BEGIN
    DECLARE v_id_multimedia INT DEFAULT NULL;

    -- Si se envió un archivo (no nulo), insertamos en multimedia
    IF p_contenido IS NOT NULL THEN
        INSERT INTO multimedia (tipo, contenido)
        VALUES (p_tipo_multimedia, p_contenido);
        SET v_id_multimedia = LAST_INSERT_ID();
    END IF;

    -- Insertar en usuario
    INSERT INTO usuario (
        nombre, fecha_nacimiento, genero,
        pais_nacimiento, nacionalidad,
        correo_electronico, contrasena, foto
    )
    VALUES (
        p_nombre, p_fecha_nacimiento, p_genero,
        p_pais_nacimiento, p_nacionalidad,
        p_correo_electronico, p_contrasena, v_id_multimedia
    );
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_login_usuario(
    IN p_correo_electronico VARCHAR(50),
    IN p_contrasena VARCHAR(255)
)
BEGIN
    SELECT 
        u.ID_Usuario,
        u.nombre,
        u.pais_nacimiento,
        u.nacionalidad,
        u.rol,
        u.estatus,
        m.ID_Multimedia,
        m.tipo
    FROM usuario u
    LEFT JOIN multimedia m ON u.foto = m.ID_Multimedia
    WHERE u.correo_electronico = p_correo_electronico
      AND u.contrasena = p_contrasena
      AND u.estatus = 1;
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_mostrar_imagen(IN p_id INT)
BEGIN
    SELECT contenido, tipo
    FROM multimedia
    WHERE ID_Multimedia = p_id;
END $$

DELIMITER ;
