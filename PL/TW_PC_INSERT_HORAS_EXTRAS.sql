create or replace PROCEDURE TW_PC_INSERT_HORAS_EXTRAS 
/**************************************************************************************
CREATE BY NELSON GALEANO    
    - ALMACENAR LAS HORAS EXTRAS SOLICITADAS POR EL USUARIO.
    - ENVIA CORREO AL USUARIO Y JEFE DE QUIEN HACE LA SOLICITUD.

VARIABLES DE ENTRADA
    IN_CODIGO_EPL       
    IN_HORAS            
    IN_FECHA            
    IN_CONCEPTO

VARIABLES DE SALIDA
    OUTPUT        0=ERROR  ,  1=OK          
    MESSAGE
***************************************************************************************/
(
  IN_CODIGO_EPL         IN VARCHAR2,
  IN_HORAS              IN VARCHAR2,
  IN_FECHA              IN VARCHAR2,
  IN_CONCEPTO           IN VARCHAR2,
  IN_INSERT             IN VARCHAR2,
  BLOQUE1               OUT SYS_REFCURSOR,
  OUTPUT                OUT VARCHAR2,
  MESSAGE               OUT VARCHAR2
) 
IS
V_CANT_REGIS        INTEGER;
V_COUNT             INTEGER;
V_HORAS             NUMBER(4);
V_FECHA             VARCHAR2(10);
V_COD_CON           NUMBER(4);
V_ESTADO            VARCHAR2(1);
V_COD_AUS           NUMBER(5);
V_COD_CC2           VARCHAR2(18);
V_CNSCTVO           NUMBER(15);
V_FORM_FECHA        VARCHAR2(10);
V_COD_JEFE          EMPLEADOS_GRAL.COD_JEFE%TYPE;          
V_NOM_EPL           EMPLEADOS_BASIC.NOM_EPL%TYPE;
V_APE_EPL           EMPLEADOS_BASIC.APE_EPL%TYPE;
V_EMAIL_EPL         EMPLEADOS_GRAL.EMAIL%TYPE;
V_COD_JEF_CONTROL   INTEGER;
V_EMAIL_JEFE        EMPLEADOS_GRAL.EMAIL%TYPE;
V_CED_JEFE          Empleados_Basic.Cedula%TYPE;
V_CED_EPL           Empleados_Basic.Cedula%TYPE;
V_NOM_JEFE          EMPLEADOS_BASIC.NOM_EPL%TYPE;
V_APE_JEFE          EMPLEADOS_BASIC.APE_EPL%TYPE;
V_USUARIO           INTEGER;
V_MENSAJE           VARCHAR2(30999);
V_CORREO            VARCHAR2(50);
V_DIAFESTIVO        NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)
V_VALOR             INTEGER;
V_FESTIVO           INTEGER; 
V_MENSAJE1          VARCHAR2(500);
V_MENSAJE2          VARCHAR2(500);
V_MESSAGE           VARCHAR(500);
V_BANDERA           VARCHAR(10);
V_VALIDACION        VARCHAR(10);

BEGIN
    V_FORM_FECHA := 'DD-MM-YY';
    V_ESTADO := 'P';
    V_COD_AUS := 1;
    V_MENSAJE2 := '';
    V_MENSAJE1 := NULL;
    V_BANDERA := 'TRUE';  
    
    OPEN BLOQUE1 FOR
    SELECT DISTINCT(COD_CON) AS COD_CON, 
    CASE WHEN COD_CON='1005' THEN 'Recargo nocturno ordinario' WHEN COD_CON='1006' THEN 'Horas extras diurnas' 
         WHEN COD_CON='1007' THEN 'Horas extras nocturnas' WHEN COD_CON='1008' THEN 'Horas extras festiva diurna'  
         WHEN COD_CON='1009' THEN 'Horas extras festiva nocturna' WHEN COD_CON='1118' THEN 'Recargo nocturno dominical/festivo'  
         WHEN COD_CON='1119' THEN 'Recargo diurno dominical/festivo' END AS CONCEPTO 
    FROM horasextras_tmp
    WHERE COD_CON >= 1005
    ORDER BY COD_CON;   
