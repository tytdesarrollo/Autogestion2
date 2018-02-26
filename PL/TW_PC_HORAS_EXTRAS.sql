create or replace PROCEDURE TW_PC_HORAS_EXTRAS 
/**************************************************************************************
   CREATE BY NELSON GALEANO    
   PROCEDIMIENTO PARA VALIDAR QUE LAS HORAS EXTRAS SOLICITADAS SEAN CORRECTAS
   NOTES:
    VARIABLES DE ENTRADA
        IN_CODIGO_EPL       CODIGO DEL EMPLEADO, PARAMETRO DE ENTRADA
        IN_FECHA
        IN_HORAS
        IN_CONCEPTO

    VARIABLES DE SALIDA
        OUTPUT      MESSAGE  
        78          El concepto no pertenece al dia reportado
        81          Debes seleccionar un dia anterior al actual
        1           OK (FECHA Y CONCEPTO SON VALIDOS)      
***************************************************************************************/
(
  IN_CODIGO_EPL     IN EMPLEADOS_BASIC.COD_EPL%TYPE,
  IN_HORAS          IN VARCHAR2,
  IN_FECHA          IN VARCHAR2,
  IN_CONCEPTO       IN VARCHAR2,
  BLOQUE1           OUT SYS_REFCURSOR,
  OUTPUT            OUT VARCHAR2,
  MESSAGE           OUT VARCHAR2
) 
IS
V_VALOR             INTEGER;
V_FESTIVO           INTEGER;     
V_FORM_FECHA        VARCHAR2(10);
V_DIAFESTIVO        NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)

BEGIN        
    OPEN BLOQUE1 FOR
    SELECT DISTINCT(COD_CON) AS COD_CON, 
    CASE WHEN COD_CON='1005' THEN 'Recargo nocturno ordinario' WHEN COD_CON='1006' THEN 'Horas extras diurnas' 
         WHEN COD_CON='1007' THEN 'Horas extras nocturnas' WHEN COD_CON='1008' THEN 'Horas extras festiva diurna'  
         WHEN COD_CON='1009' THEN 'Horas extras festiva nocturna' WHEN COD_CON='1118' THEN 'Recargo nocturno dominical/festivo'  
         WHEN COD_CON='1119' THEN 'Recargo diurno dominical/festivo' END AS CONCEPTO 
    FROM horasextras_tmp
    WHERE COD_CON >= 1005
    ORDER BY COD_CON;   

    V_FORM_FECHA := 'DD-MM-YYYY'; -- FORMATO QUE SE MANEJA PARA TODAS LAS FECHAS
    
    IF (TO_DATE(IN_FECHA,V_FORM_FECHA) > SYSDATE) THEN 
        V_VALOR := '81';
    END IF;
    
    --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
    V_DIAFESTIVO := FN_NUM_DIA_SEMANA(IN_FECHA,V_FORM_FECHA);    
    --DBMS_OUTPUT.PUT_LINE(V_DIAFESTIVO); 
    
    BEGIN
        SELECT COUNT(FEC_FER)
        INTO V_FESTIVO
        FROM FERIADOS
        WHERE FEC_FER = TO_DATE(IN_FECHA,V_FORM_FECHA);
    END;
    
    IF ((V_FESTIVO = 0) AND (V_DIAFESTIVO <> '7')) THEN
        IF ((IN_CONCEPTO = '1119') OR (IN_CONCEPTO = '1118')) THEN
            V_VALOR := '78';        
        END IF;    
    ELSE
        IF (V_DIAFESTIVO = 7) THEN
            IF ((IN_CONCEPTO = '1005') OR (IN_CONCEPTO = '1006') OR (IN_CONCEPTO = '1007')) THEN
                V_VALOR := '78';        
            END IF;                
        END IF;
    END IF;
    
    IF (V_FESTIVO > 0) THEN
        IF ((IN_CONCEPTO = '1005') OR (IN_CONCEPTO = '1006') OR (IN_CONCEPTO = '1007')) THEN        
            V_VALOR := '78';
        END IF;
    ELSE
        IF ((V_FESTIVO = 0) AND (V_DIAFESTIVO <> 7)) THEN
            IF ((IN_CONCEPTO = '1008') OR (IN_CONCEPTO = '1009')) THEN
                V_VALOR := '78';
            END IF;
        END IF;
    END IF;
    
    
    IF (V_VALOR = '81') THEN
        OUTPUT := '81';
        MESSAGE := 'Debes seleccionar un dia anterior al actual.';
    ELSE 
        IF (V_VALOR = '78') THEN
            OUTPUT := '78';
            MESSAGE := 'El concepto no pertenece al dia reportado.';   
        ELSE
            OUTPUT := '1';
            MESSAGE := 'OK';   
        END IF;
    END IF;          

END TW_PC_HORAS_EXTRAS;