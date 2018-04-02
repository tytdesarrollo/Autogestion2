create or replace PROCEDURE TW_PC_ENVIO_VACACIONES 
/******************************************************************************
   CREATE BY NELSON GALEANO    
   PROCEDIMIENTO PARA SOLICITAR VACACIONES.

   NOTES:
    VARIABLES DE ENTRADA
        IN_DIAS       CANTIDAD DE DIAS SOLICITADOS        
        IN_FEC_INI         FECHA INICIAL 
        IN_FEC_FIN         FECHA FINAL
        IN_CODIGO_EPL      CODIGO DEL EMPLEADO
        
    VARIABLES DE SALIDA
        OUTPUT          NUMERO DE LA SALIDA
        MESSAGE         MENSAJE DE AYUDA DE SALIDA O ERRROR
        
******************************************************************************/
(
    IN_CODIGO_EPL   IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    IN_DIAS         IN NUMBER,
    IN_FEC_INI      IN VARCHAR2,
    IN_FEC_FIN      IN VARCHAR2,    
    OUTPUT          OUT VARCHAR2,
    MESSAGE         OUT VARCHAR2
)
IS
V_FECHA_CIERRE      VARCHAR2(12);  --ALMACENA LA FECHA DE CIERRE DE NOMINA
V_DIA               VARCHAR2(12);  --ALMACENA DIA DE LA SEMANA
V_NUMDIA            VARCHAR2(3);   --ALMACENA NUMERO DEL DIA DE LA SEMANA  
V_MES               VARCHAR2(12);  --ALMACENA EL MES DEL AÑO 
V_AÑO               VARCHAR2(5);   --ALMACENA EL NUMERO DEL AÑO  
V_FECFINAL          VARCHAR2(50);  --ALMACENA EL FORMATO FECHA DE CIERRE DE NOMINA (EJ: LUNES, 15 DE MAYO DEL 2017)
V_COD_JEFE          EMPLEADOS_BASIC.COD_EPL%TYPE;
V_NOM_EPL           EMPLEADOS_BASIC.NOM_EPL%TYPE;
V_APE_EPL           EMPLEADOS_BASIC.APE_EPL%TYPE;
V_EMAIL             EMPLEADOS_GRAL.EMAIL%TYPE;
V_EMAIL_JEFE        VARCHAR2(60);
CORREO              VARCHAR2(50);
V_COD_CON           NUMBER(5);
V_COD_AUS           NUMBER(5);
V_ESTADO            VARCHAR2(1);
V_CONSECUTIVO       NUMBER(15);
V_COD_CC2           VARCHAR2(30);
MENSAJE             VARCHAR2(30999);

