create or replace PROCEDURE TW_PC_VALIDAR_VACACIONES
/******************************************************************************
    CREATE BY NELSON GALEANO
    Procedimiento para validar que la fecha y la cantidad de dias solicitados por el empleado sea correcta.
    
   NOTES:
    VARIABLES DE ENTRADA    
        IN_FEC_INI             Fecha inicial 
        IN_DIAS                Cantidad de dias solicitados
        IN_CODIGO_EPL          Codigo del empleado
        
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
    IN_CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE,
    IN_FEC_INI IN VARCHAR2,
    IN_DIAS IN NUMBER,
    OUTPUT OUT VARCHAR2,
    MESSAGE OUT VARCHAR2
) 
IS
V_CONCEPTO          NUMBER(2); -- Variable para controlar que fecha solicitada no se encuentre dentro del rango con un solo dia
V_FEC_INI           NUMBER(2); -- Variable para controlar que la fecha solicitada no este registrada anteriormente.
V_DIAS              NUMBER(4); -- Variable para controlar que la cantidad de dias no exceda el limite.
V_FEC_FER           NUMBER(1); -- Variable para fechas dias festivos
V_COD_CON           NUMBER(5); -- Codigo concepto 1017 
V_COD_AUS           NUMBER(5); -- Codigo Ausencia 1
sumatotaldiasA      NUMBER(4); -- Cantidad dias disponibles mas solicitados
sumatotaldiasB      NUMBER(4); -- Cantidad Dias periodos pendientes
V_DIA_FESTIVO       NUMBER(3); -- Variable que contiene numero del dia 6 Y 7 (SABADO Y DOMINGO)
V_FDS               NUMBER(1); -- Variable para controlar FDS
V_CANT_DIAS         NUMBER(3); -- Cantidad dias solicitados - 1. 
V_BANDERA           NUMBER(2);
V_FESTIVOS          NUMBER(1); -- Controla si la fecha es un dia festivo. 1 es Festivo y 0 no es dias festivo
V_FEC_FESTIVOS      VARCHAR2(30);
V_START_DATE        DATE;
V_ACU_VACA          DATE; -- VARIABLE QUE RETORNA LA FECHA FINAL.
V_FEC_FDS           NUMBER(3); -- Controla si la fecha es un dia festivo. 1 es Festivo y 0 no es dias festivo
V_FORM_FEC          VARCHAR2(11);
V_SALIDA            VARCHAR2(20);

BEGIN
    V_COD_CON := 1017;
    V_COD_AUS := 1;
    V_FORM_FEC := 'DD-MM-YYYY'; -- FORMATO QUE SE MANEJA PARA TODAS LAS FECHAS
    BEGIN
    
    --RAISE_APPLICATION_ERROR(-20001,IN_FEC_INI||' - '||IN_DIAS);
        --Query para verificar que la fecha solicitada no se encuentre registrada dentro  del rango con un solo dia        
        SELECT COUNT(COD_CON) 
        INTO V_CONCEPTO
        FROM ausencias_tmp
        WHERE cod_con = V_COD_CON 
        and cod_aus = V_COD_AUS 
        and estado in ('P','C') 
        and cod_epl = IN_CODIGO_EPL
        and (to_date(IN_FEC_INI,V_FORM_FEC) between fec_ini and fec_fin 
        or to_date(IN_FEC_INI,V_FORM_FEC) between fec_ini and fec_fin);

        --Query para verificar que la fecha solicitada no se encuentre registrada inicialmente        
        select COUNT(fec_ini)        
        INTO V_FEC_INI 
        from ausencias_tmp 
        where fec_ini = to_date(IN_FEC_INI,V_FORM_FEC) 
        and estado in ('P','C') 
        and cod_epl = IN_CODIGO_EPL;
        
        --VALIDAMOS LA CANTIDAD DE DIAS SOLICITADOS NO EXCEDA EL LIMITE         
        select SUM(DIAS) 
        INTO V_DIAS
        FROM ausencias_tmp 
        where cod_con = V_COD_CON 
        and cod_aus = V_COD_AUS 
        and estado = 'P'
        and cod_epl= IN_CODIGO_EPL;

        IF (V_DIAS IS NULL) THEN
            V_DIAS := 0;
        END IF;
        
        sumatotaldiasA := IN_DIAS + V_DIAS;
        
        --PERIODOS PENDIENTES
        SELECT SUM(DIAS)
        INTO sumatotaldiasB
        FROM VACACIONES_PENDIENTES 
        WHERE COD_EPL = IN_CODIGO_EPL;   

        IF (sumatotaldiasB IS NULL) THEN
            sumatotaldiasB := 0;
        END IF;             

        --DBMS_OUTPUT.PUT_LINE('PERIODOS PENDIENTE = ' || sumatotaldiasB||' - SUMATOTAL = '||sumatotaldiasA);        
                
        IF (V_CONCEPTO > 0) OR (V_FEC_INI > 0) THEN
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
                INTO V_FEC_FER
                FROM feriados 
                WHERE FEC_FER = to_date(IN_FEC_INI,V_FORM_FEC);
                
                --OBTIENE EL NUMERO DEL DIA EN LA SEMANA. 6 Y 7 (SABADO Y DOMINGO)                
                V_DIA_FESTIVO := FN_NUM_DIA_SEMANA(IN_FEC_INI,V_FORM_FEC);                               
                
                IF (V_DIA_FESTIVO=6) OR (V_DIA_FESTIVO=7) THEN
                    --SI ES UN DIA FESTIVO O SI ES UN SABADO O DOMINGO
                    V_FDS := 2;
                END IF;
                
                IF (TO_DATE(IN_FEC_INI,V_FORM_FEC) > SYSDATE) THEN                              
                    IF (V_FEC_FER > 0) OR (V_FDS = 2) THEN
                        --NO ES UN DIA HABIL, NO SE SOLICITAN LAS VACACIONES
                        OUTPUT := 1;   
                        MESSAGE :='No puedes iniciar las vacaciones en este dia, debes iniciar en dia habil.';      
                    ELSE
                        IF (IN_DIAS = 1) THEN
                            OUTPUT := IN_FEC_INI;
                            MESSAGE :='Fecha solicitada es valida.';        
                        ELSE
                            V_CANT_DIAS := IN_DIAS-1;
                            V_BANDERA := 0;
                            V_START_DATE := (TO_DATE(IN_FEC_INI,V_FORM_FEC));
                            V_FEC_FESTIVOS := V_START_DATE;  
                            V_FEC_FER := '0';     
        
                            
                            TW_PC_CALCULA_FECHA(IN_FEC_INI,IN_DIAS,V_SALIDA);
                            
                            V_ACU_VACA := TO_DATE(V_SALIDA,V_FORM_FEC);

                            V_CONCEPTO := 0;
                            
                            FOR I IN 0..IN_DIAS - 1
                            LOOP 
                                SELECT COUNT(COD_CON) + V_CONCEPTO
                                INTO V_CONCEPTO
                                FROM ausencias_tmp
                                WHERE cod_con = V_COD_CON 
                                and cod_aus = V_COD_AUS 
                                and estado in ('P','C') 
                                and cod_epl = IN_CODIGO_EPL
                                and ((to_date(IN_FEC_INI,V_FORM_FEC) + I) between fec_ini and fec_fin); 
                                --or V_ACU_VACA between fec_ini and fec_fin); 
                                DBMS_OUTPUT.PUT_LINE(to_date(IN_FEC_INI,V_FORM_FEC) + I);
                            END LOOP; 
                            
                            IF (V_CONCEPTO >0) THEN
                                OUTPUT := 4;
                                MESSAGE :='Su fecha de solicitud se encuentra dentro de un rango solicitado anteriormente. Por favor verifique';        
                            ELSE    
                                --OUTPUT := 'FECHA INICIAL =>'||IN_FEC_INI||' - FECHA FINAL => '||to_char(to_date(V_ACU_VACA,'DD/MM/YY'),'YYYY-MM-DD')||' - DIAS => '||IN_DIAS;
                                OUTPUT := TO_CHAR(V_ACU_VACA,'DD/MM/YYYY');   
                                MESSAGE :='Fecha solicitada es valida.';            
                            END IF;                            
                        END IF;
                    END IF;
                ELSE
                    -- SI LA FECHA INGRESADA ES MENOR A LA FECHA ACTUAL
                    OUTPUT := 2;
                    MESSAGE := 'Debes elegir una fecha mayor a la actual';
                END IF;         
            END IF;        
        END IF;
    END;
END TW_PC_VALIDAR_VACACIONES;