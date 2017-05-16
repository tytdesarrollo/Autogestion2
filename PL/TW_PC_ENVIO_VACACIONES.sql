create or replace PROCEDURE TW_PC_ENVIO_VACACIONES 
/******************************************************************************
   CREATE BY NELSON GALEANO    
   Procedimiento para solicitar vacaciones.

   NOTES:
    VARIABLES DE ENTRADA
        cant_dias       Cantidad de dias solicitados        
        fec_ini         Fecha inicial 
        fec_fin         Fecha Final
        codigo_epl      Codigo del empleado
        
    VARIABLES DE SALIDA
        OUTPUT          Numero de la salida
        MESSAGE         Mensaje de ayuda de salida o errror
        
******************************************************************************/
(
    cant_dias IN NUMBER,
    fec_ini IN VARCHAR2,
    fec_fin IN VARCHAR2,
    codigo_epl IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    OUTPUT OUT VARCHAR2,
    MESSAGE OUT VARCHAR2
)
IS
v_fecha_cierre  VARCHAR2(12);  --Almacena la fecha de cierre de Nomina
v_dia           VARCHAR2(12);  --Almacena dia de la semana
v_numDia        VARCHAR2(3);   --Almacena numero del dia de la semana  
v_mes           VARCHAR2(12);  --Almacena el mes del año 
v_año           VARCHAR2(5);   --Almacena el numero del año  
v_fecFinal      VARCHAR2(50);  --Almacena el formato fecha de cierre de nomina (Ej: Lunes, 15 de Mayo del 2017)
COD_JEFE        EMPLEADOS_BASIC.COD_EPL%TYPE;
NOM_EPL         EMPLEADOS_BASIC.NOM_EPL%TYPE;
APE_EPL         EMPLEADOS_BASIC.APE_EPL%TYPE;
EMAIL           EMPLEADOS_GRAL.EMAIL%TYPE;
v_emailJefe     VARCHAR2(60);
CORREO          VARCHAR2(50);
v_cod_con       NUMBER(5);
v_cod_aus       NUMBER(5);
v_estado        VARCHAR2(1);
v_consecutivo   NUMBER(15);
v_cod_cc2       VARCHAR2(30);
MENSAJE         VARCHAR2(30999);

