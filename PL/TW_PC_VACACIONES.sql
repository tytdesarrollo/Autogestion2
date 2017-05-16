create or replace PROCEDURE TW_PC_VACACIONES
/******************************************************************************
    CREATE BY NELSON GALEANO
    Automatically available Auto Replace Keywords:
    Object Name:     TW_PC_VACACIONES
    Sysdate:         25/04/2017
    Procedimiento que muestra el Historial de las vacaciones, los periodos y duas pendientes que tiene para solicitar vacaiones.
    
   NOTES:
    VARIABLES DE ENTRADA    
        vcodigo_epl         Codigo del empleado
        
    VARIABLES DE SALIDA
        c_historial          Historial de vacaciones del usuario
        c_vac_pendientes     Periodos pendientes de vacaciones por disfrutar
        vdias_pendientes     Dias pendientes o disponibles para solicitar vacaciones
******************************************************************************/
(
    vcodigo_epl IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    c_historial OUT SYS_REFCURSOR,
    c_vac_pendientes OUT SYS_REFCURSOR,
    vdias_pendientes OUT NUMBER
) 

IS
vcod_con NUMBER(4); --Codigo Concepto 1017
vcod_aus NUMBER(5); --Codigo Ausencia 1

BEGIN
    vcod_con := 1017;
    vcod_aus := 1;
   BEGIN
        --Historial de vacaciones del usuario
        OPEN  c_historial FOR    
        SELECT CNSCTVO, FEC_SOLICITUD,FEC_INI, FEC_FIN, DIAS, 
            CASE  WHEN ESTADO= 'C' THEN 'APROBADO' WHEN ESTADO='R' THEN 'RECHAZADO' ELSE 'PENDIENTE' END 
        FROM ausencias_tmp 
        WHERE cod_con=vcod_con 
        AND cod_aus=vcod_aus 
        AND estado IN ('P','R','C') 
        AND cod_epl=vcodigo_epl;
    END;
    
    BEGIN
        --Periodos pendientes de vacaciones por disfrutar
        OPEN c_vac_pendientes FOR
        SELECT FEC_INI_PER, FEC_FIN_PER, DIAS
        FROM VACACIONES_PENDIENTES WHERE COD_EPL = vcodigo_epl
        ORDER BY FEC_INI_PER;
    END;
    
    BEGIN
        --Dias pendientes o disponibles para solicitar vacaciones
        SELECT SUM(DIAS)
        INTO vdias_pendientes
        FROM VACACIONES_PENDIENTES WHERE COD_EPL =vcodigo_epl
        ORDER BY FEC_INI_PER;
    END;
    
    EXCEPTION
        WHEN NO_DATA_FOUND THEN  NULL;
END TW_PC_VACACIONES;