/* ----------------------------------------------------------------------------------------------------------------------------
========================================= VALIDACION DE LAS HORAS EXTRAS ======================================================
------------------------------------------------------------------------------------------------------------------------------*/    
    BEGIN    
        -- COD_CC2
        SELECT CEN.COD_CC2  
        INTO V_COD_CC2
        FROM EMPLEADOS_BASIC EMP, CARGOS CAR, CENTROCOSTO2 CEN 
        WHERE EMP.COD_CAR=CAR.COD_CAR 
        AND EMP.COD_CC2=CEN.COD_CC2 
        AND COD_EPL=IN_CODIGO_EPL;    
    END;        
    
    -- CONSECUTIVO
    SELECT COUNT(*) 
    INTO V_CNSCTVO
    FROM HORASEXTRAS_TMP;    
    
    SELECT COUNT(COLUMN_VALUE)
    INTO V_CANT_REGIS
    FROM TABLE(FN_SPLIT(IN_HORAS));
    
    V_COUNT := 1;
    
    WHILE V_COUNT <= V_CANT_REGIS
    LOOP   
        V_VALOR := '10';    
        -- TRAIGO UN REGISTRO POR CADA POSICION, V_COUNT ES LA VARIABLE QUE DETERMINA LA POSICION
        SELECT SPLIT(IN_FECHA,V_COUNT,',') 
        INTO V_FECHA
        FROM DUAL;
        -- TRAIGO UN REGISTRO POR CADA POSICION, V_COUNT ES LA VARIABLE QUE DETERMINA LA POSICION
        SELECT SPLIT(IN_CONCEPTO,V_COUNT,',') 
        INTO V_COD_CON
        FROM DUAL;        

        IF (TO_DATE(V_FECHA,V_FORM_FECHA) > SYSDATE) THEN 
            V_VALOR := '81';
        END IF;            

        --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
        V_DIAFESTIVO := FN_NUM_DIA_SEMANA(V_FECHA,V_FORM_FECHA);    
        --DBMS_OUTPUT.PUT_LINE(V_DIAFESTIVO);     

        BEGIN
            SELECT COUNT(FEC_FER)
            INTO V_FESTIVO
            FROM FERIADOS
            WHERE FEC_FER = TO_DATE(V_FECHA,V_FORM_FECHA);
        END;        

        IF ((V_FESTIVO = 0) AND (V_DIAFESTIVO <> '7')) THEN
            IF ((V_COD_CON = '1119') OR (V_COD_CON = '1118')) THEN
                V_VALOR := '78';        
            END IF;    
        ELSE
            IF (V_DIAFESTIVO = 7) THEN
                IF ((V_COD_CON = '1005') OR (V_COD_CON = '1006') OR (V_COD_CON = '1007')) THEN
                    V_VALOR := '78';        
                END IF;                
            END IF;
        END IF; 
        
        IF (V_FESTIVO > 0) THEN
            IF ((V_COD_CON = '1005') OR (V_COD_CON = '1006') OR (V_COD_CON = '1007')) THEN        
                V_VALOR := '78';
            END IF;
        ELSE
            IF ((V_FESTIVO = 0) AND (V_DIAFESTIVO <> 7)) THEN
                IF ((V_COD_CON = '1008') OR (V_COD_CON = '1009')) THEN
                    V_VALOR := '78';
                END IF;
            END IF;
        END IF;        
        
        IF (V_VALOR = '81') THEN
            V_MENSAJE2 := 'Debes seleccionar un dia anterior al actual';
            V_VALIDACION := 'FALSE';
        ELSE 
            IF (V_VALOR = '78') THEN
                V_MENSAJE2 := 'El concepto no pertenece al dia reportado';   
                V_VALIDACION := 'FALSE';
            ELSE
                V_MENSAJE2 := 'Registro Valido';   
                V_VALIDACION := 'OK';
            END IF;
        END IF;         
        
        IF (V_MENSAJE1 IS NULL)THEN
            V_MENSAJE1 := V_MENSAJE2;
        ELSE
            V_MENSAJE1 := V_MENSAJE1||','||V_MENSAJE2;
        END IF;
        
        IF (V_VALIDACION <> 'OK') THEN
            V_BANDERA := 'FALSE';
        END IF;         
        
        V_COUNT := V_COUNT + 1; 
        --RESETEO LAS VARIABLES PARA TOMAR EL SIGUIENTE VALOR
        V_HORAS := '';
        V_FECHA := '';
        V_COD_CON := '';        
    END LOOP;
