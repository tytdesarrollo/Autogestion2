create or replace PROCEDURE TW_PC_CERT_INGRESOS1
/*************************OBJETIVO: GENERA LOS DATOS PARA EL CERTIFICADO DE INGRESOS Y RETENCION***************************
-- PARAMETROS DE ENTRADA
   -- CODIGO_EPL        :  CODIGO DEL EMPLEADO
   -- AÑO_FORMU         :  AÑO DEL CERTIFICADO   
   -- OUTPUT            :  SI RETORNA CERO ES POR QUE NO SE ENCONTRARON DATOS
   -- MESSAGE           :  SI OUPUT RETORNA CERO MUESTRA EL MENSAJE 'No se encontraron datos.'

   -- CREADO POR       : NELSON GALEANO
************************************  DECLARACION DE VARIABLE  *************************************************************/
(
    CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE, 
    ANO_FORMU IN INTEGER,   
    BLOQUE1 OUT CLOB, 
    BLOQUE2 OUT VARCHAR2,
    OUTPUT OUT VARCHAR2,
    MESSAGE OUT VARCHAR2
)
IS
IMG_CERTIFICADO   VARCHAR2(60);
CERTIFICADO       VARCHAR2(800); 
FECHAS            VARCHAR2(50);
v_anos            VARCHAR2(60);  
v_anos1           VARCHAR2(60);  
/*============= VARIABLES ============================================= POSICION EN X ==================== POSICION EN Y =========*/
NUM_FOR_4                HIST_CERTRTEFTE.CONSEC%TYPE;           NUM_FOR_4X           INTEGER;      NUM_FOR_4Y           INTEGER; 
NIT_5                    HIST_CERTRTEFTE.NIT_EMP%TYPE;          NIT_5X               INTEGER;      NIT_5Y               INTEGER;
DV_6                     HIST_CERTRTEFTE.DIG_VER%TYPE;          DV_6X                INTEGER;      DV_6Y                INTEGER;
EMPRESA_11               HIST_CERTRTEFTE.NOM_EMP%TYPE;          EMPRESA_11X          INTEGER;      EMPRESA_11Y          INTEGER;     
TIPO_24                  VARCHAR2(2);                           TIPO_24X             INTEGER;      TIPO_24Y             INTEGER; 
CEDULA_25                HIST_CERTRTEFTE.CEDULA%TYPE;           CEDULA_25X           INTEGER;      CEDULA_25Y           INTEGER;   
APELLIDOS                HIST_CERTRTEFTE.APELLIDO%TYPE;
NOMBRES                  HIST_CERTRTEFTE.NOM_EMP%TYPE;
FECHA_INICIO_30          HIST_CERTRTEFTE.FEC_INI%TYPE;    
DIA_F_INI_30             VARCHAR2(2);                           DIA_F_INI_30X        INTEGER;      DIA_F_INI_30Y        INTEGER;
MES_F_INI_30             VARCHAR2(2);                           MES_F_INI_30X        INTEGER;      MES_F_INI_30Y        INTEGER;
ANO_F_INI_30             INTEGER;                               ANO_F_INI_30X        INTEGER;      ANO_F_INI_30Y        INTEGER;
FECHA_FIN_31             HIST_CERTRTEFTE.FEC_FIN%TYPE;
DIA_F_FIN_31             VARCHAR2(2);                           DIA_F_FIN_31X        INTEGER;      DIA_F_FIN_31Y        INTEGER;
MES_F_FIN_31             VARCHAR2(2);                           MES_F_FIN_31X        INTEGER;      MES_F_FIN_31Y        INTEGER;
ANO_F_FIN_31             INTEGER;                               ANO_F_FIN_31X        INTEGER;      ANO_F_FIN_31Y        INTEGER;
FECHA_EXPEDICION_32      HIST_CERTRTEFTE.FEC_EXP%TYPE;
DIA_F_EXP_32             VARCHAR2(2);                           DIA_F_EXP_32X        INTEGER;      DIA_F_EXP_32Y        INTEGER;
MES_F_EXP_32             VARCHAR2(2);                           MES_F_EXP_32X        INTEGER;      MES_F_EXP_32Y        INTEGER;
ANO_F_EXP_32             INTEGER;                               ANO_F_EXP_32X        INTEGER;      ANO_F_EXP_32Y        INTEGER;
LUGAR_EXPEDICION_33      HIST_CERTRTEFTE.NOM_CIU%TYPE;          LUGAR_EXPEDICION_33X INTEGER;      LUGAR_EXPEDICION_33Y INTEGER;
COD_DEP_34               VARCHAR2(2);                           COD_DEP_34X          INTEGER;      COD_DEP_34Y          INTEGER;
COD_CIU_MUNI_35          VARCHAR2(10);                          COD_CIU_MUNI_35X     INTEGER;      COD_CIU_MUNI_35Y     INTEGER;
NUM_AGENCI_36            VARCHAR2(2);                           NUM_AGENCI_36X       INTEGER;      NUM_AGENCI_36Y       INTEGER;  
SALARIOS_37              HIST_CERTRTEFTE.SALARIOGR%TYPE;                                                                                                                           SALARIOS_37Y                       INTEGER;
CESANTIAS_38             HIST_CERTRTEFTE.CESANTIASGR%TYPE;                                                                                                                       CESANTIAS_38Y                     INTEGER;  
GASTOSREPRE_39           VARCHAR(2);                                                                                                                                                                 GASTOSREPRE_39Y                INTEGER; 
PENSIONES_40             VARCHAR(2);                                                                                                                                                                 PENSIONES_40Y                      INTEGER;
OTROS_ING_41             HIST_CERTRTEFTE.OTROSGR%TYPE;                                                                                                                             OTROS_ING_41Y                     INTEGER;  
TOTAL_ING_42             INTEGER;                                                                                                                                                                        TOTAL_ING_42Y                      INTEGER; 
APOR_SALUD_43            HIST_CERTRTEFTE.APO_SAL%TYPE;                                                                                                                               APOR_SALUD_43Y                   INTEGER;
PENSION_SOLIDARIDAD_44   HIST_CERTRTEFTE.VSAPESO%TYPE;                                                                                                                             PENSION_SOLIDARIDAD_44Y    INTEGER;
VOLUNTARIAS_45           HIST_CERTRTEFTE.VVOPAFC%TYPE;                                                                                                                               VOLUNTARIAS_45Y                  INTEGER;
RETENCION_46             HIST_CERTRTEFTE.VLRRTE%TYPE;                                                                                                                                  RETENCION_46Y                      INTEGER;                        
NOM_RET                  VARCHAR(100);                          NOM_RETX             INTEGER;      NOM_RETY             INTEGER;  
NOM_PAGADOR              VARCHAR(100);                          NOM_PAGADORX         INTEGER;      NOM_PAGADORY         INTEGER;   
APE_LENGTH               VARCHAR2(100); 
APE_INSTR                VARCHAR2(100);
PRIMER_APE_26            VARCHAR2(100); /*PRIMER APELLIDO*/     PRIMER_APE_26X       INTEGER;      PRIMER_APE_26Y       INTEGER;
SEGUN_APE                INTEGER;
SEGUN1_APE               INTEGER;
SEG_APE_27               VARCHAR2(100);/*SEGUNDO APELLIDO*/     SEG_APE_27X          INTEGER;      SEG_APE_27Y          INTEGER;
NOM_LENGTH               VARCHAR2(100);
NOM_INSTR                VARCHAR2(100);       
PRIMER_NOM_28            VARCHAR2(100);/*PRIMER NOMBRE*/        PRIMER_NOM_28X       INTEGER;      PRIMER_NOM_28Y       INTEGER;
SEGUN                    INTEGER;
SEGUN1                   INTEGER;
SEG_NOM_29               VARCHAR2(100);/*SEGUNDO NOMBRE*/       SEG_NOM_29X          INTEGER;      SEG_NOM_29Y          INTEGER; 
ANOCERTI                 HIST_CERTRTEFTE.ANOCERTI%TYPE;

