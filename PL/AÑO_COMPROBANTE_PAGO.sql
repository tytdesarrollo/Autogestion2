create or replace PROCEDURE AÑO_COMPROBANTE_PAGO
--TABLA totales_pago PARA VERIFICAR PRIMER PERIODO DE PAGO
--44004524  Jul/2013
--33816952    ENE/2012
(
    CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE, 
    ANO_FORMU IN INTEGER, 
    PERIODO_FORMU IN VARCHAR2,
    ANIO OUT SYS_REFCURSOR,
    PERIODOS OUT SYS_REFCURSOR
    --PERIODO OUT VARCHAR2
) 
IS
v_añoActual NUMBER(5);
v_primerAño NUMBER(5);
BEGIN
    BEGIN
        IF (ANO_FORMU IS NULL) OR (PERIODO_FORMU IS NULL) THEN
            --ALMACENO EL AÑO ACTUAL MENOS 5 PARA GENERAR LOS ULTIMOS 5 COMPROBANTES
            v_añoActual := TO_NUMBER(TO_CHAR(SYSDATE,'YYYY')) - 5;
            BEGIN               
                --CUNSULTO EL AÑO DEL PRIMERO PAGO DEL EMPLEADO POR NOMINA
                SELECT TP.ANO_INI
                INTO v_primerAño
                FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                WHERE TP.COD_EPL = CODIGO_EPL 
                AND TP.COD_EPL = EB.COD_EPL 
                AND ROWNUM < 2; 
            END;
            BEGIN        
                IF v_primerAño < v_añoActual THEN 
                    --SI EL PRIMER PAGO ES MENOR A LOS ULTIMOS 5 AÑOS, SOLO GENERARA LOS ULTIMOS 5 AÑOS PARA EL COMPROBANTE.
                    OPEN ANIO FOR
                    SELECT DISTINCT(TP.ANO_INI)
                    FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                    WHERE TP.COD_EPL = CODIGO_EPL 
                    AND TP.COD_EPL = EB.COD_EPL 
                    AND TP.ANO_INI >= v_añoActual
                    ORDER BY TP.ANO_INI ASC;
                    
                    OPEN PERIODOS FOR
                    SELECT TP.ANO_INI, CASE WHEN TP.PER_INI='1' THEN 'Enero' WHEN TP.PER_INI='2' THEN 'Febrero' WHEN TP.PER_INI='3' THEN 'Marzo' 
                        WHEN TP.PER_INI='4' THEN 'Abril' WHEN TP.PER_INI='5' THEN 'Mayo' WHEN TP.PER_INI='6' THEN 'Junio' WHEN TP.PER_INI='7' THEN 'Julio' 
                        WHEN TP.PER_INI='8' THEN 'Agosto' WHEN TP.PER_INI='9' THEN 'Septiembre' WHEN TP.PER_INI='10' THEN 'Octubre'
                        WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO
                    FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                    WHERE TP.COD_EPL = CODIGO_EPL 
                    AND TP.COD_EPL = EB.COD_EPL 
                    AND TP.ANO_INI >= v_añoActual
                    ORDER BY TP.ANO_INI ASC;                    
                ELSE     
                    --SI EL PRIMER COMPROBANTE FUE MAYOR SOLO GENERARA LOS AÑOS A PARTIR DEL AÑO QUE SE LE HAYA GENERADO
                    OPEN ANIO FOR
                    SELECT DISTINCT(TP.ANO_INI)
                    FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                    WHERE TP.COD_EPL = CODIGO_EPL 
                    AND TP.COD_EPL = EB.COD_EPL                        
                    ORDER BY TP.ANO_INI ASC;            

                    OPEN PERIODOS FOR
                    SELECT TP.ANO_INI, CASE WHEN TP.PER_INI='1' THEN 'Enero' WHEN TP.PER_INI='2' THEN 'Febrero' WHEN TP.PER_INI='3' THEN 'Marzo' 
                        WHEN TP.PER_INI='4' THEN 'Abril' WHEN TP.PER_INI='5' THEN 'Mayo' WHEN TP.PER_INI='6' THEN 'Junio' WHEN TP.PER_INI='7' THEN 'Julio' 
                        WHEN TP.PER_INI='8' THEN 'Agosto' WHEN TP.PER_INI='9' THEN 'Septiembre' WHEN TP.PER_INI='10' THEN 'Octubre'
                        WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO
                    FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                    WHERE TP.COD_EPL = CODIGO_EPL 
                    AND TP.COD_EPL = EB.COD_EPL                     
                    ORDER BY TP.ANO_INI ASC;                     
                END IF;                    
            END;      
        END IF;
    END;
END AÑO_COMPROBANTE_PAGO;