/* ----------------------------------------------------------------------------------------------------------------------------
============================================ FIN VALIDACION HORAS EXTRAS ======================================================
------------------------------------------------------------------------------------------------------------------------------*/    
    IF ((V_BANDERA <> 'TRUE') OR (IN_INSERT = '0')) THEN
        -- Si un registro no es valido retorna la cadena indicando cual no cumple con las validaciones
        OUTPUT := '0';
        MESSAGE := V_MENSAJE1;        
    ELSE
/* ----------------------------------------------------------------------------------------------------------------------------
================================================== INSERT INTO Y CORREO =======================================================
------------------------------------------------------------------------------------------------------------------------------*/        
        IF ((V_BANDERA = 'TRUE') AND (IN_INSERT = '1')) THEN
            SELECT COD_JEFE
            INTO V_COD_JEFE
            FROM EMPLEADOS_GRAL
            WHERE COD_EPL = IN_CODIGO_EPL;
            
            SELECT NOM_EPL, APE_EPL
            INTO V_NOM_JEFE,V_APE_JEFE
            FROM EMPLEADOS_BASIC
            WHERE COD_EPL = V_COD_JEFE;        
            OUTPUT := '1';
            MESSAGE := 'Esta seguro que desea reportar la solicitud y enviarla a tu jefe '||V_NOM_JEFE||' '||V_APE_JEFE;
        ELSE            
            IF (IN_INSERT = '2') THEN 
                V_COUNT := 1;                
                WHILE V_COUNT <= V_CANT_REGIS
                LOOP                     
                    -- TRAIGO UN REGISTRO POR CADA POSICION, V_COUNT ES LA VARIABLE QUE DETERMINA LA POSICION
                    SELECT SPLIT(IN_HORAS,V_COUNT,',') 
                    INTO V_HORAS
                    FROM DUAL;
                    -- TRAIGO UN REGISTRO POR CADA POSICION, V_COUNT ES LA VARIABLE QUE DETERMINA LA POSICION
                    SELECT SPLIT(IN_FECHA,V_COUNT,',') 
                    INTO V_FECHA
                    FROM DUAL;
                    -- TRAIGO UN REGISTRO POR CADA POSICION, V_COUNT ES LA VARIABLE QUE DETERMINA LA POSICION
                    SELECT SPLIT(IN_CONCEPTO,V_COUNT,',') 
                    INTO V_COD_CON
                    FROM DUAL;    
                    
                    V_CNSCTVO := V_CNSCTVO + 1;
                    
                    INSERT INTO HORASEXTRAS_TMP (COD_EPL, FEC_INI, FEC_FIN, ESTADO, DIAS, FEC_INI_R, FEC_FIN_R, CNSCTVO, COD_CON,COD_AUS, COD_CC2, FEC_SOLICITUD)
                    VALUES (IN_CODIGO_EPL, TO_DATE(V_FECHA,V_FORM_FECHA),TO_DATE(V_FECHA,V_FORM_FECHA),V_ESTADO,V_HORAS,TO_DATE(V_FECHA,V_FORM_FECHA),TO_DATE(V_FECHA,V_FORM_FECHA),
                            V_CNSCTVO,V_COD_CON,V_COD_AUS,V_COD_CC2,SYSDATE);       
                    
                    V_COUNT := V_COUNT + 1; 
                    --RESETEO LAS VARIABLES PARA TOMAR EL SIGUIENTE VALOR
                    V_HORAS := '';
                    V_FECHA := '';
                    V_COD_CON := '';
                END LOOP;         
                -------------------------------------------------------------------------------------------------------------------------------------
                -------------------------------------------------- ENVIO DE CORREOS -----------------------------------------------------------------
                -------------------------------------------------------------------------------------------------------------------------------------
                --DATOS DEL EMPLEADO QUE SOLICITA LAS HORAS EXTRAS
                SELECT COUNT(A.COD_JEFE)
                INTO V_COD_JEF_CONTROL
                FROM EMPLEADOS_GRAL A, EMPLEADOS_BASIC B 
                WHERE A.COD_EPL = IN_CODIGO_EPL 
                AND A.COD_EPL=B.COD_EPL;        
                
                IF (V_COD_JEF_CONTROL > 0) THEN
                    --SI EL EMPLEADO TIENE JEFE
                    BEGIN 
                        SELECT A.COD_JEFE, B.NOM_EPL, B.APE_EPL--, A.EMAIL 
                        INTO V_COD_JEFE, V_NOM_EPL, V_APE_EPL--, V_EMAIL_EPL      
                        FROM EMPLEADOS_GRAL A, EMPLEADOS_BASIC B 
                        WHERE A.COD_EPL = IN_CODIGO_EPL 
                        AND A.COD_EPL=B.COD_EPL;
                        
                        -- DATOS DEL JEFE
                        SELECT B.CEDULA,B.NOM_EPL,B.APE_EPL, G.EMAIL 
                        INTO V_CED_JEFE,V_NOM_JEFE,V_APE_JEFE,V_EMAIL_JEFE
                        FROM EMPLEADOS_BASIC B, EMPLEADOS_GRAL G
                        WHERE B.COD_EPL = V_COD_JEFE
                        AND B.COD_EPL = G.COD_EPL;
                    END;        
                    --CORREO QUE SE ENVIA AL JEFE PARA SOLICITAR LAS HORAS EXTRAS DEL EMPLEADO
                    V_CORREO := V_EMAIL_JEFE;-- DIRECCION DE CORREO DONDE SE ENVIARA EL EMAIL(JEFE)        
                    V_USUARIO := '1'; -- TIPO USUARIO 1=JEFE  ,  0=EMPLEADO 
                    CORREO_SOLICI_HORASEX (V_NOM_EPL, V_APE_EPL,V_USUARIO,V_MENSAJE);        
                    ENVIA_CORREO.EMAIL(sender => 'nomina@talentsw.com',
                                       sender_name => 'Talentos y Tecnología SAS',
                                       recipients => V_CORREO,
                                       subject => 'REPORTE DE HORAS EXTRAS.',
                                       message => V_MENSAJE);  
                                       
                    --SE INSERTA EL CONTROL DE ENVIO DE CORREOS 
                    INSERT INTO T_ADMAIL (CEDULA, NOMBRES, APELLIDOS, FECHA_REG, NOVEDAD, COMENTARIO, EMPRESA) 
                    VALUES (V_CED_JEFE,V_NOM_JEFE,V_APE_JEFE,SYSDATE,'TRABAJO POR TURNOS',V_EMAIL_JEFE,'TELMOVIL');            
                END IF;   
                
                BEGIN
                    SELECT B.CEDULA,B.NOM_EPL, B.APE_EPL, A.EMAIL 
                    INTO V_CED_EPL, V_NOM_EPL, V_APE_EPL, V_EMAIL_EPL      
                    FROM EMPLEADOS_GRAL A, EMPLEADOS_BASIC B 
                    WHERE A.COD_EPL = IN_CODIGO_EPL 
                    AND A.COD_EPL=B.COD_EPL;        
                END;            
                --CORREO QUE SE ENVIA AL EMPLEADO CONFIRMANDO LA SOLICITUD DE HORAS EXTRAS
                V_CORREO := V_EMAIL_EPL;-- DIRECCION DE CORREO DONDE SE ENVIARA EL EMAIL(EMPLEADO)        
                V_USUARIO := '0'; -- TIPO USUARIO 1=JEFE  ,  0=EMPLEADO 
                CORREO_SOLICI_HORASEX (V_NOM_EPL, V_APE_EPL,V_USUARIO,V_MENSAJE);        
                ENVIA_CORREO.EMAIL(sender => 'nomina@talentsw.com',
                                   sender_name => 'Talentos y Tecnología SAS',
                                   recipients => V_CORREO,
                                   subject => 'REPORTE DE HORAS EXTRAS.',
                                   message => V_MENSAJE);    
                                   
                --SE INSERTA EL CONTROL DE ENVIO DE CORREOS 
                INSERT INTO T_ADMAIL (CEDULA, NOMBRES, APELLIDOS, FECHA_REG, NOVEDAD, COMENTARIO, EMPRESA) 
                VALUES (V_CED_EPL,V_NOM_EPL,V_APE_EPL,SYSDATE,'TRABAJO POR TURNOS',V_EMAIL_EPL,'TELMOVIL');               
                
                OUTPUT := '2';
                MESSAGE := 'La solicitud fue enviada exitosamente.';            
            END IF;        
        END IF;            
    END IF;    
END TW_PC_INSERT_HORAS_EXTRAS;