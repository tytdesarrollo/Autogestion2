create or replace PROCEDURE TW_PC_COMPROBANTE_PAGO
/***********************************OBJETIVO: GENERA LOS COMPROBANTES DE PAGO*********************************************
CREADO POR       : NELSON GALEANO

-- PARAMETROS DE ENTRADA
   -- CEDULAA          : CEDULA DEL EMPLEADO
   -- ANO_FORMU        : AÑO DEL CERTIFICADO A GENERAR
   -- PERIODO_FORMU    : MES DEL CERTIFICADO A GENERAR
   
--PARAMETROS DE SALIDA   
  -- OUTPUT          SI RETORNA 0 NO SE ENCONTRARON DATOS
  -- MESSAGE         SI EL OUTPUT ES CERO ENVIA EL MENSAJE
  -- ANIO            AÑOS PARAMETRIZADO QUE EL USUARIO PODRA GENERAR SEGUN SU PRIMER PAGO (TOTALES_PAGO)
  -- PERIODOS        MUESTRA A PARTIR DEL PRIMER MES APAREZCA EN LA TABLA (TOTALES_PAGO)
   
   _*  SEPARADOR DE VARIABLES
************************************  DECLARACION DE VARIABLE  ************************************************************ */
(
    CEDULAA         IN EMPLEADOS_BASIC.CEDULA%TYPE, 
    ANO_FORMU       IN INTEGER, 
    PERIODO_FORMU   IN VARCHAR2, 
    OUTPUT          OUT VARCHAR2,
    MESSAGE         OUT VARCHAR2,
    ANIO            OUT SYS_REFCURSOR,
    PERIODOS        OUT SYS_REFCURSOR,
    BLOQUE1         OUT VARCHAR2, 
    BLOQUE2         OUT VARCHAR2, 
    BLOQUE3         OUT SYS_REFCURSOR, 
    BLOQUE4         OUT VARCHAR2, 
    BLOQUE5         OUT SYS_REFCURSOR, 
    BLOQUE6         OUT VARCHAR2    
) 
IS
CODIGO_EPL                EMPLEADOS_BASIC.COD_EPL%TYPE;  
NOM_EMPRESA               EMPRESAS.NOM_EMP%TYPE;
NIT_EMPRESA               VARCHAR2(50);  
ENCABEZADO1               VARCHAR2(50);
ENCABEZADO2               VARCHAR2(50);  
ENCABEZADO3               VARCHAR2(50);
PER_LIQUIDADO             VARCHAR2(50); 
V_CEDULA                  EMPLEADOS_BASIC.CEDULA%TYPE;
NOMBRES                   EMPLEADOS_BASIC.NOM_EPL%TYPE;
APELLIDOS                 EMPLEADOS_BASIC.APE_EPL%TYPE;
CARGO                     CARGOS.NOM_CAR%TYPE;
AREA                      CENTROCOSTO2.NOM_CC2%TYPE;
CONTRATO                  CONTRATOS.NOM_CTO%TYPE;
RETENCION                 VARCHAR2(50);
SALARIO                   DET_COMPRO.SALBAS%TYPE;
CODCON1                   VARCHAR2(50); -- CODIGO CONCEPTO "DEVENGO"
NOMCON1                   VARCHAR2(50); -- NOMBRE CONCEPTO "DEVENGO"
CAN1                      VARCHAR2(50); -- CANTIDAD "DEVENGO"
VAL1                      DET_COMPRO.VAL1%TYPE; -- VALOR "DEVENGO"
VTotalDevengos            DET_COMPRO.VAL1%TYPE;
VTotalDeducciones         DET_COMPRO.VAL2%TYPE;
NOM_BAN                   DET_COMPRO.NOM_BAN%TYPE; -- NOMBRE BANCO
NUM_CTA                   TOTALES_PAGO.NUM_CTA%TYPE; -- NUMERO CUENTA
CONSIGNA                  DET_COMPRO.CONSIGNA%TYPE; -- CONSIGNACION
CODCON2                   VARCHAR2(50); -- CODIGO CONCEPTO "DEDUCCIONES"
NOMCON2                   VARCHAR2(50); -- NOMBRE CONCEPTO "DEDUCCIONES"
VAL2                      DET_COMPRO.VAL2%TYPE; --VALOR "DEDUCCIONES"
SALDO                     DET_COMPRO.CAMPO5%TYPE;  -- SALDO "DEDUCCIONES"
NETO_PAGAR                INTEGER;
EXCEPCION                 VARCHAR(20);  
MODALIDAD                 INTEGER;
MODALIDAD_SAL             VARCHAR2(25);  
-- VARIABLES PARA GENERAR LOS AÑOS Y PERIODOS DEL USUARIO.
v_añoActual NUMBER(5);
v_primerAño NUMBER(5);

    CURSOR c_deducciones -- CURSOR PARA CALCULAR TOTAL DE DEDUCCIONES ------ BLOQUE 5
    IS
    SELECT h.val2 FROM det_compro h, TOTALES_PAGO T, cuotas c, 
    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl=(SELECT COD_EPL FROM EMPLEADOS_BASIC WHERE CEDULA = CEDULAA
    AND ESTADO ='A' AND x.cod_epl=EMPLEADOS_BASIC.cod_epl) and x.numerocomp in 
    (select num_com from totales_pago where ano_ini=ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin=PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
    and x.cod_epl=((SELECT COD_EPL FROM EMPLEADOS_BASIC WHERE CEDULA = CEDULAA AND ESTADO ='A' AND x.cod_epl=EMPLEADOS_BASIC.cod_epl))) group by cod_epl, numerocomp)b
    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null) 
    GROUP BY h.cod_epl, h.ape_epl,h.nom_epl,h.cedula,h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.nom_sucur,h.consigna,h.numerocomp,
    h.n_dia_ini,h.n_dia_fin,h.n_mes,h.codcon1,h.nomcon1,h.can1, h.val1,h.codcon2,h.nomcon2,h.can2,h.val2, h.codemp,h.coddep,h.codcc2,h.nomcc2,
    h.nomcar,h.salbas, h.direpl,h.ubiepl,h.pagina,h.nomcc,h.campo1,h.cnsctvo,h.ciu_tra ,h.nom_ciu_tra,h.codcc,h.nomcc, h.codcar,h.campo5 , T.TIP_CTA order by h.codcon2;                