CURSOR FECHA_DINAMINCA  -- SEGURIDAD SOCIAL PARA SALARIO BASICO------------ BLOQUE 6
IS
SELECT DISTINCT ANOCERTI 
FROM HIST_CERTRTEFTE 
WHERE ANOCERTI>='2011' 
ORDER BY ANOCERTI DESC;

BEGIN

    IF (ANO_FORMU = '0') OR (ANO_FORMU IS NULL) THEN    
        --TRAE LOS AÑOS QUE SE VISUALIZAN EN LA APLICACION.
        FECHAS := ' ';
        OPEN FECHA_DINAMINCA;
        Loop
            FETCH FECHA_DINAMINCA INTO FECHAS;
            EXIT WHEN FECHA_DINAMINCA%NOTFOUND;
            --ANOCERTI := Fec_din.ANOCERTI;                    
            v_anos := v_anos||FECHAS||'_*';    
        End Loop;  
        CLOSE FECHA_DINAMINCA;
        BLOQUE1 := '0';
        v_anos1 := TRIM ( '*' FROM v_anos); 
        BLOQUE2 := TRIM ( '_' FROM v_anos1); 
    ELSE
        IMG_CERTIFICADO := 'img/certificado'||ANO_FORMU||'.jpg';-- NOMBRE DEL ARCHIVO QUE GENERA LA IMAGEN DEL CERTIFICADO. ES EL PRIMER VALOR QUE RETORNA
        BEGIN        
            SELECT H.CONSEC, H.NIT_EMP, H.DIG_VER, H.NOM_EMP, CASE WHEN E.TIPO_DOC = 'T' THEN '12' WHEN E.TIPO_DOC ='E'  THEN '22' ELSE '13' END, 
            H.CEDULA, H.APELLIDO, H.NOMBRE, H.FEC_INI, H.FEC_FIN, FEC_EXP, NOM_CIU, SALARIOGR, CESANTIASGR, 0, 0, OTROSGR, (SALARIOGR+ CESANTIASGR+OTROSGR), 
            H.APO_SAL, H.VSAPESO, H.VVOPAFC, H.VLRRTE
            INTO NUM_FOR_4, NIT_5, DV_6, EMPRESA_11, TIPO_24, CEDULA_25, APELLIDOS, NOMBRES, FECHA_INICIO_30, FECHA_FIN_31, FECHA_EXPEDICION_32, LUGAR_EXPEDICION_33, SALARIOS_37, 
            CESANTIAS_38, GASTOSREPRE_39, PENSIONES_40, OTROS_ING_41, TOTAL_ING_42, APOR_SALUD_43, PENSION_SOLIDARIDAD_44, VOLUNTARIAS_45, RETENCION_46
            FROM HIST_CERTRTEFTE H, EMPLEADOS_BASIC E 
            WHERE H.ANOCERTI =ANO_FORMU
            AND H.COD_EPL = CODIGO_EPL
            AND H.COD_EPL = E.COD_EPL;
        EXCEPTION
            WHEN NO_DATA_FOUND THEN 
            OUTPUT := '0';
            MESSAGE := 'No se encontraron datos.';
        END;            
        
        --DIVIDO LOS NOMBRES
        NOM_LENGTH := LENGTH(NOMBRES);
        NOM_INSTR :=INSTR(NOMBRES,' ');
        PRIMER_NOM_28 := SUBSTR(NOMBRES,1,NOM_INSTR); -- PRIMER NOMBRE                
        SEGUN := NOM_LENGTH - NOM_INSTR;
        SEGUN1 := NOM_INSTR + 1;
        SEG_NOM_29 := SUBSTR(NOMBRES,SEGUN1,SEGUN);-- SEGUNDO NOMBRE
        
        --DIVIDO LOS APELLIDOS
        APE_LENGTH := LENGTH(APELLIDOS);
        APE_INSTR :=INSTR(APELLIDOS,' ');
        PRIMER_APE_26 := SUBSTR(APELLIDOS,1,APE_INSTR); -- PRIMER APELLIDO        
        SEGUN_APE := APE_LENGTH - APE_INSTR;
        SEGUN1_APE := APE_INSTR + 1;
        SEG_APE_27 := SUBSTR(APELLIDOS,SEGUN1_APE,SEGUN_APE); -- SEGUNDO APELLIDO
        
        --FECHA INICIO
        DIA_F_INI_30 := EXTRACT (DAY FROM FECHA_INICIO_30);
        MES_F_INI_30 := EXTRACT (MONTH FROM FECHA_INICIO_30);                        
        ANO_F_INI_30 := EXTRACT (YEAR FROM FECHA_INICIO_30);
       
        IF (MES_F_INI_30<10) THEN
            MES_F_INI_30 := '0'||MES_F_INI_30;        
        END IF;      
        
        IF (DIA_F_INI_30<10) THEN
            DIA_F_INI_30 := '0'||DIA_F_INI_30;        
        END IF;  
        
        --FECHA FIN
        DIA_F_FIN_31 := EXTRACT (DAY FROM FECHA_FIN_31);
        MES_F_FIN_31 := EXTRACT (MONTH FROM FECHA_FIN_31);                        
        ANO_F_FIN_31 := EXTRACT (YEAR FROM FECHA_FIN_31);      
        
        IF (DIA_F_FIN_31<10) THEN
            DIA_F_FIN_31 := '0'||DIA_F_FIN_31;        
        END IF;        
        
        IF (MES_F_FIN_31<10) THEN
            MES_F_FIN_31 := '0'||MES_F_FIN_31;        
        END IF;        
       
        --FECHA EXPEDICION
        DIA_F_EXP_32 := EXTRACT (DAY FROM FECHA_EXPEDICION_32);
        MES_F_EXP_32 := EXTRACT (MONTH FROM FECHA_EXPEDICION_32);
        ANO_F_EXP_32 := EXTRACT (YEAR FROM FECHA_EXPEDICION_32);
        
        IF (DIA_F_EXP_32<10) THEN
            DIA_F_EXP_32 := '0'||DIA_F_EXP_32;        
        END IF;        
        
        IF (MES_F_EXP_32<10) THEN
            MES_F_EXP_32 := '0'||MES_F_EXP_32;        
        END IF;              
        
        COD_DEP_34 := '11';
        COD_CIU_MUNI_35 :='0 0 1';
        NUM_AGENCI_36 := '1';
        
        BEGIN
            SELECT NOM_EPL_FIR
            INTO NOM_RET 
            FROM CERTIFICADO_RTEFTE 
            WHERE ANO=ANO_FORMU;            
        END;
        
        NOM_PAGADOR := 'SE OMITE LA FIRMA DEL CERTIFICADO DE ACUERDO AL ART. 10 DEL DECRETO 836 DE 1991';        
        /********************************************* POSICIONES DE LAS VARIABLES EN X,Y **********************************************/
        NUM_FOR_4X := '120';           NIT_5X := '48';                DV_6X := '66';                      EMPRESA_11X := '15';
        NUM_FOR_4Y := '27';            NIT_5Y := '36';                DV_6Y := '36';                      EMPRESA_11Y := '45';
        
        TIPO_24X := '20';              CEDULA_25X := '33';            PRIMER_APE_26X := '84';             SEG_APE_27X := '114';           
        TIPO_24Y := '55';              CEDULA_25Y := '53';            PRIMER_APE_26Y := '54';             SEG_APE_27Y := '54'; 
        
        PRIMER_NOM_28X := '146';       SEG_NOM_29X := '176';          ANO_F_INI_30X := '20';              MES_F_INI_30X := '32';     
        PRIMER_NOM_28Y := '54';        SEG_NOM_29Y := '54';           ANO_F_INI_30Y := '63';              MES_F_INI_30Y := '63';
        
        DIA_F_INI_30X := '39';         ANO_F_FIN_31X := '57';         MES_F_FIN_31X := '69';              DIA_F_FIN_31X := '77'; 
        DIA_F_INI_30Y := '63';         ANO_F_FIN_31Y := '63';         MES_F_FIN_31Y := '63';              DIA_F_FIN_31Y := '63';     
        
        ANO_F_EXP_32X := '88';         MES_F_EXP_32X := '100';        DIA_F_EXP_32X := '108';             LUGAR_EXPEDICION_33X := '120';       
        ANO_F_EXP_32Y := '63';         MES_F_EXP_32Y := '63';         DIA_F_EXP_32Y := '63';              LUGAR_EXPEDICION_33Y := '63';            
        
        COD_DEP_34X := '181';          COD_CIU_MUNI_35X := '190';     NUM_AGENCI_36X := '153';            SALARIOS_37Y := '77';     
        COD_DEP_34Y := '63';           COD_CIU_MUNI_35Y := '63';      NUM_AGENCI_36Y := '68';               
        
        CESANTIAS_38Y := '81';         GASTOSREPRE_39Y := '85';       PENSIONES_40Y := '89';              OTROS_ING_41Y := '94';  
        
        TOTAL_ING_42Y := '98';         APOR_SALUD_43Y := '108';       PENSION_SOLIDARIDAD_44Y := '112';   VOLUNTARIAS_45Y := '116';
        
        RETENCION_46Y := '121';        NOM_PAGADORX := '20';          NOM_RETX := '20';      
                                       NOM_PAGADORY := '130';         NOM_RETY := '135';  
        
        CERTIFICADO := (IMG_CERTIFICADO||'_*'||NUM_FOR_4||'_*'||NUM_FOR_4X||'_*'||NUM_FOR_4Y||'_*'||NIT_5||'_*'||NIT_5X||'_*'||NIT_5Y||'_*'||DV_6||'_*'||DV_6X||'_*'||DV_6Y||'_*'||EMPRESA_11||'_*'||EMPRESA_11X||'_*'||
        EMPRESA_11Y||'_*'||TIPO_24||'_*'||TIPO_24X||'_*'||TIPO_24Y||'_*'||CEDULA_25||'_*'||CEDULA_25X||'_*'||CEDULA_25Y||'_*'||PRIMER_APE_26||'_*'||PRIMER_APE_26X||'_*'||PRIMER_APE_26Y||
        '_*'||SEG_APE_27||'_*'||SEG_APE_27X||'_*'||SEG_APE_27Y||'_*'||PRIMER_NOM_28||'_*'||PRIMER_NOM_28X||'_*'||PRIMER_NOM_28Y||'_*'||SEG_NOM_29||'_*'||SEG_NOM_29X||'_*'||SEG_NOM_29Y||
        '_*'||ANO_F_INI_30||'_*'||ANO_F_INI_30X||'_*'||ANO_F_INI_30Y||'_*'||MES_F_INI_30||'_*'||MES_F_INI_30X||'_*'||MES_F_INI_30Y||'_*'||DIA_F_INI_30||'_*'||DIA_F_INI_30X||'_*'||DIA_F_INI_30Y||'_*'||
        ANO_F_FIN_31||'_*'||ANO_F_FIN_31X||'_*'||ANO_F_FIN_31Y||'_*'||MES_F_FIN_31||'_*'||MES_F_FIN_31X||'_*'||MES_F_FIN_31Y||'_*'||DIA_F_FIN_31||'_*'||DIA_F_FIN_31X||'_*'||DIA_F_FIN_31Y||'_*'||
        ANO_F_EXP_32||'_*'||ANO_F_EXP_32X||'_*'||ANO_F_EXP_32Y||'_*'||MES_F_EXP_32||'_*'||MES_F_EXP_32X||'_*'||MES_F_EXP_32Y||'_*'||DIA_F_EXP_32||'_*'||DIA_F_EXP_32X||'_*'||DIA_F_EXP_32Y||'_*'||
        LUGAR_EXPEDICION_33||'_*'||LUGAR_EXPEDICION_33X||'_*'||LUGAR_EXPEDICION_33Y||'_*'||COD_DEP_34||'_*'||COD_DEP_34X||'_*'||COD_DEP_34Y||'_*'||COD_CIU_MUNI_35||'_*'||COD_CIU_MUNI_35X||
        '_*'||COD_CIU_MUNI_35Y||'_*'||NUM_AGENCI_36||'_*'||NUM_AGENCI_36X||'_*'||NUM_AGENCI_36Y||'_*'||SALARIOS_37||'_*'||SALARIOS_37Y||'_*'||CESANTIAS_38||'_*'||CESANTIAS_38Y||'_*'||
        GASTOSREPRE_39||'_*'||GASTOSREPRE_39Y||'_*'||PENSIONES_40||'_*'||PENSIONES_40Y||'_*'||OTROS_ING_41||'_*'||OTROS_ING_41Y||'_*'||TOTAL_ING_42||'_*'||TOTAL_ING_42Y||'_*'||
        APOR_SALUD_43||'_*'||APOR_SALUD_43Y||'_*'||PENSION_SOLIDARIDAD_44||'_*'||PENSION_SOLIDARIDAD_44Y||'_*'||VOLUNTARIAS_45||'_*'||VOLUNTARIAS_45Y||'_*'||RETENCION_46||'_*'||
        RETENCION_46Y||'_*'||NOM_PAGADOR||'_*'||NOM_PAGADORX||'_*'||NOM_PAGADORY||'_*'||NOM_RET||'_*'||NOM_RETX||'_*'||NOM_RETY);
        
        --TRAE LOS AÑOS QUE SE VISUALIZAN EN LA APLICACION.
        FECHAS := ' ';
        OPEN FECHA_DINAMINCA;
        Loop
            FETCH FECHA_DINAMINCA INTO FECHAS;
            EXIT WHEN FECHA_DINAMINCA%NOTFOUND;
            --ANOCERTI := Fec_din.ANOCERTI;                    
            v_anos := v_anos||FECHAS||'_*';    
        End Loop;  
        CLOSE FECHA_DINAMINCA;
        BLOQUE1 := CERTIFICADO;
        v_anos1 := TRIM ( '*' FROM v_anos); 
        BLOQUE2 := TRIM ( '_' FROM v_anos1); 
    END IF;
END TW_PC_CERT_INGRESOS1;