create or replace PROCEDURE         TW_PC_COMPROBANTE_PAGO
(
    CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE, 
    ANO_FORMU IN INTEGER, 
    PERIODO_FORMU IN VARCHAR2, 
    BLOQUE1 OUT VARCHAR2, 
    BLOQUE2 OUT VARCHAR2, 
    BLOQUE3 OUT VARCHAR2, 
    BLOQUE4 OUT VARCHAR2, 
    BLOQUE5 OUT VARCHAR2, 
    BLOQUE6 OUT VARCHAR2
) 

IS
NOM_EMPRESA                                 EMPRESAS.NOM_EMP%TYPE;
NIT_EMPRESA                                   VARCHAR2(20);  
ENCABEZADO1                                   VARCHAR2(50);
ENCABEZADO2                                   VARCHAR2(50);  
ENCABEZADO3                                   VARCHAR2(50);
PER_LIQUIDADO                                VARCHAR2(50); 
CEDULA                                            EMPLEADOS_BASIC.CEDULA%TYPE;
NOMBRES                                         EMPLEADOS_BASIC.NOM_EPL%TYPE;
APELLIDOS                                       EMPLEADOS_BASIC.APE_EPL%TYPE;
CARGO                                            CARGOS.NOM_CAR%TYPE;
AREA                                               CENTROCOSTO2.NOM_CC2%TYPE;
CONTRATO                                      CONTRATOS.NOM_CTO%TYPE;
RETENCION                                      VARCHAR2(50);
SALARIO                                          DET_COMPRO.SALBAS%TYPE;
vBloque3                                          VARCHAR2(500);  -- VARIABLE PARA EL CURSOR DE DEVENGOS
vBloque5                                          VARCHAR2(800); -- VARIABLE PARA EL CURSOR DE DEDUCCIONES 
CODCON1                                         VARCHAR2(50); -- CODIGO CONCEPTO "DEVENGO"
NOMCON1                                        VARCHAR2(50); -- NOMBRE CONCEPTO "DEVENGO"
CAN1                                               VARCHAR2(50); -- CANTIDAD "DEVENGO"
VAL1                                                DET_COMPRO.VAL1%TYPE; -- VALOR "DEVENGO"
VTotalDevengos                                DET_COMPRO.VAL1%TYPE;
VTotalDeducciones                            DET_COMPRO.VAL2%TYPE;
NOM_BAN                                         DET_COMPRO.NOM_BAN%TYPE; -- NOMBRE BANCO
NUM_CTA                                         TOTALES_PAGO.NUM_CTA%TYPE; -- NUMERO CUENTA
CONSIGNA                                        DET_COMPRO.CONSIGNA%TYPE; -- CONSIGNACION
CODCON2                                         VARCHAR2(50); -- CODIGO CONCEPTO "DEDUCCIONES"
NOMCON2                                        VARCHAR2(50); -- NOMBRE CONCEPTO "DEDUCCIONES"
VAL2                                                DET_COMPRO.VAL2%TYPE; --VALOR "DEDUCCIONES"
SALDO                                             DET_COMPRO.CAMPO5%TYPE;  -- SALDO "DEDUCCIONES"
NETO_PAGAR                                   INTEGER;

    CURSOR c_comproban -- DEVENGOS -------  BLOQUE 3
    IS
    SELECT h.nom_ban AS NOM_BAN,case when t.cod_ban=13 then substr (t.cod_suc, 1, 3)||t.num_cta else t.num_cta end AS NUM_CTA,h.codcon1 AS CODCON1,h.nomcon1 AS NOMCON1,h.can1 AS CAN1,
    h.val1 AS VAL1 FROM det_compro h, TOTALES_PAGO T, cuotas c, 
    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl =CODIGO_EPL  and   x.numerocomp in 
        (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
            and x.cod_epl =CODIGO_EPL) group by cod_epl, numerocomp)b
    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null)  GROUP BY h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.codcon1,h.nomcon1,h.can1, h.val1 order by h.codcon1;
    
    
    CURSOR c_deducciones --DEDUCCIONES ------ BLOQUE 5
    IS
    SELECT h.codcon2 AS CODCON2,h.nomcon2 AS NOMCON2,h.val2 AS VAL2, h.campo5 AS SALDO 
    FROM det_compro h, TOTALES_PAGO T, cuotas c, 
    (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo from det_compro x where x.cod_epl = CODIGO_EPL  and   x.numerocomp in 
        (select num_com from totales_pago where ano_ini =ANO_FORMU and liq_ini in ('2','3','5','6','7','8','9','11','14') and per_fin =PERIODO_FORMU and x.cod_epl=totales_pago.cod_epl 
        and x.cod_epl = CODIGO_EPL) group by cod_epl, numerocomp)b
    WHERE   h.cod_epl = b.cod_epl and h.numerocomp = b.numerocomp and h.cod_epl = t.cod_epl and h.numerocomp = t.num_com and h.cnsctvo <= b.consecutivo+50 and h.cod_epl = c.cod_epl(+)
    and h.codcon2 = c.cod_con(+) and (h.codcon1 is not null or h.codcon2 is not null) GROUP BY h.cod_epl, h.ape_epl,h.nom_epl,h.cedula,h.nom_ban, t.cod_ban, t.cod_suc, t.num_cta,h.nom_sucur,
    h.consigna,h.numerocomp,
    h.n_dia_ini,h.n_dia_fin,h.n_mes,h.codcon1,h.nomcon1,h.can1, h.val1,h.codcon2,h.nomcon2,h.can2,h.val2, h.codemp,h.coddep,h.codcc2,h.nomcc2,h.nomcar,h.salbas, h.direpl,h.ubiepl,h.pagina,h.nomcc,h.campo1,
    h.cnsctvo,h.ciu_tra ,h.nom_ciu_tra,h.codcc,h.nomcc, h.codcar,h.campo5 , T.TIP_CTA order by h.codcon2;    

