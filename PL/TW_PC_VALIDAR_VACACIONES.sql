CREATE OR REPLACE PROCEDURE TW_PC_VALIDAR_VACACIONES
/******************************************************************************
    CREATE BY NELSON GALEANO
    Procedimiento para validar que la fecha y la cantidad de dias solicitados por el empleado sea correcta.
    
   NOTES:
    VARIABLES DE ENTRADA    
        e_fecInicial         Fecha inicial 
        e_dias               Cantidad de dias solicitados
        e_codigo_epl         Codigo del empleado
        
    VARIABLES DE SALIDA
        OUTPUT          Numero de la salida
        MESSAGE         Mensaje de ayuda de salida o errror que son los siguientes   
    
        1 = No puedes iniciar las vacaciones en este dia, debes iniciar en dia habil
        2 = Debes elegir una fecha mayor a la actual
        4 = Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique
        5 = La cantidad de dias solicitados excede sus dias disponibles.
        
        Si no devuelve ninguna de las opciones anteriores la fecha y dias solicitados son validos.
******************************************************************************/
(
    e_codigo_epl IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    e_fecInicial IN VARCHAR2,
    e_dias IN NUMBER,
    OUTPUT OUT VARCHAR2,
    MESSAGE OUT VARCHAR2
) 
IS
COD_CON         NUMBER(2); -- Variable para controlar que fecha solicitada no se encuentre dentro del rango con un solo dia
FEC_INI         NUMBER(2); -- Variable para controlar que la fecha solicitada no este registrada anteriormente.
DIAS            NUMBER(4); -- Variable para controlar que la cantidad de dias no exceda el limite.
FEC_FER         NUMBER(1); -- Variable para fechas dias festivos
v_cod_con       NUMBER(5); -- Codigo concepto 1017 
v_cod_aus       NUMBER(5); -- Codigo Ausencia 1
sumatotaldiasA  NUMBER(4); -- Cantidad dias disponibles mas solicitados
sumatotaldiasB  NUMBER(4); -- Cantidad Dias periodos pendientes
v_diaFestivo    NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)
v_fds           NUMBER(1); -- Variable para controlar FDS
v_cantDias      NUMBER(3); -- Cantidad dias solicitados - 1. 
v_bandera       NUMBER(2);
v_festivos      NUMBER(1); -- Controla si la fecha es un dia festivo. 1 es Festivo y 0 no es dias festivo
v_fechaFestivo  VARCHAR2(30);
v_startDate     DATE;
v_acu_vaca      DATE; -- VARIABLE QUE RETORNA LA FECHA FINAL.
v_fecFDS        NUMBER(3); -- Controla si la fecha es un dia festivo. 1 es Festivo y 0 no es dias festivo
v_formFecha    VARCHAR2(11);

