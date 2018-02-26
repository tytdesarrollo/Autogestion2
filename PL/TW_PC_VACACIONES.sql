create or replace PROCEDURE TW_PC_VACACIONES
/******************************************************************************
    CREATE BY NELSON GALEANO
    Automatically available Auto Replace Keywords:
    Object Name:     TW_PC_VACACIONES
    Sysdate:         25/04/2017
    Procedimiento que muestra el Historial de las vacaciones, los periodos y dias pendientes que tiene para solicitar vacaiones.
    
   NOTES:
    VARIABLES DE ENTRADA    
        IN_CODIGO_EPL         Codigo del empleado
        
    VARIABLES DE SALIDA
        BLOQUE1              Historial de vacaciones del usuario
        OUTPUT_B1            Numero de la salida (SI ES IGUA A CERO NO HAY DATOS)        
        BLOQUE2              Periodos pendientes de vacaciones por disfrutar
        OUTPUT_B2            Numero de la salida (SI ES IGUA A CERO NO HAY DATOS)                
        OUT_DIAS_PEND        Dias pendientes o disponibles para solicitar vacaciones
******************************************************************************/
(
    IN_CODIGO_EPL   IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    BLOQUE1         OUT SYS_REFCURSOR,
    OUTPUT_B1       OUT VARCHAR2,    
    BLOQUE2         OUT SYS_REFCURSOR,
    OUTPUT_B2       OUT VARCHAR2,        
    OUT_DIAS_PEND   OUT NUMBER
) 

IS
vcod_con NUMBER(4); --Codigo Concepto 1017
vcod_aus NUMBER(5); --Codigo Ausencia 1
v_cantHistorial NUMBER(10);
v_cantPeriodos NUMBER(10);
v_cantDias NUMBER(10);

BEGIN
    vcod_con := 1017;
    vcod_aus := 1;
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------HISTORIAL DE VACACIONES------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
   BEGIN
        --VERIFICO SI HAY REGISTROS EN LA CONSULTA
        SELECT COUNT(CNSCTVO)
        INTO v_cantHistorial
        FROM ausencias_tmp 
        WHERE cod_con=vcod_con 
        AND cod_aus=vcod_aus 
        AND estado IN ('P','R','C') 
        AND cod_epl=IN_CODIGO_EPL;
        
        IF (v_cantHistorial > 0) THEN
            --Historial de vacaciones del usuario
            OPEN  BLOQUE1 FOR    
            SELECT CNSCTVO AS CONSECUTIVO, TO_CHAR(FEC_SOLICITUD,'YYYY-MM-DD') FEC_SOLICITUD,TO_CHAR(FEC_INI,'YYYY-MM-DD') FEC_INI, TO_CHAR(FEC_FIN,'YYYY-MM-DD') FEC_FIN, DIAS, 
                CASE  WHEN ESTADO= 'C' THEN 'APROBADO' WHEN ESTADO='R' THEN 'RECHAZADO' ELSE 'PENDIENTE' END AS ESTADO,
                CASE  WHEN ESTADO= 'C' THEN 'GREEN' WHEN ESTADO='R' THEN 'RED' ELSE 'GREY' END AS COLOR
            FROM ausencias_tmp 
            WHERE cod_con=vcod_con 
            AND cod_aus=vcod_aus 
            AND estado IN ('P','R','C') 
            AND cod_epl=IN_CODIGO_EPL
            ORDER BY FEC_INI desc;
            
            OUTPUT_B1 := '1';   
        ELSE
            --SE HACE CUALQUIER CONSULTA PARA NO ENVIAR EL CURSOR BLOQUE1 VACIO POR QUE GENERA ERROR EN LA APLICACION
            OPEN BLOQUE1 FOR
            SELECT 1,2,3,4,5,6 FROM DUAL;
            
            OUTPUT_B1 := '0';               
        END IF;
    END;
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------PERIODOS PENDIENTES DE VACACIONES--------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    BEGIN
        --VERIFICO SI HAY REGISTROS EN LA CONSULTA        
        SELECT COUNT(COD_EPL)
        INTO v_cantPeriodos
        FROM VACACIONES_PENDIENTES WHERE COD_EPL = IN_CODIGO_EPL
        ORDER BY FEC_INI_PER;
        
        IF (v_cantPeriodos > 0) THEN        
            --Periodos pendientes de vacaciones por disfrutar
            OPEN BLOQUE2 FOR
            SELECT TO_CHAR(FEC_INI_PER,'YYYY-MM-DD') AS FEC_INI_PERIODO, TO_CHAR(FEC_FIN_PER,'YYYY-MM-DD') AS FEC_FIN_PERIODO, DIAS
            FROM VACACIONES_PENDIENTES WHERE COD_EPL = IN_CODIGO_EPL
            ORDER BY FEC_INI_PER;
            
            OUTPUT_B2 := '1';               
        ELSE
            --SE HACE CUALQUIER CONSULTA PARA NO ENVIAR EL CURSOR BLOQUE2 VACIO POR QUE GENERA ERROR EN LA APLICACION
            OPEN BLOQUE2 FOR
            SELECT 1,2,3 FROM DUAL;
            
            OUTPUT_B2 := '0';                       
        END IF;
    END;
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------DIAS DISPONIBLES A DISFRUTAR-----------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------   
    BEGIN
        --VERIFICO SI HAY REGISTROS EN LA CONSULTA      
        SELECT COUNT(DIAS)
        INTO v_cantDias
        FROM VACACIONES_PENDIENTES WHERE COD_EPL =IN_CODIGO_EPL
        ORDER BY FEC_INI_PER;            
    
        IF (v_cantDias > 0) THEN
            --Dias pendientes o disponibles para solicitar vacaciones
            SELECT SUM(DIAS)
            INTO OUT_DIAS_PEND
            FROM VACACIONES_PENDIENTES WHERE COD_EPL =IN_CODIGO_EPL
            ORDER BY FEC_INI_PER;
        ELSE
            OUT_DIAS_PEND := 0;
        END IF;
    END;
    
    EXCEPTION
        WHEN NO_DATA_FOUND THEN  NULL;
END TW_PC_VACACIONES;