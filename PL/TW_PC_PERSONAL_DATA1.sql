create or replace PROCEDURE   TW_PC_PERSONAL_DATA1
/*
************************************  OBJETIVO: GENERA LOS DATOS PERSONALES DEL USUARIO  ***********************************

-- PARAMETROS DE ENTRADA
   -- CODIGO_EPL        : RECIBE EL PARAMETRO CODIGO DEL EMPLEADO

   -- CREADO POR       : NELSON GALEANO

**************************************  DECLARACION DE VARIABLE  *****************************************************************/
(
    CODIGO_EPL      IN EMPLEADOS_BASIC.COD_EPL%TYPE, 
    BLOQUE1         OUT VARCHAR2, 
    BLOQUE2         OUT VARCHAR2, 
    BLOQUE3         OUT VARCHAR2, 
    BLOQUE4         OUT VARCHAR2, 
    BLOQUE5         OUT VARCHAR2, 
    BLOQUE6         OUT CLOB, 
    BLOQUE7         OUT VARCHAR2, 
    BLOQUE8         OUT VARCHAR2,
    BLOQUE9         OUT CLOB, 
    BLOQUE10        OUT VARCHAR2, 
    BLOQUE11        OUT VARCHAR2, 
    BLOQUE12        OUT VARCHAR2,
    BLOQUE13        OUT VARCHAR2, 
    BLOQUE14        OUT VARCHAR2
)
IS

