create or replace PROCEDURE TW_PC_HORAS_EXTRAS_HISTORIAL
/**************************************************************************************
   CREATE BY NELSON GALEANO    
   Procedimiento que retorna el hostorial de horas extras por usuario.
   NOTES:
    VARIABLES DE ENTRADA
        IN_CODIGO_EPL       CODIGO DEL EMPLEADO, PARAMETRO DE ENTRADA
        
    VARIABLES DE SALIDA
        BLOQUE1         Bloque que retorna Historial de Horas Extras
        BLOQUE2         Bloque que retorna LOS 5 ULTIMOS REGISTROS
        OUTPUT          Numero de la salida (SI ES IGUAL A CERO NO HAY DATOS)
        MESSAGE         Mensaje de salida.
        
***************************************************************************************/
(
  IN_CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE,
  BLOQUE1       OUT SYS_REFCURSOR,
  BLOQUE2       OUT SYS_REFCURSOR,
  OUTPUT        OUT VARCHAR2,
  MESSAGE       OUT VARCHAR2
) 
IS

CANTIDAD INTEGER;

BEGIN
  /*
  --NOMBRE DE LOS CONCEPTOS
  1005 = Recargo nocturno ordinario
  1006 = Horas extras diurnas
  1007 = Horas extras nocturnas
  1008 = Horas extras festiva diurna
  1009 = Horas extras festiva nocturna
  1118 = Recargo nocturno dominical/festivo
  1119 = Recargo diurno dominical/festivo
  
  NOMBRE DE LOS ESTADOS
  P = Pendiente por aprobar jefe
  R = Rechazado
  L = Pendiente por aprobar gerente
  C = Aprobado por gerente
  */
  
  SELECT COUNT(COD_CON) 
  INTO CANTIDAD
  FROM horasextras_tmp 
  WHERE cod_epl = IN_CODIGO_EPL; 
  
  IF (CANTIDAD > 0) THEN
    BEGIN
        OPEN BLOQUE1 FOR
        SELECT CNSCTVO AS CONSECUTIVO, TO_CHAR(FEC_SOLICITUD,'YYYY-MM-DD') AS FEC_SOLICITUD, TO_CHAR(FEC_INI,'YYYY-MM-DD') AS FEC_H_EXTRAS, DIAS AS HORAS, 
        CASE WHEN COD_CON='1005' THEN 'Recargo nocturno ordinario' WHEN COD_CON='1006' THEN 'Horas extras diurnas' 
             WHEN COD_CON='1007' THEN 'Horas extras nocturnas' WHEN COD_CON='1008' THEN 'Horas extras festiva diurna'  
             WHEN COD_CON='1009' THEN 'Horas extras festiva nocturna' WHEN COD_CON='1118' THEN 'Recargo nocturno dominical/festivo'  
             WHEN COD_CON='1119' THEN 'Recargo diurno dominical/festivo' END AS CONCEPTO, 
        CASE WHEN ESTADO='P' THEN 'Pendiente por aprobar jefe' WHEN ESTADO='R' THEN 'Rechazado'  
             WHEN ESTADO='L' THEN 'Pendiente por aprobar gerente' WHEN ESTADO='C' THEN 'Aprobado por gerente' END AS ESTADO,
        CASE WHEN ESTADO='P' THEN 'GREY' WHEN ESTADO='R' THEN 'RED' WHEN ESTADO='L' THEN 'BLUE' WHEN ESTADO='C' THEN 'GREEN' END AS COLOR         
        FROM horasextras_tmp 
        WHERE cod_epl=IN_CODIGO_EPL;
    END;
    
    BEGIN
        OPEN BLOQUE2 FOR
        SELECT CNSCTVO AS CONSECUTIVO, TO_CHAR(FEC_SOLICITUD,'YYYY-MM-DD') AS FEC_SOLICITUD, TO_CHAR(FEC_INI,'YYYY-MM-DD') AS FEC_H_EXTRAS, DIAS AS HORAS, 
        CASE WHEN COD_CON='1005' THEN 'Recargo nocturno ordinario' WHEN COD_CON='1006' THEN 'Horas extras diurnas' 
             WHEN COD_CON='1007' THEN 'Horas extras nocturnas' WHEN COD_CON='1008' THEN 'Horas extras festiva diurna'  
             WHEN COD_CON='1009' THEN 'Horas extras festiva nocturna' WHEN COD_CON='1118' THEN 'Recargo nocturno dominical/festivo'  
             WHEN COD_CON='1119' THEN 'Recargo diurno dominical/festivo' END AS CONCEPTO, 
        CASE WHEN ESTADO='P' THEN 'Pendiente por aprobar jefe' WHEN ESTADO='R' THEN 'Rechazado'  
             WHEN ESTADO='L' THEN 'Pendiente por aprobar gerente' WHEN ESTADO='C' THEN 'Aprobado por gerente' END AS ESTADO,
        CASE WHEN ESTADO='P' THEN 'GREY' WHEN ESTADO='R' THEN 'RED' WHEN ESTADO='L' THEN 'BLUE' WHEN ESTADO='C' THEN 'GREEN' END AS COLOR         
        FROM horasextras_tmp 
        WHERE cod_epl=IN_CODIGO_EPL
        AND ROWNUM <= 5;    
    END;
    
    OUTPUT := '1';    
  ELSE
    --SE HACE CUALQUIER CONSULTA PARA NO ENVIAR EL CURSOR C_BLOQUE1 VACIO POR QUE GENERA ERROR EN LA APLICACION
    OPEN BLOQUE1 FOR
    SELECT 1,2,3,4,5,6 FROM DUAL;
    
    OPEN BLOQUE2 FOR
    SELECT 1,2,3,4,5,6 FROM DUAL;
    
    OUTPUT := '0';
    MESSAGE := 'No hay datos';
  END IF;   
END TW_PC_HORAS_EXTRAS_HISTORIAL;