BEGIN
    v_cod_con := 1017;
    v_cod_aus := 1;
    v_formFecha := 'YYYY-MM-DD';
    BEGIN
        --Query para verificar que la fecha solicitada no se encuentre registrada dentro  del rango con un solo dia        
        SELECT COUNT(COD_CON) 
        INTO COD_CON
        FROM ausencias_tmp
        WHERE cod_con=v_cod_con and cod_aus=v_cod_aus and estado in ('P','C') and cod_epl=e_codigo_epl
        and (to_date(e_fecInicial,v_formFecha) between fec_ini and fec_fin or
        to_date(e_fecInicial,v_formFecha) between fec_ini and fec_fin);

        --Query para verificar que la fecha solicitada no se encuentre registrada inicialmente        
        select COUNT(fec_ini)        
        INTO FEC_INI 
        from ausencias_tmp 
        where fec_ini = to_date(e_fecInicial,v_formFecha) 
        and estado in ('P','C') 
        and cod_epl=e_codigo_epl;
        
        --VALIDAMOS LA CANTIDAD DE DIAS SOLICITADOS NO EXCEDA EL LIMITE         
        select SUM(DIAS) 
        INTO DIAS
        FROM ausencias_tmp 
        where cod_con= v_cod_con 
        and cod_aus= v_cod_aus 
        and estado = 'P'
        and cod_epl= e_codigo_epl;
        
        sumatotaldiasA := e_dias + DIAS;
        
        --PERIODOS PENDIENTES
        SELECT SUM(DIAS)
        INTO sumatotaldiasB
        FROM VACACIONES_PENDIENTES 
        WHERE COD_EPL = e_codigo_epl;        
                
        IF (COD_CON > 0) OR (FEC_INI > 0) THEN
            --SI LA FECHA SE ENCUENTRA DENTRO DE UN RANGO SOLICITADO ANTERIORMENTE
            OUTPUT := 4;
            MESSAGE :='Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique.'; 
        ELSE
            IF (sumatotaldiasB < sumatotaldiasA) THEN
                --CANTIDAD DE DIAS SOLICITADOS EXCEDE LOS DISPONIBLES
                OUTPUT := 5;         
                MESSAGE :='La cantidad de dias solicitados excede sus dias disponibles.';   
            ELSE
                --VALIDA QUE LA FECHA NO SEA UN DIA FESTIVO
                SELECT COUNT(FEC_FER)
                INTO FEC_FER
                FROM feriados WHERE FEC_FER=to_date(e_fecInicial,v_formFecha);
                
                --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
                v_diaFestivo := TO_CHAR(TO_DATE(e_fecInicial,v_formFecha),'D');
                
                IF (v_diaFestivo=6) OR (v_diaFestivo=7) THEN
                    --SI ES UN DIA FESTIVO O SI ES UN SABADO O DOMINGO
                    v_fds := 2;
                END IF;
                
                --IF (TO_DATE(e_fecInicial,'YYYY-MM-DD') > SYSDATE) THEN                              
                    IF (FEC_FER > 0) OR (v_fds = 2) THEN
                        --NO ES UN DIA HABIL, NO SE SOLICITAN LAS VACACIONES
                        OUTPUT := 1;   
                        MESSAGE :='No puedes iniciar las vacaciones en este dia, debes iniciar en dia habil.';      
                    ELSE
                        IF (e_dias = 1) THEN
                            OUTPUT := e_fecInicial;
                            MESSAGE :='Fecha solicitada es valida.';        
                        ELSE
                            v_cantDias := e_dias-1;
                            v_bandera := 0;
                            v_startDate := (TO_DATE(e_fecInicial,v_formFecha));
                            v_fechaFestivo := v_startDate;  
                            FEC_FER := '0';     
                            
                            WHILE v_cantDias > 0 LOOP
                                v_cantDias := v_cantDias - 1;  
                                
                                IF (v_bandera = 0) THEN
                                    --Consulto que no haya festivos
                                    SELECT COUNT(FEC_FER)
                                    INTO FEC_FER
                                    FROM feriados WHERE FEC_FER=v_fechaFestivo;
                                    
                                    IF (FEC_FER > 0) THEN
                                        v_festivos := 1;
                                    ELSE
                                        v_festivos := 0;
                                    END IF;         
                                    --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
                                    v_fecFDS := TO_CHAR(v_startDate,'D');
                                    
                                    IF (v_fecFDS=6) OR (v_fecFDS=7) OR (v_festivos=1) THEN
                                        v_startDate := v_startDate + 1;
                                        v_fechaFestivo := v_startDate;
                                        v_cantDias := v_cantDias + 1;
                                    ELSE
                                        v_startDate := v_startDate + 1;
                                        v_fechaFestivo := v_startDate;        
                                        v_acu_vaca := v_startDate;
                                    END IF;                                     
                                END IF; 
                                
                                IF (v_cantDias=0) THEN
                                    v_bandera := 1;
                                    FEC_FER := 0;
                                    --Consulto que no haya festivos
                                    SELECT COUNT(FEC_FER)
                                    INTO FEC_FER
                                    FROM feriados WHERE FEC_FER=v_acu_vaca;     
                                        
                                   IF (FEC_FER > 0) THEN
                                        v_festivos := 1;
                                    ELSE
                                        v_festivos := 0;
                                    END IF; 
                                    --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)
                                    v_fecFDS := TO_CHAR(v_acu_vaca,'D');
                                    
                                    IF (v_fecFDS=6) OR (v_fecFDS=7) OR (v_festivos=1) THEN
                                        v_acu_vaca := v_acu_vaca+1;
                                        v_cantDias := v_cantDias+1;
                                    END IF; 
                                END IF; 
                            END LOOP;  
                            
                            COD_CON := 0;
                            SELECT COUNT(COD_CON) 
                            INTO COD_CON
                            FROM ausencias_tmp
                            WHERE cod_con=v_cod_con and cod_aus=v_cod_aus and estado in ('P','C') and cod_epl=e_codigo_epl
                            and (to_date(e_fecInicial,v_formFecha) between fec_ini 
                            and fec_fin or v_acu_vaca between fec_ini and fec_fin); 
                            
                            IF (COD_CON >0) THEN
                                OUTPUT := 4;
                                MESSAGE :='Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique';        
                            ELSE    
                                OUTPUT := v_acu_vaca;   
                                MESSAGE :='Fecha solicitada es valida.';            
                            END IF;                            
                        END IF;
                    END IF;
                --ELSE
                    -- SI LA FECHA INGRESADA ES MENOR A LA FECHA ACTUAL
                  --  OUTPUT := 2;
                --END IF;         
            END IF;        
        END IF;
    END;
END TW_PC_VALIDAR_VACACIONES;