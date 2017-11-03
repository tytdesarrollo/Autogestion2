create or replace PROCEDURE TW_PC_HORAS_EXTRAS 
/**************************************************************************************
   CREATE BY NELSON GALEANO    
   Procedimiento que retorna el hostorial de horas extras por usuario.
   NOTES:
    VARIABLES DE ENTRADA
        IN_CODIGO_EPL       CODIGO DEL EMPLEADO, PARAMETRO DE ENTRADA
        IN_FEC_INI
        IN_HORAS
        IN_COD_CON
        IN_ESTADO
        IN_COD_AUS

    VARIABLES DE SALIDA
        OUTPUT        78          MESSAGE   El concepto no pertenece al dia reportado
                      79                    El concepto no pertenece al dia reportado
                      80                    El concepto y dia ya fueron reportados anteriormente
                      81                    Debes seleccionar un dia anterior al actual
                      82                    Debes llenar todos los campos
                      10                    OK        
***************************************************************************************/
(
  IN_CODIGO_EPL   IN EMPLEADOS_BASIC.COD_EPL%TYPE,
  IN_FEC_INI      IN VARCHAR2,
  --IN_HORAS        IN VARCHAR2,
  IN_COD_CON      IN VARCHAR2,
  --IN_ESTADO       IN VARCHAR2,
  --IN_COD_AUS      IN INTEGER,
  IN_VALIDAR      IN VARCHAR2,
  OUTPUT          OUT VARCHAR2,
  MESSAGE         OUT VARCHAR2
) 
IS

V_FEC_INI       VARCHAR2(20);
V_FEC_ACTUAL    VARCHAR2(20);
V_FORMA_FEC     VARCHAR2(10);
FEC_FER         NUMBER(1); -- Variable para fechas dias festivos
v_diaFestivo    NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)

BEGIN
  
  V_FORMA_FEC := 'DD-MM-YYYY';--VARIABLE V_FORMA_FEC PARA MANIPULAR EL FORMATO DE FECHA SEGUN SEA EL FORMATO DE ENTRADA
  V_FEC_INI := TO_DATE(IN_FEC_INI,V_FORMA_FEC);
  V_FEC_ACTUAL := SYSDATE;

	IF (IN_VALIDAR = 'SI') THEN
		IF (V_FEC_INI > V_FEC_ACTUAL) THEN
		  OUTPUT := '81';
		  MESSAGE := 'Debes seleccionar un dia anterior al actual';  
		END IF;

		--VALIDA QUE LA FECHA NO SEA UN DIA FESTIVO
		SELECT COUNT(FEC_FER)
		INTO FEC_FER
		FROM FERIADOS WHERE FEC_FER = V_FEC_INI;
		
		--OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
		v_diaFestivo := TO_CHAR(V_FEC_INI,'D');
		
		IF ((FEC_FER = 0) AND (v_diaFestivo = 7)) THEN
			IF((IN_COD_CON = '1119') OR (IN_COD_CON='1118')) THEN
				OUTPUT := '78';
				MESSAGE := 'El concepto no pertenece al dia reportado';  
			END IF;
		ELSE
			IF ((v_diaFestivo = 7)) THEN
				IF ((IN_COD_CON = '1005') OR (IN_COD_CON = '1006') OR (IN_COD_CON = '1007')) THEN
					OUTPUT := '78';
					MESSAGE := 'El concepto no pertenece al dia reportado';
				END IF;
			END IF;      
		END IF;
		
		IF (FEC_FER > 0) THEN
			IF ((IN_COD_CON = '1005') OR (IN_COD_CON = '1006') OR (IN_COD_CON = '1007')) THEN
				OUTPUT := '79';
				MESSAGE := 'El concepto no pertenece al dia reportado';
			END IF;
		ELSE
			IF ((FEC_FER = 0) AND (v_diaFestivo <> 7)) THEN
				IF ((IN_COD_CON = '1009') OR (IN_COD_CON = '1008')) THEN
				  OUTPUT := '79';
				  MESSAGE := 'El concepto no pertenece al dia reportado';
				END IF;        
			END IF;
		END IF;
	END IF;    
END TW_PC_HORAS_EXTRAS;