BEGIN
    BEGIN         
        --SE TRABAJA CON EL CODIGO DEL EMPLEADO (CODIGO_EPL) CUANDO EL ESTADO ES ACTIVO PARA TODAS LAS CONSULTAS
        SELECT EB.COD_EPL 
        INTO CODIGO_EPL
        FROM EMPLEADOS_BASIC EB
        WHERE EB.CEDULA = CEDULAA
        AND EB.ESTADO ='A';        
        
        --CUNSULTO EL AÑO DEL PRIMER PAGO DEL EMPLEADO POR NOMINA
        SELECT TP.ANO_INI
        INTO v_primerAño
        FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
        WHERE TP.COD_EPL = CODIGO_EPL 
        AND TP.COD_EPL = EB.COD_EPL 
        AND ROWNUM < 2; 
        
        --ALMACENO EL AÑO ACTUAL MENOS 5 PARA GENERAR LOS ULTIMOS 5 COMPROBANTES
        v_añoActual := TO_NUMBER(TO_CHAR(SYSDATE,'YYYY')) - 5;        
    END;
    IF (ANO_FORMU IS NULL) OR (ANO_FORMU = '0') OR (PERIODO_FORMU IS NULL) OR (PERIODO_FORMU ='0') THEN
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
                    WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO, TP.PER_INI AS NUM_PER
                FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                WHERE TP.COD_EPL = CODIGO_EPL 
                AND TP.COD_EPL = EB.COD_EPL 
                AND TP.ANO_INI >= v_añoActual
                ORDER BY TP.ANO_INI ASC;          
                
                --SE HACE CUALUIER CONSULTA PARA NO ENVIAR EL CURSOR C_BLOQUE1 VACIO POR QUE GENERA ERROR EN LA APLICACION
                OPEN BLOQUE3 FOR
                SELECT 1,2,3,4,5,6 FROM DUAL;
                
                OPEN BLOQUE5 FOR
                SELECT 1,2,3,4,5,6 FROM DUAL;            

                OUTPUT := 'OK';          
                MESSAGE := 'OK';                       
                BLOQUE1 := 'OK';                   
                BLOQUE2 := 'OK';
                BLOQUE4 := 'OK';
                BLOQUE6 := 'OK';                                  
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
                    WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO, TP.PER_INI AS NUM_PER
                FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                WHERE TP.COD_EPL = CODIGO_EPL 
                AND TP.COD_EPL = EB.COD_EPL                     
                ORDER BY TP.ANO_INI ASC;     
                
                --SE HACE CUALQUIER CONSULTA PARA NO ENVIAR EL CURSOR C_BLOQUE1 VACIO POR QUE GENERA ERROR EN LA APLICACION
                OPEN BLOQUE3 FOR
                SELECT 1,2,3,4,5,6 FROM DUAL;
                
                OPEN BLOQUE5 FOR
                SELECT 1,2,3,4,5,6 FROM DUAL;
                
                OUTPUT := 'OK';          
                MESSAGE := 'OK';                       
                BLOQUE1 := 'OK';                   
                BLOQUE2 := 'OK';
                BLOQUE4 := 'OK';
                BLOQUE6 := 'OK';                  
            END IF;                    
        END;    
    ELSE
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
                    WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO, TP.PER_INI AS NUM_PER
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
                    WHEN TP.PER_INI='11' THEN 'Noviembre' WHEN TP.PER_INI='12' THEN 'Diciembre' END AS PERIODO, TP.PER_INI AS NUM_PER
                FROM EMPLEADOS_BASIC EB, TOTALES_PAGO TP  
                WHERE TP.COD_EPL = CODIGO_EPL 
                AND TP.COD_EPL = EB.COD_EPL                     
                ORDER BY TP.ANO_INI ASC;                     
            END IF;                    
        END;    
        
        BEGIN
            --ENCABEZADO Y TITULOS DEL COMPROBANTE DE PAGO
            BEGIN
                SELECT P.NOM_EMP, P.NIT_EMP||'-'||P.DIGITO_VER 
                INTO NOM_EMPRESA, NIT_EMPRESA
                FROM EMPLEADOS_BASIC E, EMPRESAS P 
                WHERE E.COD_EMP=P.COD_EMP 
                AND E.COD_EPL=CODIGO_EPL
                AND E.ESTADO='A';
            END;                 
            ENCABEZADO1 := 'COMPROBANTE ELECTRONICO DE PAGO';
            ENCABEZADO2 := 'CSC SERVICIOS ECONOMICOS';
            ENCABEZADO3 := 'JEFATURA DE NOMINA';                  
            BEGIN            
                SELECT (TO_CHAR(B.FEC_INI,'DD-MM-YYYY')||' - '|| TO_CHAR(B.FEC_FIN,'DD-MM-YYYY')) 
                INTO PER_LIQUIDADO
                FROM TOTALES_PAGO A, EMPLEADOS_BASIC E, PERIODOS B
                WHERE A.COD_EPL=CODIGO_EPL
                AND A.COD_EPL = E.COD_EPL
                AND E.TIP_PAGO = B.TIP_PER
                AND A.ANO_INI = B.ANO
                AND A.PER_INI = B.COD_PER
                AND B.ANO = ANO_FORMU
                AND B.COD_PER = PERIODO_FORMU;
            EXCEPTION WHEN NO_DATA_FOUND THEN
                    EXCEPCION :='0';     
                    OUTPUT := '0';
                    MESSAGE := 'No hay datos para el año y periodo solicitado.';                
            END;                                                
            BLOQUE1 := (NOM_EMPRESA||'_*'||NIT_EMPRESA||'_*'||ENCABEZADO1||'_*'||ENCABEZADO2||'_*'||ENCABEZADO3||'_*'||PER_LIQUIDADO);     
        END;
        /* -------------------------------------------------------------------------------------------------------------------
        ================================================== BLOQUE 2 ==========================================================                                                                                                                                    
        ----------------------------------------------------------------------------------------------------------------------*/
        BEGIN
            --INFORMACION DEL EMPLEADO (CODIGO, NOMBRES, APELLIDOS, SALARIO, CARGO, AREA, TIPO CONTRATO)
            SELECT COUNT(*) INTO MODALIDAD
            FROM epl_grupos WHERE cod_gru IN(3,5) 
            AND cod_epl = CODIGO_EPL;   
            
            IF (MODALIDAD <= 0) THEN
                MODALIDAD_SAL := 'SALARIO';
            ELSE
                MODALIDAD_SAL := 'APOYO DE SOSTENIMIENTO';
            END IF;
            
            BEGIN    
                SELECT B.CEDULA, B.NOM_EPL, B.APE_EPL, CAR.NOM_CAR, CE.NOM_CC2, CONT.NOM_CTO, B.RTE_FTE 
                INTO V_CEDULA, NOMBRES, APELLIDOS, CARGO, AREA, CONTRATO, RETENCION 
                FROM EMPLEADOS_BASIC B, CARGOS CAR, CENTROCOSTO2 CE, CONTRATOS CONT
                WHERE B.COD_EPL=CODIGO_EPL AND B.COD_CAR=CAR.COD_CAR AND B.COD_CC2=CE.COD_CC2 AND B.COD_CTO=CONT.COD_CTO;            
                 IF RETENCION IS NOT NULL THEN   
                    RETENCION := (RETENCION||'%');
                 END IF;                                 
            END;                        
            BEGIN
                select H.SALBAS INTO SALARIO from det_compro h, 
                (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl = CODIGO_EPL
                and x.numerocomp in (select num_com from totales_pago 
                           where ano_ini = ANO_FORMU
                           and liq_ini in ('2','3','5','6','7','8','9','11','14') 
                           and per_fin = PERIODO_FORMU
                           and x.cod_epl=totales_pago.cod_epl   
                           and x.cod_epl =CODIGO_EPL)
                group by cod_epl, numerocomp)b
                where H.COD_EPL=CODIGO_EPL AND rownum <=1
                and B.numerocomp=H.NUMEROCOMP
                group by H.SALBAS;     
            EXCEPTION WHEN NO_DATA_FOUND THEN
                    EXCEPCION :='0';     
                    OUTPUT := '0';
                    MESSAGE := 'No hay datos para el año y periodo solicitado.';
            END;        
            BLOQUE2 := (V_CEDULA||'_*'||APELLIDOS||'_*'||NOMBRES||'_*'||'$ '||TO_CHAR(SALARIO, 'FM99G999G999')||'_*'||CARGO||'_*'||AREA||'_*'||CONTRATO||'_*'||RETENCION||'_*'||MODALIDAD_SAL);
        END;  
        /* -------------------------------------------------------------------------------------------------------------------
        ================================================== BLOQUE 3 ==========================================================                                                                                                                                    
        ----------------------------------------------------------------------------------------------------------------------*/
        IF EXCEPCION IS NULL THEN
            OUTPUT := '1';
            BEGIN        
                BEGIN        
                    -- DEVENGOS
                    OPEN BLOQUE3 FOR
                    SELECT h.codcon1 AS COD_CON1,REPLACE(REPLACE(h.nomcon1,'<','MENOR A'),'>','MAYOR A') AS NOM_CON1,TO_CHAR('$ '||to_char(h.val1,'FM99G999G999')) AS VALOR1,h.can1 AS CANT1
                    FROM det_compro h, TOTALES_PAGO T, cuotas c,  
                    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl =CODIGO_EPL  and   x.numerocomp in 
                        (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
                            and x.cod_epl =CODIGO_EPL) group by cod_epl, numerocomp)b
                    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
                    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null) and h.nomcon1 is not null and h.val1 is not null and h.can1 is not null
                    GROUP BY h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.codcon1,h.nomcon1,h.can1, h.val1 order by h.codcon1;       
                END;      
                BEGIN 
                    --CALCULO TOTAL DE LOS DEVENGOS
                    SELECT SUM(h.val1) INTO VTotalDevengos
                    FROM det_compro h, TOTALES_PAGO T, cuotas c, 
                    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl =CODIGO_EPL  and   x.numerocomp in 
                    (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
                    and x.cod_epl =CODIGO_EPL) group by cod_epl, numerocomp)b
                    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
                    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null);        
                END;
            END;
            /* -------------------------------------------------------------------------------------------------------------------
            ================================================== BLOQUE 4 ==========================================================                                                                                                                                    
            ----------------------------------------------------------------------------------------------------------------------*/
            BEGIN
                --SE ENVIA EL TOTAL DEVENGOS, BANCO Y NUMERO DE CUENTA
                BEGIN
                    SELECT h.nom_ban,case when t.cod_ban=13 then substr (t.cod_suc, 1, 3)||t.num_cta else t.num_cta end, h.consigna 
                    INTO NOM_BAN, NUM_CTA, CONSIGNA
                    FROM det_compro h, TOTALES_PAGO T, cuotas c, 
                    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl = CODIGO_EPL  and   x.numerocomp in 
                        (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl and x.cod_epl = CODIGO_EPL) 
                        group by cod_epl, numerocomp)b WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 
                        and h.cod_epl = c.cod_epl(+) and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null)  AND  rownum <=1 GROUP BY h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.codcon1,h.nomcon1,
                        h.can1, h.val1,h.consigna order by h.codcon1;         
                END;
                BLOQUE4 :=('$ '||TO_CHAR(VTotalDevengos, 'FM99G999G999')||'_*'||CONSIGNA||' '||NOM_BAN||' # '||NUM_CTA);
            END;
            /* -------------------------------------------------------------------------------------------------------------------
            ================================================== BLOQUE 5 ==========================================================                                                                                                                                    
            ----------------------------------------------------------------------------------------------------------------------*/
            BEGIN
                BEGIN        
                    --DEDUCCIONES
                    OPEN BLOQUE5 FOR
                    SELECT h.codcon2 AS CODCON2,h.nomcon2 AS NOMCON2,CASE WHEN (H.VAL2) IS NULL THEN null ELSE TO_CHAR('$ '||to_char(h.val2,'FM99G999G999')) END AS VALOR2,
                    CASE WHEN h.campo5 IS NULL THEN ' ' ELSE TO_CHAR('$ '||to_char(h.campo5,'FM99G999G999')) END AS SALDO2 
                    FROM det_compro h, TOTALES_PAGO T, cuotas c, 
                    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl = CODIGO_EPL  and   x.numerocomp in 
                        (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
                        and x.cod_epl = CODIGO_EPL) group by cod_epl, numerocomp)b
                    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
                    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null) GROUP BY h.cod_epl, h.ape_epl,h.nom_epl,h.cedula,h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.nom_sucur,
                    h.consigna,h.numerocomp,
                    h.n_dia_ini,h.n_dia_fin,h.n_mes,h.codcon1,h.nomcon1,h.can1, h.val1,h.codcon2,h.nomcon2,h.can2,h.val2, h.codemp,h.coddep,h.codcc2,h.nomcc2,h.nomcar,h.salbas, h.direpl,h.ubiepl,h.pagina,h.nomcc,h.campo1,
                    h.cnsctvo,h.ciu_tra ,h.nom_ciu_tra,h.codcc,h.nomcc, h.codcar,h.campo5 , T.TIP_CTA order by h.codcon2;           
                END;      
                BEGIN         
                    --CALCULO TOTAL DEDUCCIONES
                    VTotalDeducciones := 0;
                    For RegDeducciones IN c_deducciones            
                    Loop
                        VAL2 := RegDeducciones.VAL2;
                         EXIT WHEN VAL2 IS NULL;
                         VTotalDeducciones := VTotalDeducciones + RegDeducciones.VAL2;                
                    End Loop;           
                END;          
            END;
            /* -------------------------------------------------------------------------------------------------------------------
            ================================================== BLOQUE 6 ==========================================================                                                                                                                                    
            ----------------------------------------------------------------------------------------------------------------------*/
            BEGIN    
                --ENVIO TOTAL DEDUCCIONES Y NETO A PAGAR
                NETO_PAGAR := (VTotalDevengos - VTotalDeducciones);
                BLOQUE6 := ('$ '||TO_CHAR(VTotalDeducciones, 'FM99G999G999')||'_*'||'$ '||TO_CHAR(NETO_PAGAR, 'FM99G999G999'));
            END;  
        ELSE        
        BLOQUE1 := '';
        BLOQUE2 := '';        
        END IF;
    END IF;
END TW_PC_COMPROBANTE_PAGO;