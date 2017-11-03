CREATE OR REPLACE PROCEDURE TW_PC_VALIDA_VACACIONES2
/******************************************************************************
    CREATE BY NELSON GALEANO
    Procedimiento para validar que la fecha y la cantidad de dias solicitados por el empleado sea correcta.
    
   NOTES:
    VARIABLES DE ENTRADA    
        IN_FEC_INI          FECHA INICIAL
		IN_FEC_FIN			FECHA FINAL
        IN_CODIGO_EPL       Codigo del empleado
        
    VARIABLES DE SALIDA
        OUTPUT          Numero de la salida
        MESSAGE         Mensaje de ayuda de salida o errror que son los siguientes   
    
        1 = No puedes iniciar las vacaciones en este dia, debes iniciar en dia habil
        2 = Debes elegir una fecha mayor a la actual
        3 = La fecha final debe ser mayor a la fecha inicial
        4 = Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique
        
        Si no devuelve ninguna de las opciones anteriores la fecha y dias solicitados son validos.
******************************************************************************/
(
    IN_CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    IN_FEC_INI IN VARCHAR2,
	IN_FEC_FIN IN VARCHAR2,
    OUTPUT OUT VARCHAR2,
    MESSAGE OUT VARCHAR2
) 
IS
V_COD_CON       NUMBER(2); -- Variable para controlar que fecha solicitada no se encuentre dentro del rango con un solo dia
V_FEC_INI       NUMBER(2); -- Variable para controlar que la fecha solicitada no este registrada anteriormente.
V_DIAS          NUMBER(4); -- Variable para controlar que la cantidad de dias no exceda el limite.
V_FEC_FER       NUMBER(1); -- Variable para fechas dias festivos
V_CONCEPTO      NUMBER(5); -- Codigo concepto 1017 
V_COD_AUSEN     NUMBER(5); -- Codigo Ausencia 1
sumatotaldiasB  NUMBER(4); -- Cantidad Dias periodos pendientes
v_diaFestivo    NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)
v_fds           NUMBER(1); -- Variable para controlar FDS
v_formFecha     VARCHAR2(11);
V_CONTROL		VARCHAR(2);

BEGIN
    V_CONCEPTO := 1017;
    V_COD_AUSEN := 1;
    v_formFecha := 'YYYY-MM-DD';
    BEGIN
        --Query para verificar que la fecha solicitada no se encuentre registrada dentro  del rango con un solo dia        
        SELECT COUNT(COD_CON) 
        INTO V_COD_CON
        FROM ausencias_tmp
        WHERE cod_con=V_CONCEPTO and cod_aus=V_COD_AUSEN and estado in ('P','C') and cod_epl=IN_CODIGO_EPL
        and (to_date(IN_FEC_INI,v_formFecha) between fec_ini and fec_fin or
        to_date(IN_FEC_INI,v_formFecha) between fec_ini and fec_fin);

        --Query para verificar que la fecha solicitada no se encuentre registrada inicialmente        
        select COUNT(fec_ini)        
        INTO V_FEC_INI 
        from ausencias_tmp 
        where fec_ini = to_date(IN_FEC_INI,v_formFecha) 
        and estado in ('P','C') 
        and cod_epl=IN_CODIGO_EPL;
        
        --VALIDAMOS LA CANTIDAD DE DIAS SOLICITADOS NO EXCEDA EL LIMITE         
        select SUM(DIAS) 
        INTO V_DIAS
        FROM ausencias_tmp 
        where cod_con= V_CONCEPTO 
        and cod_aus= V_COD_AUSEN 
        and estado = 'P'
        and cod_epl= IN_CODIGO_EPL;
        
        --PERIODOS PENDIENTES
		--CALCULO LA CANTIDAD DE DIAS TOTALES QUE TIENE PENDIENTE POR DISFRUTAR
        SELECT SUM(DIAS)
        INTO sumatotaldiasB
        FROM VACACIONES_PENDIENTES 
        WHERE COD_EPL = IN_CODIGO_EPL;        
        
        IF (IN_FEC_FIN < IN_FEC_INI)  THEN
			OUTPUT := 3;
            MESSAGE :='La fecha final debe ser mayor a la fecha inicial.'; 
		ELSE			
			IF (V_COD_CON > 0) OR (V_FEC_INI > 0) THEN
				--SI LA FECHA SE ENCUENTRA DENTRO DE UN RANGO SOLICITADO ANTERIORMENTE
				OUTPUT := 4;
				MESSAGE :='Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique.'; 
			ELSE
				--VALIDA QUE LA FECHA NO SEA UN DIA FESTIVO
				SELECT COUNT(FEC_FER)
				INTO V_FEC_FER
				FROM feriados WHERE FEC_FER=to_date(IN_FEC_INI,v_formFecha);
				
				--OBTIENE EL NUMERO DEL DIA EN LA SEMANA.  6 Y 7 = (SABADO Y DOMINGO)
				v_diaFestivo := TO_CHAR(TO_DATE(IN_FEC_INI,v_formFecha),'D');
				
				IF (v_diaFestivo=6) OR (v_diaFestivo=7) THEN
					--SI ES UN DIA FESTIVO O SI ES UN SABADO O DOMINGO
					v_fds := 2;
				END IF;
				
				--IF (TO_DATE(IN_FEC_INI,'YYYY-MM-DD') > SYSDATE) THEN -- FECHA INICIAL MAYOR A LA FECHA ACTUAL                              
					IF (V_FEC_FER > 0) OR (v_fds = 2) THEN
						--NO ES UN DIA HABIL, NO SE SOLICITAN LAS VACACIONES
						OUTPUT := 1;   
						MESSAGE :='No puedes iniciar las vacaciones en este dia, debes iniciar en dia habil.';      
					ELSE
						V_COD_CON := 0;
						--VALIDO QUE LA FECHA INICIAL O LA FECHA FINAL NO COINCIDA CON UNA FECHA SOLICITADA ANTERIORMENTE.
						SELECT COUNT(COD_CON) 
						INTO V_COD_CON
						FROM ausencias_tmp
						WHERE cod_con=V_CONCEPTO 
						and cod_aus=V_COD_AUSEN 
						and estado in ('P','C') 
						and cod_epl=IN_CODIGO_EPL
						and (to_date(IN_FEC_INI,v_formFecha) between fec_ini and fec_fin 
							or to_date(IN_FEC_FIN,v_formFecha) between fec_ini and fec_fin); 
						
						IF (V_COD_CON >0) THEN
							OUTPUT := 4;
							MESSAGE :='Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique';        
						ELSE    
							V_CONTROL := 'OK';   
							--MESSAGE :='Fecha solicitada es valida.... ahora a calcular la cantidad de dias';            
						END IF; 
					END IF;
				--ELSE
					/*
					-- SI LA FECHA INGRESADA ES MENOR A LA FECHA ACTUAL
					OUTPUT := 2;
					MESSAGE := 'Debes elegir una fecha mayor a la actual.';
					*/
				--END IF;                      
			END IF;     
		END IF;	
		
        --SI LAS FECHAS CUMPLEN TODOS LOS REQUISITOS SE PASA A CALCULAR LA CANTIDAD DE DIAS
		IF (V_CONTROL = 'OK') THEN
			OUTPUT := 'OK';
			MESSAGE := 'Fecha Valida';
		END IF;
    END;
END TW_PC_VALIDA_VACACIONES2;