ROL_PREDETERMINADO      VARCHAR2(10); -- VARIABLE QUE CONTIENE EL ROL PREDETERMINADO DEL EMPLEADO
BLOQUE1AA               VARCHAR2(1000); 
BLOQUE2BB               VARCHAR2(1000); 
BLOQUE3CC               VARCHAR2(500); 
BLOQUE4DD               VARCHAR2(100); 
NUM_DOCUMENTO           EMPLEADOS_BASIC.CEDULA%TYPE; -- NUMERO DE CEDULA
TIPO_DOC                EMPLEADOS_BASIC.TIPO_DOC%TYPE;
TIPO_DOC2               VARCHAR(100); -- TIPO DOCUMENTO (C.C - C.E - PASAPORTE - T.I)
NOMBRE_EPL              EMPLEADOS_BASIC.NOM_EPL%TYPE;
CARGO                   CARGOS.NOM_CAR%TYPE; 
CORREO                  EMPLEADOS_GRAL.EMAIL%TYPE;
CIUDAD                  CIUDADES.NOM_CIU%TYPE; 
DEPARTA                 DEPARTAMENTOS.NOM_DEP%TYPE; -- DEPARTAMENTO(REGIONAL)
CONTRATO                CONTRATOS.NOM_CTO%TYPE; -- TIPO DE CONTRATO (DEFINIDO - INDEFINIDO)
TIP_SALARIO             VARCHAR(100);  
FEC_INGRESO             DATE; 
CUENTA                  EPL_CONSIGNA.NUM_CTA%TYPE; -- NUMERO DE CUENTA
NOM_BANCO               BANCOS.NOM_BAN%TYPE; -- ENTIDAD BANCARIA
TIPO_CUENTA             EPL_CONSIGNA.TIP_CTA%TYPE; 
TIPO_CUENTA2            VARCHAR(100);  -- TIPO_CUENTA (AHORRO-CORRIENTE)
NOM_JEFE                EMPLEADOS_BASIC.NOM_EPL%TYPE;                      
PORCENRETE              VARCHAR(10); -- PORCENTAJE DE RETENCION
DEC_RENTA               VARCHAR(10);
DEC_RENTA2              VARCHAR(10); -- DECLARANTE DE RENTA
PROCE_RETEFUEN          VARCHAR(10); -- PROCEDIMIENTO RETENCION  EN LA FUENTE
VIVIENDA                VARCHAR2(25);
INT_VIVIENDA            CERTIFICADOS.VLR_MEN%TYPE;
FEC_VIVIENDA            DATE;
SALUD_PRE               VARCHAR2(30);
VAL_SALUD_PRE           CERTIFICADOS.VLR_MEN%TYPE;
FEC_SALUD_PRE           DATE;
DEPENDIEN               VARCHAR2(15);
VAL_DEPEN               CERTIFICADOS.VLR_MEN%TYPE;
FEC_DEPEN               DATE;
SALUD_OBLI              VARCHAR2(30);
VAL_SALUD_OBLI          CERTIFICADOS.VLR_MEN%TYPE;
FEC_SALUD_OBLI          DATE;
CUOTA_MAX               CAP_ENDEUDAMIENTO.VALOREND%TYPE; 
CAJA_COMP               VARCHAR(50);--------- VARIABLES AFILIACIONES - SEGURIDAD SOCIAL
NOM_COMPENSACION        COMPENSACION.NOM_COM%TYPE;
CESANTIA                CONCEPTOS.NOM_CON%TYPE;
NOM_CESANTIA            FONDOS.NOMBRE%TYPE;
FEC_CESANTIA            EPL_FONDOS.FEC_ING%TYPE;
BLOQUE_BASINT           VARCHAR2(1500);
NOVEDAD                 VARCHAR2(500); 
DEDUCIBLE_RETE          VARCHAR2(1000);
DEDU_CONCEP             VARCHAR2(500);
DEDU_ENTIDAD            VARCHAR2(500);
DEDU_APORTE             VARCHAR2(500); --------- FIN VARIABLES AFILIACIONES - SEGURIDAD SOCIAL
TITULO                  FEEDNEWS.TITULO%TYPE;
CONTENIDO               FEEDNEWS.CONTENIDO%TYPE;
FEC_NOTI                FEEDNEWS.FECHA%TYPE;  
VCurDias                VACACIONES_PENDIENTES.DIAS%TYPE;
PER_INI                 TOTALES_PAGO.PER_INI%TYPE;
ANO_INI                 TOTALES_PAGO.ANO_INI%TYPE;
FECHA                   PERIODOS.FEC_FIN%TYPE;   
VCadena                 VARCHAR2(500);
VNmes                   VARCHAR2(15);
VNoticias               VARCHAR2(2000);
    
    CURSOR SEGU_SOCIAL  -- SEGURIDAD SOCIAL PARA SALARIO BASICO------------ BLOQUE 6
    IS
    SELECT C.NOM_CON AS CESANTIA, F.NOMBRE AS NOM_CESANTIA, E.FEC_ING AS FEC_CESANTIA 
    FROM EPL_FONDOS E, CONCEPTOS C, FONDOS F
    WHERE E.COD_EPL =CODIGO_EPL
    AND E.COD_CON = C.COD_CON
    AND E.COD_FON = F.COD_FON
    AND E.COD_CON IN (2001, 2002,2004, 1020)
    AND E.FEC_RET IS NULL
    AND E.FEC_TRAS IS NULL;
    
    CURSOR SEGU_SOCIAL2  -- SEGURIDAD SOCIAL PARA SALARIO INTEGRAL------------ BLOQUE 6
    IS
    SELECT C.NOM_CON AS CESANTIA, F.NOMBRE AS NOM_CESANTIA, E.FEC_ING AS FEC_CESANTIA 
    FROM EPL_FONDOS E, CONCEPTOS C, FONDOS F
    WHERE E.COD_EPL =CODIGO_EPL
    AND E.COD_CON = C.COD_CON
    AND E.COD_FON = F.COD_FON
    AND E.COD_CON IN (2001, 2002,2004)
    AND E.FEC_RET IS NULL
    AND E.FEC_TRAS IS NULL;    
    
    CURSOR DEDU_RETE  ---  DEDUCIBLE DE RETENCION EL LA FUENTE  ----------------- BLOQUE 7
    IS
    SELECT C.NOM_CON AS DEDU_CONCEP, F.NOMBRE AS DEDU_ENTIDAD, E.POR_ADI AS DEDU_APORTE
    FROM EPL_FONDOS E, CONCEPTOS C, FONDOS F                
    WHERE E.COD_EPL =CODIGO_EPL
    AND E.COD_CON = C.COD_CON
    AND E.COD_FON = F.COD_FON
    AND E.COD_CON IN (2025,2038,2039, 2044, 2052, 2054)
    AND E.POR_ADI >0
    AND E.FEC_RET IS NULL
    AND E.FEC_TRAS IS NULL;

    CURSOR DIAS_VAC -- DIAS DE VACACIONES PENDIENTES   -------  BLOQUE 10
    IS
    SELECT DIAS
    FROM VACACIONES_PENDIENTES WHERE COD_EPL=CODIGO_EPL
    ORDER BY FEC_INI_PER;
         
    CURSOR COMP_PAGO -- ULTIMOS 3 COMPROBANTES DE PAGO -----  BLOQUE 11
    IS
    select PER_INI, ANO_INI, FECHA from (
    select a.num_com AS NUM_COM, b.nom_liq AS NOM_LIQ,
    a.per_fin as PER_INI,a.ano_ini as ANO_INI,
    TO_CHAR(c.fec_fin)as FECHA,a.tip_pag AS TIP_PAG,a.liq_ini AS LIQ_INI
    from totales_pago a , liquidacion b , periodos c
    where b.cod_liq=a.liq_ini  and a.tip_pag=c.tip_per
    and a.per_ini=c.cod_per and a.ano_ini=c.ano and          
    a.cod_epl='52513735'
    ORDER BY a.ano_ini desc,c.fec_fin desc
    )
    where  rownum <=3;          
    
    CURSOR ULT_NOTICIAS -- ULTIMAS NOTICIAS   ---------   BLOQUE 9
    IS
    SELECT TITULO, CONTENIDO, FECHA AS FEC_NOTI
    FROM ( SELECT * FROM FEEDNEWS ORDER BY ID DESC )
    ORDER BY FEC_NOTI DESC;

    Procedure Meses(VPeriodo IN TOTALES_PAGO.PER_INI%TYPE, VNmes OUT VARCHAR2) -- PASO EL PERIODO DE LOS COMPROBANTES DE PAGO A MESES
    Is
    BEGIN
        CASE VPeriodo
            WHEN 1 THEN VNmes := 'Enero';
            WHEN 2 THEN VNmes := 'Febrero';
            WHEN 3 THEN VNmes := 'Marzo';
            WHEN 4 THEN VNmes := 'Abril';
            WHEN 5 THEN VNmes := 'Mayo';
            WHEN 6 THEN VNmes := 'Junio';
            WHEN 7 THEN VNmes := 'Julio';
            WHEN 8 THEN VNmes := 'Agosto';
            WHEN 9 THEN VNmes := 'Septiembre';
            WHEN 10 THEN VNmes := 'Octubre';
            WHEN 11 THEN VNmes := 'Noviembre';
            ELSE
            VNmes := 'Diciembre';
        END CASE;
    END; 