BEGIN
    V_COD_CON := 1017;
    V_COD_AUS := 1;
    V_ESTADO := 'P';
    
    IF IN_FEC_FIN IS NOT NULL THEN
        BEGIN        
            --CONSULTA LA FECHA DE CIERRE DE NOMINA
            SELECT FEC_CIE INTO V_FECHA_CIERRE FROM  CIERRE_NOVPAG C, 
            (SELECT CASE WHEN (CASE WHEN  TO_DATE('2015-06-01', 'YYYY-MM-DD') > C.FEC_CIE THEN C.COD_PER+1 ELSE C.COD_PER END ) >12 THEN 1 
            ELSE (CASE WHEN  TO_DATE('2015-06-01', 'YYYY-MM-DD') > C.FEC_CIE THEN C.COD_PER+1 ELSE C.COD_PER END ) END COD_PER,     
            CASE WHEN (CASE WHEN  TO_DATE('2015-06-01', 'YYYY-MM-DD') > FEC_CIE THEN C.COD_PER+1 ELSE C.COD_PER END) >12 THEN C.ANO+1 ELSE C.ANO END ANO
            FROM CIERRE_NOVPAG C, PERIODOS P
            WHERE TO_DATE('2015-06-01', 'YYYY-MM-DD') BETWEEN P.FEC_INI AND P.FEC_FIN
            AND C.ANO =P.ANO
            AND C.COD_PER = P.COD_PER
            AND P.TIP_PER = 3 ) B
            WHERE C.COD_PER = B.COD_PER 
            AND C.ANO = B.ANO;        
            
            --OBTENGO EL DIA DE LA SEMANA (EJ; LUNES)
            V_DIA := INITCAP(TO_CHAR(TO_DATE(V_FECHA_CIERRE, 'DD-MM-YY'), 'DAY', 'NLS_DATE_LANGUAGE=SPANISH'));
                        
            --OBTENGO NUMERO DEL DIA DE LA SEMANA (EJ: 15)
            V_NUMDIA := TO_CHAR(TO_DATE(V_FECHA_CIERRE,'DD-MM-YY'),'DD');
            
            --OBTENGO EL MES DEL AÑO (EJ: JUNIO)
            V_MES := INITCAP(TO_CHAR(TO_DATE(V_FECHA_CIERRE,'DD-MM-YY'), 'MONTH', 'NLS_DATE_LANGUAGE=SPANISH'));            
            
            --OBTENGO NUMERO DEL AÑO (EJ: 2016)
            V_AÑO := TO_CHAR(TO_DATE(V_FECHA_CIERRE,'DD-MM-YY'),'YYYY');
            
            --VARIABLE QUE ALMACENA EL FORMATO DE LA FECHA DE CIERRE DE NOMINA (EJ: LUNES, 15 DE MAYO DEL 2017)
            V_FECFINAL := V_DIA||', '||V_NUMDIA||' DE '||V_MES||' DEL '||V_AÑO;
        END;
        BEGIN
            --DATOS DEL USUARIO Y EL CODIGO DEL JEFE
            SELECT A.COD_JEFE, B.NOM_EPL, B.APE_EPL, A.EMAIL
            INTO V_COD_JEFE, V_NOM_EPL, V_APE_EPL, V_EMAIL 
            FROM EMPLEADOS_GRAL A, EMPLEADOS_BASIC B 
            WHERE A.COD_EPL=IN_CODIGO_EPL 
            AND A.COD_EPL=B.COD_EPL;        

            --CONSULTO EL CORREO DEL JEFE
            SELECT EMAIL 
            INTO V_EMAIL_JEFE
            FROM EMPLEADOS_GRAL WHERE COD_EPL=IN_CODIGO_EPL;
        END;            
        
        BEGIN
            SELECT COUNT(*)+1 
            INTO V_CONSECUTIVO FROM AUSENCIAS_TMP;        
            
            SELECT CEN.COD_CC2  
            INTO V_COD_CC2
            FROM EMPLEADOS_BASIC EMP, CARGOS CAR, CENTROCOSTO2 CEN 
            WHERE EMP.COD_CAR=CAR.COD_CAR 
            AND EMP.COD_CC2=CEN.COD_CC2 
            AND COD_EPL=IN_CODIGO_EPL;
            
            INSERT INTO AUSENCIAS_TMP(COD_EPL, FEC_INI, FEC_FIN, ESTADO, DIAS, FEC_INI_R, FEC_FIN_R, CNSCTVO, COD_CON, COD_AUS, COD_CC2, FEC_SOLICITUD)
            VALUES(IN_CODIGO_EPL, TO_DATE (IN_FEC_INI, 'DD-MM-YY'), TO_DATE (IN_FEC_FIN, 'DD-MM-YY'), V_ESTADO, IN_DIAS, TO_DATE(IN_FEC_INI, 'DD-MM-YY'), 
            TO_DATE (IN_FEC_FIN, 'DD-MM-YY'), V_CONSECUTIVO, V_COD_CON, V_COD_AUS,V_COD_CC2, SYSDATE);            
        END;        

        BEGIN 
            --IF V_EMAIL_JEFE IS NOT NULL THEN
                --CORREO QUE SE ENVIA AL JEFE PARA APROBACION DE LAS VACACIONES
                CORREO := 'SOPORTE1@TALENTSW.COM';-- DIRECCION DE CORREO DONDE SE ENVIARA EL EMAIL (JEFE)
                V_EMAIL_JEFE := '1';
                CORREO_SOLICI_VACACIONES (V_NOM_EPL, V_APE_EPL,IN_FEC_INI,IN_FEC_FIN,IN_DIAS,V_FECFINAL,V_EMAIL_JEFE,MENSAJE);        
                ENVIA_CORREO.EMAIL(sender => 'nags_dcm2028@hotmail.com',
                                   sender_name => 'Talentos y Tecnología SAS',
                                   recipients => correo,
                                   subject => 'Vacaciones Telefonica - '||V_NOM_EPL||' '||V_APE_EPL||' - Solicitud Inicial.',
                                   message => mensaje);    
           -- END IF;
        END;
        
        BEGIN
            --CORREO QUE SE ENVIA AL USUARIO QUE SOLICITA LAS VACACIONES            
            CORREO := 'nelgaleano.2028@gmail.com';--DIRECCION EMAIL DONDE SE ENVIARA CORREO (EMPLEADO)
            V_EMAIL_JEFE := '0';
            CORREO_SOLICI_VACACIONES (V_NOM_EPL, V_APE_EPL,IN_FEC_INI,IN_FEC_FIN,IN_DIAS,v_fecFinal,V_EMAIL_JEFE,mensaje);        
            ENVIA_CORREO.EMAIL(sender => 'nags_dcm2028@hotmail.com',
                               sender_name => 'Talentos y Tecnología SAS',
                               recipients => correo,
                               subject => 'Vacaciones Telefonica - '||V_NOM_EPL||' '||V_APE_EPL||' - Solicitud Inicial.',
                               message => mensaje);                               
        END;      
        OUTPUT := 1;
        MESSAGE := 'La solicitud fue enviada exitosamente';
    ELSE
        OUTPUT := 0;
        MESSAGE := 'Existen campos vacios.';
    END IF;

END TW_PC_ENVIO_VACACIONES;