BEGIN
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 1 ==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
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
        END;                                                
        BLOQUE1 := (NOM_EMPRESA||'_*'||NIT_EMPRESA||'_*'||ENCABEZADO1||'_*'||ENCABEZADO2||'_*'||ENCABEZADO3||'_*'||PER_LIQUIDADO);     
    END;
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 2 ==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
        BEGIN    
            SELECT B.CEDULA, B.NOM_EPL, B.APE_EPL, CAR.NOM_CAR, CE.NOM_CC2, CONT.NOM_CTO, B.RTE_FTE 
            INTO CEDULA, NOMBRES, APELLIDOS, CARGO, AREA, CONTRATO, RETENCION 
            FROM EMPLEADOS_BASIC B, CARGOS CAR, CENTROCOSTO2 CE, CONTRATOS CONT
            WHERE B.COD_EPL=CODIGO_EPL AND B.COD_CAR=CAR.COD_CAR AND B.COD_CC2=CE.COD_CC2 AND B.COD_CTO=CONT.COD_CTO;            
             IF RETENCION IS NOT NULL THEN   
                RETENCION := (RETENCION||'%');
             END IF;                                 
        EXCEPTION
            When no_data_found Then
            RETENCION :='0';                    
        END;            
        
        BEGIN
            select H.SALBAS INTO SALARIO from det_compro h, 
            (select x.cod_epl, x.numerocomp, min(x.cnsctvo) consecutivo
            from det_compro x
            where x.cod_epl = CODIGO_EPL
            and   x.numerocomp in (select num_com from totales_pago 
                       where ano_ini = ANO_FORMU
                       and liq_ini in ('2','3','5','6','7','8','9','11','14') 
                       and per_fin = PERIODO_FORMU
                       and x.cod_epl=totales_pago.cod_epl   
                       and x.cod_epl =CODIGO_EPL)
            group by cod_epl, numerocomp)b
            where H.COD_EPL=CODIGO_EPL 
            AND  rownum <=1
            and B.numerocomp=H.NUMEROCOMP
            group by H.SALBAS;        
        END;        
        BLOQUE2 := (CEDULA||'_*'||APELLIDOS||'_*'||NOMBRES||'_*'||'$ '||TO_CHAR(SALARIO, 'FM99G999G999')||'_*'||CARGO||'_*'||AREA||'_*'||CONTRATO||'_*'||RETENCION);
    END;  
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 3 ==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
        BEGIN        
            vBloque3 := ' ';
            VTotalDevengos := 0;
            For RegDevengos IN c_comproban            
            Loop
                CODCON1 := RegDevengos.CODCON1;
                NOMCON1 := RegDevengos.NOMCON1;
                CAN1 := RegDevengos.CAN1;               
                VAL1 := RegDevengos.VAL1;
                 EXIT WHEN CODCON1 IS NULL;
                 VTotalDevengos := VTotalDevengos + RegDevengos.VAL1;
                vBloque3 := vBloque3 || CODCON1||'_*'||NOMCON1||'_*'||VAL1||'_*'||CAN1||'_*';                
            End Loop;           
        END;      
        BLOQUE3 := (vBloque3);
    END;
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 4==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/    
    BEGIN
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
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 5 ==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
        BEGIN        
            vBloque5 := ' ';
            VTotalDeducciones := 0;
            For RegDeducciones IN c_deducciones            
            Loop
                CODCON2 := RegDeducciones.CODCON2;
                NOMCON2 := RegDeducciones.NOMCON2;
                SALDO := RegDeducciones.SALDO;               
                VAL2 := RegDeducciones.VAL2;
                 EXIT WHEN CODCON2 IS NULL;
                 VTotalDeducciones := VTotalDeducciones + RegDeducciones.VAL2;
                vBloque5 := vBloque5 || CODCON2||'_*'||NOMCON2||'_*'||VAL2||'_*'||SALDO||'_*';                
            End Loop;           
        END;      
        BLOQUE5 := (vBloque5);
    END;
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 6==================================================================                                                                                                                                    
    ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/        
    BEGIN    
        NETO_PAGAR := (VTotalDevengos - VTotalDeducciones);
        BLOQUE6 := (VTotalDeducciones||'_*'||NETO_PAGAR);
    END;        
END TW_PC_COMPROBANTE_PAGO;