BEGIN         
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 1 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN               
        BEGIN
            SELECT (B.NOM_EPL||' '||B.APE_EPL), CAR.NOM_CAR, CONT.NOM_CTO, B.FEC_ING, 
                CASE WHEN GR.COD_GRU='2' THEN 'INTEGRAL' ELSE 'BÁSICO' END  
            INTO NOMBRE_EPL, CARGO, CONTRATO,FEC_INGRESO, TIP_SALARIO
            FROM EMPLEADOS_BASIC B, CARGOS CAR, CONTRATOS CONT, EPL_GRUPOS GR
            WHERE B.COD_EPL=CODIGO_EPL 
            AND B.COD_CAR=CAR.COD_CAR 
            AND B.COD_CTO=CONT.COD_CTO 
            AND GR.COD_EPL=B.COD_EPL 
            AND GR.COD_GRU IN (1,2)  
            AND B.ESTADO='A';
            
            BLOQUE1AA := INITCAP(NOMBRE_EPL||'_*'||CARGO||'_*'||TIP_SALARIO||'_*'||CONTRATO||'_*'||FEC_INGRESO);
        EXCEPTION
            When no_data_found Then
            BLOQUE1AA := 'INACTIVO';
        END;
    END;        
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 2 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
        SELECT B.CEDULA, B.TIPO_DOC, GR.EMAIL, CI.NOM_CIU, DE.NOM_DEP
        INTO NUM_DOCUMENTO, TIPO_DOC, CORREO, CIUDAD, DEPARTA
        FROM EMPLEADOS_BASIC B, EMPLEADOS_GRAL GR, CIUDADES CI, DEPARTAMENTOS DE
        WHERE B.COD_EPL=CODIGO_EPL 
        AND B.COD_EPL=GR.COD_EPL 
        AND GR.COD_CIU=CI.COD_CIU 
        AND B.COD_DEP=DE.COD_DEP 
        AND B.ESTADO='A';
    
        IF (TIPO_DOC='C') THEN
            TIPO_DOC2 := 'C.C.';
            ELSE
            IF (TIPO_DOC='E') THEN
                TIPO_DOC2 := 'C.E.';
                ELSE
                IF (TIPO_DOC='P') THEN
                    TIPO_DOC2:= 'Pasaporte';
                    ELSE
                    IF (TIPO_DOC='T') THEN
                        TIPO_DOC2 := 'T.I.';
                    END IF;
                END IF;
            END IF;
        END IF;
     
        BEGIN   
            -- JEFE INMEDIATO             
            SELECT (nom_epl||' '||ape_epl) 
            INTO NOM_JEFE
            FROM EMPLEADOS_GRAL GRA, EMPLEADOS_BASIC EB 
            WHERE GRA.COD_EPL=CODIGO_EPL AND GRA.COD_JEFE=EB.COD_EPL;         
        EXCEPTION
            When no_data_found Then
            NOM_JEFE :='No tiene'; 
        END;
        
        BLOQUE2BB := (CORREO||'_*'||TIPO_DOC2||' '||NUM_DOCUMENTO||'_*'||CIUDAD||'_*'||INITCAP(NOM_JEFE||'_*'||DEPARTA)); 
    EXCEPTION
        When no_data_found Then
        BLOQUE2BB := 'INACTIVO';
    END;       
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 3 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN                           
        SELECT CASE WHEN A.COD_BAN=13 THEN SUBSTR(A.COD_SUC,2,3)||A.NUM_CTA ELSE A.NUM_CTA END, 
            C.NOM_BAN, A.TIP_CTA
        INTO CUENTA, NOM_BANCO, TIPO_CUENTA   
        FROM EPL_CONSIGNA A, BANCOS C
        WHERE A.COD_BAN=C.COD_BAN 
        AND A.COD_EPL=CODIGO_EPL 
        AND A.ESTADO='A';           
       
        IF (TIPO_CUENTA='1') THEN            
            TIPO_CUENTA2 :=  'CORRIENTE';                      
        ELSE            
            TIPO_CUENTA2 := 'AHORROS';                    
        END IF;
        
        BLOQUE3CC := (NOM_BANCO||'_*'||CUENTA||'_*'||INITCAP(TIPO_CUENTA2));        
    EXCEPTION
        When no_data_found Then
        BLOQUE3CC := 'INACTIVO';
    END;  
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 4 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN      
        BEGIN
            --DECLARANTE DE RENTA
            SELECT COUNT(*) 
            INTO DEC_RENTA
            FROM EPL_GRUPOS
            WHERE COD_EPL = CODIGO_EPL
            AND COD_GRU =100;
            
            IF (DEC_RENTA='0') THEN            
                DEC_RENTA2 :=  'No';                      
            ELSE            
                DEC_RENTA2 := 'Si';                    
            END IF;     
        END;                

        BEGIN
            SELECT EB.RTE_FTE
            INTO PORCENRETE
            FROM EMPLEADOS_BASIC EB
            WHERE EB.COD_EPL=CODIGO_EPL;            
            
            IF(PORCENRETE>='0')THEN
                PROCE_RETEFUEN := '2';
                ELSE 
                PROCE_RETEFUEN := '1';
            END IF;
        EXCEPTION
            When no_data_found Then
            DEC_RENTA2 := 'INACTIVO';
        END;        
        
        BEGIN
            SELECT VALOREND 
            INTO CUOTA_MAX
            FROM CAP_ENDEUDAMIENTO 
            WHERE COD_EPL=CODIGO_EPL 
            ORDER BY ANO DESC, MES DESC;            
        EXCEPTION
            When no_data_found Then
            CUOTA_MAX := '0';
        END;  
        BLOQUE4DD := (DEC_RENTA2||'_*'||PROCE_RETEFUEN||'_*'||PORCENRETE||'_*'||CUOTA_MAX);
    END;
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 5 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN    
        
        NOVEDAD := 'Novedades'||'_*'||'Reporta novedades para Pensión voluntaria y AFC, cambio de cuenta de nómina, declarante de renta y reporte paz y salvo libranzas';            
        
    END;        
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 6 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN        
        SELECT C.NOM_COM
        INTO NOM_COMPENSACION
        FROM empleados_gral E,  compensacion C
        WHERE E.COD_EPL =CODIGO_EPL
        AND C.COD_COM = E.COMFENA;                
                
        CAJA_COMP := 'Caja De Compensación';
                
        BEGIN                
            SELECT CASE WHEN COD_GRU='2' THEN 'INTEGRAL' ELSE 'BÁSICO' END
            INTO TIP_SALARIO
            FROM EPL_GRUPOS
            WHERE COD_EPL=CODIGO_EPL AND COD_GRU IN (1,2);               
                                
            IF (TIP_SALARIO='BÁSICO') THEN-- PARA SALARIO BASICO                
                BEGIN
                    BLOQUE_BASINT := ' ';
                    For RegCesantia IN SEGU_SOCIAL
                    Loop
                        CESANTIA := RegCesantia.CESANTIA;
                        NOM_CESANTIA := RegCesantia.NOM_CESANTIA;
                        FEC_CESANTIA := RegCesantia.FEC_CESANTIA;  
                        BLOQUE_BASINT := BLOQUE_BASINT || CESANTIA||'_*'||NOM_CESANTIA||'_*'||FEC_CESANTIA||'_*';    
                    End Loop;              
                END;    
            ELSE
                ------PARA SALARIO INTEGRAL
                BEGIN
                    BLOQUE_BASINT := ' ';
                    For RegCesantia IN SEGU_SOCIAL2
                    Loop
                        CESANTIA := RegCesantia.CESANTIA;
                        NOM_CESANTIA := RegCesantia.NOM_CESANTIA;
                        FEC_CESANTIA := RegCesantia.FEC_CESANTIA;  
                        BLOQUE_BASINT := BLOQUE_BASINT || CESANTIA||'_*'||NOM_CESANTIA||'_*'||FEC_CESANTIA||'_*';    
                    End Loop;              
                END;                                            
            END IF;      
        END;
    END;    
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 7 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN
        BEGIN
            DEDUCIBLE_RETE := ' ';
            For RegRetefuente IN DEDU_RETE
            Loop
                DEDU_CONCEP := RegRetefuente.DEDU_CONCEP;
                DEDU_ENTIDAD := RegRetefuente.DEDU_ENTIDAD;
                DEDU_APORTE := RegRetefuente.DEDU_APORTE;  
                DEDUCIBLE_RETE := DEDUCIBLE_RETE || DEDU_CONCEP||'_*'||DEDU_ENTIDAD||'_*'||DEDU_APORTE||'_*';    
            End Loop;              
            
            IF (DEDUCIBLE_RETE = ' ')THEN
                DEDUCIBLE_RETE := 'INACTIVO';
            END IF;                
        END;        
    END;                                                       
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 8 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    BEGIN    
        BEGIN
            -- VIVIENDA
            SELECT NVL(MAX(c.vlr_men),0), c.FECHA
            INTO INT_VIVIENDA, FEC_VIVIENDA 
            FROM   CERTIFICADOS c, EMPLEADOS_BASIC E, PERIODOS P
            WHERE  c.cod_epl=CODIGO_EPL
            AND c.cod_epl = e.cod_epl 
            AND e.tip_pago = p.tip_per
            and e.fec_ult_nom between p.fec_ini and p.fec_fin
            AND  c.fecha>=p.fec_ini
            AND  c.tipo='V'
            And ROWNUM <= 1
            group by  c.FECHA;
                        
            VIVIENDA := 'Intereses de Vivienda';
            
        EXCEPTION
            When no_data_found Then
            INT_VIVIENDA :='0';    
            FEC_VIVIENDA := '';     
        END; 
                    
        BEGIN
            --DEPENDIENTES
            SELECT NVL(MAX(c.vlr_men),0), c.FECHA
            INTO VAL_DEPEN, FEC_DEPEN
            FROM   CERTIFICADOS c, EMPLEADOS_BASIC E, PERIODOS P
            WHERE  c.cod_epl=CODIGO_EPL
            AND c.cod_epl = e.cod_epl 
            AND e.tip_pago = p.tip_per
            and e.fec_ult_nom between p.fec_ini and p.fec_fin
            AND  c.fecha>=p.fec_ini
            AND  c.tipo='D'
            And ROWNUM <= 1
            group by  c.FECHA;
                        
            DEPENDIEN := 'Dependientes';
            
        EXCEPTION
            When no_data_found Then
            VAL_DEPEN :='0';    
            FEC_DEPEN := '';             
        END;            
                                   
        BEGIN 
            --SALUD OBLIGATORIA (AÑO ANTERIOR)
            SELECT  NVL(sum(vlr_men),0), c.FECHA
            INTO VAL_SALUD_OBLI, FEC_SALUD_OBLI               
            FROM   CERTIFICADOS C, EMPLEADOS_BASIC E, PERIODOS P
            WHERE  C.cod_epl =CODIGO_EPL
            AND c.cod_epl = e.cod_epl 
            AND e.tip_pago = p.tip_per
            and e.fec_ult_nom between p.fec_ini and p.fec_fin                 
            AND  tipo   = 'E'
            AND  C.fecha  >= P.FEC_INI
            And ROWNUM <= 1
            group by  c.FECHA;
                        
            SALUD_OBLI := 'Salud Obligatoria';

        EXCEPTION
            When no_data_found Then
            VAL_SALUD_OBLI :='0';    
            FEC_SALUD_OBLI := '';           
        END;
                    
        BEGIN
            -- SALUD PREPAGADA
            SELECT NVL(MAX(c.vlr_men),0), c.FECHA
            INTO VAL_SALUD_PRE, FEC_SALUD_PRE
            FROM   CERTIFICADOS c, EMPLEADOS_BASIC E, PERIODOS P
            WHERE  c.cod_epl=CODIGO_EPL
            AND c.cod_epl = e.cod_epl 
            AND e.tip_pago = p.tip_per
            and e.fec_ult_nom between p.fec_ini and p.fec_fin
            AND  c.fecha>=p.fec_ini
            AND  c.tipo='S'
            And ROWNUM <= 1
            group by  c.FECHA;   
                        
            SALUD_PRE := 'Salud Prepagada';      
            
        EXCEPTION
            When no_data_found Then
            VAL_SALUD_PRE :='0';    
            FEC_SALUD_PRE := '';                         
        END;
    END; 
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 9 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
     VNoticias := ' ';
    For RegNoticias IN ULT_NOTICIAS
    Loop
        TITULO := RegNoticias.TITULO;
        CONTENIDO := RegNoticias.CONTENIDO;
        FEC_NOTI := RegNoticias.FEC_NOTI;               
        VNoticias := VNoticias || TITULO||'_*'||FEC_NOTI||'_*'||CONTENIDO||'*_';    
    End Loop;           
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 10 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    VCadena := ' ';
    For RegPago IN COMP_PAGO
    Loop
        PER_INI := RegPago.PER_INI;
        ANO_INI := RegPago.ANO_INI;
        FECHA := RegPago.FECHA;    
        Meses(PER_INI,VNmes);        
        VCadena := VCadena || VNmes||'_*'||ANO_INI||'_*'||FECHA||'_*'||PER_INI||'_*';    
    End Loop;       
    /* ----------------------------------------------------------------------------------------------------------------------------------
    ========================================================= BLOQUE 11 ==================================================================                                                                                                                                    
    -------------------------------------------------------------------------------------------------------------------------------------*/
    VCurDias := 0;
    Begin
        For Registro In DIAS_VAC
        Loop
            VCurDias := VCurDias + Registro.DIAS;
        End Loop;
    End;
    
    -- IDENTIFICAR EL ROL PREDETEMRINADO QUE TIENE ASIGNADO
    ROL_PREDETERMINADO := PKG_AUTOGES_ROLES_Y_PERFILES.FN_IDENTIF_ROL_PREDETERMINADO(CODIGO_EPL);   
                
    IF (ROL_PREDETERMINADO = 'ADMIN' OR ROL_PREDETERMINADO = 'JEFE' OR ROL_PREDETERMINADO = 'RASO') THEN -- EJEMPLO PERFIL GERENTE          
        BLOQUE1 := BLOQUE1AA;       
        BLOQUE2 := BLOQUE2BB;       
        BLOQUE3 := BLOQUE3CC;       
        BLOQUE4 := BLOQUE4DD;
        BLOQUE5 := NOVEDAD;
        BLOQUE6 := BLOQUE_BASINT||CAJA_COMP||'_*'||NOM_COMPENSACION;
        BLOQUE7 := DEDUCIBLE_RETE;
        BLOQUE8 := ('$ '||TO_CHAR(INT_VIVIENDA, 'FM99G999G999')||'_*'||FEC_VIVIENDA||'_*'||
                            '$ '||TO_CHAR(VAL_SALUD_OBLI, 'FM99G999G999')||'_*'||FEC_SALUD_OBLI||'_*'||
                            '$ '||TO_CHAR(VAL_DEPEN, 'FM99G999G999')||'_*'||FEC_DEPEN||'_*'||
                            '$ '||TO_CHAR(VAL_SALUD_PRE, 'FM99G999G999')||'_*'||FEC_SALUD_PRE);        
        BLOQUE9 := (VNoticias);  
        BLOQUE10 := (VCadena);            
        BLOQUE11 := VCurDias;        
        BLOQUE12 := 'ACTIVO';
        BLOQUE13 := 'ACTIVO';
        BLOQUE14 := 'ACTIVO';             
    ELSE                    
        IF (ROL_PREDETERMINADO='SENA') THEN -- EJEMPLO PERFIL SENA
            BLOQUE1 := BLOQUE1AA;
            BLOQUE2 := BLOQUE2BB;
            BLOQUE3 := BLOQUE3CC;
            BLOQUE4 :='INACTIVO';
            BLOQUE5 := 'INACTIVO';
            BLOQUE6 := 'INACTIVO';
            BLOQUE7 := 'INACTIVO';
            BLOQUE8 := 'INACTIVO';        
            BLOQUE9 := 'INACTIVO'; 
            BLOQUE10 := 'INACTIVO';        
            BLOQUE11 := 'INACTIVO';    
            BLOQUE12 := 'INACTIVO';
            BLOQUE13 := 'INACTIVO';
            BLOQUE14 := 'INACTIVO';             
        END IF;                            
    END IF;
END TW_PC_PERSONAL_DATA1;