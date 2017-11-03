/*
	TABLAS CREADAS PARA EL EQUIPO DE NOMINA EN AUTOGESTION 2
*/
CREATE TABLE TITULOS_EQUI_NOMINA(
    COD_TITULO VARCHAR2(5 BYTE),
    NOM_TITULO VARCHAR2(100 BYTE),
    ESTADO_TITULO VARCHAR2(1 BYTE),
    CONSTRAINT TITULOS_EQUI_NOMINA_PK PRIMARY KEY (COD_TITULO)
 );
 
INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('1', 'Jefe de nómina', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('2', 'Profesionales de nómina', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('3', 'Analistas de nómina', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('4', 'Estudiantes', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('5', '¿Cuál es el objetivo de la Jefatura de Nómina?', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('6', '¿Cuáles son los retos para este año?', 'A');

INSERT INTO TITULOS_EQUI_NOMINA (COD_TITULO, NOM_TITULO, ESTADO_TITULO)
VALUES ('7', '¿Por qué es tan importante la Jefatura de Nómina en nuestra compañía?', 'A');
----------------------------------------------------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
CREATE TABLE TITULOS_DETALLE(
    COD_DETALLE VARCHAR2(5 BYTE),
    COD_TITULO VARCHAR2(5 BYTE),
    DECRIPCION VARCHAR2(4000 BYTE),
    ESTADO_DETALLE VARCHAR2(1 BYTE),
    CONSTRAINT TITULOS_DETALLE_PK 
        PRIMARY KEY (COD_DETALLE),
    CONSTRAINT FK_COD_TITULO
        FOREIGN KEY (COD_TITULO)
        REFERENCES TITULOS_EQUI_NOMINA(COD_TITULO)    
);

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('1', '1', 'Leonardo Walles Valencia', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('2', '2', 'Marisol Ducuara Aragon', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('3', '2', 'Amparo Cerquera Caldas', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('4', '2', 'Jose William Leiton Hernandez', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('5', '2', 'Hector Frandey Lopez Castillo', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('6', '3', 'Diana Cristina Gonzalez Hernandez', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('7', '3', 'Laura Andrea Correa Cardona', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('8', '3', 'Davindson Andres Fontalvo Romero', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('9', '4', 'Yeny Mayoly Vargas Rodriguez', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('10', '4', 'Maria Paula Avila Perez', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('11', '5', 'Garantizar que en el proceso de liquidación de nómina se cumplan las normas legales de tipo laboral y las fechas de pago acordadas para los empleados y terceros. Además, asegurar que la información requerida por las entidades (internas y externas) de control, sea veraz, esté debidamente soportada y sea entregada de manera oportuna. Por último, y no menos importante, queremos generar servicios de autogestión para dar respuesta a los empleados en los temas relacionados con la nómina.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('12', '6', 'La revisión de la estructura de los procesos críticos de Nómina e identificar cuáles son susceptibles de mejora y sistematización; así, podremos crear marcadores de gestión, que nos permitan continuar garantizando la oportunidad, confiabilidad y calidad en los servicios que se han venido prestando al Grupo Telefónica. Nuestro compromiso es asegurar la información y los recursos necesarios que nos permitan superar las expectativas de nuestros clientes internos y externos.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('13', '7', 'La Jefatura de Nómina hace parte de la Gerencia de Servicios Económicos del Centro de Servicios Compartidos. Es un área de apoyo de la compañía por lo tanto se enfocan en brindar excelentes niveles de servicio, como también en aportar de forma ágil en todos los procesos que requieren de nuestro apoyo, como:', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('14', '7', 'Contratación de colaboradores directos, jóvenes profesionales, aprendices SENA y practicantes universitarios.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('15', '7', 'Aplicación de modificaciones contractuales.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('16', '7', 'Tramite y liquidación de las novedades de pago y/o descuentos propios o terceros de los colaboradores.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('17', '7', 'Liquidación de vacaciones.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('18', '7', 'Pagos asociados a la liquidación de comisiones, horas extras y recargos.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('19', '7', 'Administración de la seguridad social.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('20', '7', 'Gestión de pago nómina de terceros (libranzas) y temporales.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('21', '7', 'Gestión del plan de acciones de los empleados.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('22', '7', 'Asesoría a empleados sobre sus beneficios tributarios, ahorros voluntarios, devengos y descuentos de nómina.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('23', '7', 'Autorización para retiro de Cesantías.', 'A');

INSERT INTO TITULOS_DETALLE (COD_DETALLE, COD_TITULO, DECRIPCION, ESTADO_DETALLE)
VALUES ('24', '7', 'Trámite y pago de la nómina de nuestros empleados de Movistar, Fundación Telefónica Colombia y Telefónica Global Technology Sucursal Colombia.', 'A');