BEGIN
    v_cod_con := 1017;
    v_cod_aus := 1;
    v_estado := 'P';
    
    IF fec_fin IS NOT NULL THEN
        BEGIN        
            --CONSULTA LA FECHA DE CIERRE DE NOMINA
            SELECT fec_cie INTO v_fecha_cierre FROM  cierre_novpag c, 
            (select case when (case when  to_date('2015-06-01', 'YYYY-MM-DD') > c.fec_cie then c.cod_per+1 else c.cod_per end ) >12 then 1 
            else (case when  to_date('2015-06-01', 'YYYY-MM-DD') > c.fec_cie then c.cod_per+1 else c.cod_per end ) end cod_per,     
            case when (case when  to_date('2015-06-01', 'YYYY-MM-DD') > fec_cie then c.cod_per+1 else c.cod_per end) >12 then c.ano+1 else c.ano end ano
            from cierre_novpag c, periodos p
            where to_date('2015-06-01', 'YYYY-MM-DD') between p.fec_ini and p.fec_fin
            and c.ano =p.ano
            and c.cod_per = p.cod_per
            and p.tip_per = 3 ) b
            where c.cod_per = b.cod_per 
            and c.ano = b.ano;        
            
            --OBTENGO EL DIA DE LA SEMANA (Ej; Lunes)
            v_dia := INITCAP(TO_CHAR(TO_DATE(v_fecha_cierre, 'DD-MM-YY'), 'DAY', 'NLS_DATE_LANGUAGE=SPANISH'));
                        
            --OBTENGO NUMERO DEL DIA DE LA SEMANA (Ej: 15)
            v_numDia := TO_CHAR(TO_DATE(v_fecha_cierre,'DD-MM-YY'),'DD');
            
            --OBTENGO EL MES DEL AÑO (Ej: Junio)
            v_mes := INITCAP(TO_CHAR(TO_DATE(v_fecha_cierre,'DD-MM-YY'), 'MONTH', 'NLS_DATE_LANGUAGE=SPANISH'));            
            
            --OBTENGO NUMERO DEL AÑO (Ej: 2016)
            v_año := TO_CHAR(TO_DATE(v_fecha_cierre,'DD-MM-YY'),'YYYY');
            
            --Variable que almacena el formato de la fecha de cierre de Nomina (Ej: Lunes, 15 de Mayo del 2017)
            v_fecFinal := v_dia||', '||v_numDia||' de '||v_mes||' del '||v_año;
        END;
        BEGIN
            --DATOS DEL USUARIO Y EL CODIGO DEL JEFE
            select a.cod_jefe, b.nom_epl, b.ape_epl, a.email
            INTO COD_JEFE, NOM_EPL, APE_EPL, EMAIL 
            from empleados_gral a, empleados_basic b 
            where a.cod_epl=codigo_epl 
            and a.cod_epl=b.cod_epl;        

            --CONSULTO EL CORREO DEL JEFE
            SELECT email 
            INTO v_emailJefe
            FROM empleados_gral WHERE cod_epl=codigo_epl;
        END;            
        
        BEGIN
            SELECT COUNT(*)+1 
            INTO v_consecutivo FROM ausencias_tmp;        
            
            SELECT cen.cod_cc2  
            INTO v_cod_cc2
            FROM empleados_basic emp, cargos car, centrocosto2 cen 
            WHERE emp.cod_car=car.cod_car 
            AND emp.cod_cc2=cen.cod_cc2 
            AND cod_epl=codigo_epl;
            
            /*INSERT INTO ausencias_tmp(cod_epl, fec_ini, fec_fin, estado, dias, fec_ini_r, fec_fin_r, cnsctvo, cod_con, cod_aus, cod_cc2, fec_solicitud)
            VALUES(codigo_epl, TO_DATE (fec_ini, 'DD-MM-YY'), TO_DATE (fec_fin, 'DD-MM-YY'), v_estado, cant_dias, TO_DATE(fec_ini, 'DD-MM-YY'), 
            TO_DATE (fec_fin, 'DD-MM-YY'), v_consecutivo, v_cod_con, v_cod_aus,v_cod_cc2, SYSDATE);*/            
        END;        

        BEGIN 
            --IF v_emailJefe IS NOT NULL THEN
                --CORREO QUE SE ENVIA AL JEFE PARA APROBACION DE LAS VACACIONES
                CORREO := 'soporte1@talentsw.com';-- DIRECCION DE CORREO DONDE SE ENVIARA EL EMAIL (JEFE)
                v_emailJefe := '1';
                CORREO_SOLICI_VACACIONES (NOM_EPL, APE_EPL,fec_ini,fec_fin,cant_dias,v_fecFinal,v_emailJefe,mensaje);        
                ENVIA_CORREO.EMAIL(sender => 'nags_dcm2028@hotmail.com',
                                   sender_name => 'Talentos y Tecnología SAS',
                                   recipients => correo,
                                   subject => 'Vacaciones Telefonica - '||NOM_EPL||' '||APE_EPL||' - Solicitud Inicial.',
                                   message => mensaje);    
           -- END IF;
        END;
        
        BEGIN
            --CORREO QUE SE ENVIA AL USUARIO QUE SOLICITA LAS VACACIONES            
            CORREO := 'nelgaleano.2028@gmail.com';--DIRECCION EMAIL DONDE SE ENVIARA CORREO (EMPLEADO)
            v_emailJefe := '0';
            CORREO_SOLICI_VACACIONES (NOM_EPL, APE_EPL,fec_ini,fec_fin,cant_dias,v_fecFinal,v_emailJefe,mensaje);        
            ENVIA_CORREO.EMAIL(sender => 'nags_dcm2028@hotmail.com',
                               sender_name => 'Talentos y Tecnología SAS',
                               recipients => correo,
                               subject => 'Vacaciones Telefonica - '||NOM_EPL||' '||APE_EPL||' - Solicitud Inicial.',
                               message => mensaje);                               
        END;      
        OUTPUT := 1;
        MESSAGE := 'La solicitud fue enviada exitosamente';
    ELSE
        OUTPUT := 0;
        MESSAGE := 'Existen campos vacios.';
    END IF;

END TW_PC_ENVIO_VACACIONES;