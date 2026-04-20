-- Consultas SQL para inicializar datos de prueba (Accesos al Sistema)

-- ==========================================
-- 1. DATOS DEL COORDINADOR
-- ==========================================
-- Insertar Persona asociada al Coordinador
INSERT IGNORE INTO `persona` (`pers_doc`, `pers_tipodoc`, `pers_nombres`, `pers_apellidos`, `pers_telefono`) 
VALUES 
('9000000001', 'CC', 'Coordinador', 'SENA APE', '3000000001');

-- Insertar Coordinador
-- URL de acceso: /coordinador/login
-- Credenciales:
-- Correo: coordinador@sena.edu.co
-- Contraseña: coord2026
INSERT IGNORE INTO `coordinador` (`coor_correo`, `coor_password`, `PERSONA_pers_doc`, `coor_vigencia`) 
VALUES 
('coordinador@sena.edu.co', 'coord2026', '9000000001', '2027-12-31');


-- ==========================================
-- 2. DATOS DEL ASESOR
-- ==========================================
-- Insertar Persona asociada al Asesor
INSERT IGNORE INTO `persona` (`pers_doc`, `pers_tipodoc`, `pers_nombres`, `pers_apellidos`, `pers_telefono`) 
VALUES 
('20002000', 'CC', 'Ana Asesor', 'Servicio', '3109876543');

-- Insertar Asesor
-- URL de acceso: /asesor/login
-- Credenciales:
-- Documento: 20002000
-- Contraseña: 123456
<<<<<<< HEAD
INSERT IGNORE INTO `asesor` (`ase_correo`, `ase_password`, `ase_nrocontrato`, `ase_tipo_asesor`, `ase_vigencia`, `PERSONA_pers_doc`) 
VALUES 
('asesor@sena.edu.co', '123456', 'CONT-2026', 'General', '2027-12-31', '20002000');
=======
INSERT IGNORE INTO `asesor` (`ase_correo`, `ase_password`, `ase_nrocontrato`, `ase_tipo_asesor`, `ase_vigencia`, `PERSONA_pers_doc`, `ase_foto`) 
VALUES 
('asesor@sena.edu.co', '123456', 'CONT-2026', 'General', '2027-12-31', '20002000', 'images/foto de perfil.jpg');
>>>>>>> cd1d4e4 (Enhance Advisor Management & Turn Flow: Profile photos, premium modals, FIFO optimization, and turn generation hardening)
