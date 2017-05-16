create or replace PROCEDURE         TW_PC_CERT_LABORALES1(CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE, TIPO IN VARCHAR2, DESTINATARIO IN VARCHAR2, BLOQUE IN VARCHAR2, 
                                                                                                            BLOQUEA OUT VARCHAR2)

/*
 ************************OBJETIVO: GENERA LOS CERTIFICADOS LABORALES ************************************

-- PARAMETROS DE ENTRADA
   -- CODIGO_EPL          : CODIGO DEL EMPLEADO
   -- TIPO                     : TIPO DE CERTIFICADO (NORMAL CON SALARIO Ó NORMAL SIN SALARIO)   
   -- DESTINATARIO     : A QUIEN VA DIRIGIDO EL CERTIFICADO  
   -- BLOQUE                ; A PARA ENCABEZADO, B PARA EL CUERPO, C PARA FIRMA Y CARGO 

   -- CREADO POR       : NELSON GALEANO
   
   _*  SEPARADOR DE VARIABLES

************************************  DECLARACION DE VARIABLE  ************************************************************ */
IS

FAX                                                    EMPRESAS.FAX%TYPE;
EMPRESA_REAL                                   EMPRESAS.NOM_EMP%TYPE;
NIT_REAL                                           VARCHAR2(50);
NOM_CIU                                            CIUDADES.NOM_CIU%TYPE;
TEL_1                                                 EMPRESAS.TEL_1%TYPE;
SEXO                                                  EMPLEADOS_GRAL.SEXO%TYPE; 
NOMBRE_EPL                                       VARCHAR2(150);
CEDULA                                               EMPLEADOS_BASIC.CEDULA%TYPE;
SAL_BAS                                             EMPLEADOS_BASIC.SAL_BAS%TYPE;
NOM_CAR                                            CARGOS.NOM_CAR%TYPE;
INI_CTO                                              EMPLEADOS_BASIC.INI_CTO%TYPE;
FEC_RET                                             EMPLEADOS_BASIC.FEC_RET%TYPE;
VTO_CTO                                            EMPLEADOS_BASIC.VTO_CTO%TYPE;
F_VENCI                                             VARCHAR2(100);
TIP_DOC                                             EMPLEADOS_BASIC.TIPO_DOC%TYPE;
TIP_DOC2                                            VARCHAR(50);
NOM_CTO                                           CONTRATOS.NOM_CTO%TYPE;
TIPO_CONTRATO                                 VARCHAR2(20);
CADENA6                                             VARCHAR2(150);
CADENA7                                             VARCHAR2(150);
CADENA8                                             VARCHAR2(150);
DIA                                                      INTEGER;
MES                                                     INTEGER;             
AÑO                                                     INTEGER;    
NOM_MES                                            VARCHAR2(20);     
SALARIO                                              VARCHAR2(100);
XVALOR                                               VARCHAR2(150);
VOk                                                     VARCHAR2(200);
ENCABEZA1                                          VARCHAR2(150); 
ENCABEZA2                                          VARCHAR2(150);
ENCABEZA3                                           VARCHAR2(150); 
ENCABEZA4                                           VARCHAR2(150); 
ENCABEZA5                                           VARCHAR2(150);
CANTIDAD2                                           INTEGER;
TITULO1                                               VARCHAR2(150);          
TITULO2                                               VARCHAR2(150);

FIRMA                                                 VARCHAR2(100);  
CARGO                                                VARCHAR2(100);
CORDIALMENTE                                    VARCHAR2(50);  

BEGIN
    
        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        ----------------------------------------------------------------- CERTIFICADO NORMAL CON SALARIO ---------------------------------------------------------------------------------------------------------------------------------------
        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
        IF (TIPO='1') THEN 
        
            IF (BLOQUE='A') THEN -- CABECERA Y TITULO DEL CERTIFICADO
                
                BEGIN                    
                    SELECT P.NOM_EMP, P.NIT_EMP||' - '||P.DIGITO_VER
                    INTO EMPRESA_REAL, NIT_REAL
                    FROM EMPLEADOS_BASIC E, EMPRESAS P
                    WHERE E.COD_EMP=P.COD_EMP AND E.COD_EPL=CODIGO_EPL;
                END;                
                
                BEGIN
                    SELECT COUNT(*)+1 
                    INTO CANTIDAD2
                    FROM LOG_CERTIFICADOS;
                END;
                
                ENCABEZA1 := 'Transv. 60 (Av. Suba) No. 114 A-55';
                ENCABEZA2 := 'Bogotá D.C. - Colombia';
                ENCABEZA3 := 'LÍnea Única Nacional 018000361645';
                ENCABEZA4 := 'www.telefonica.co';
                ENCABEZA5 := 'Consecutivo: 000'||CANTIDAD2;
                TITULO1 := '<B>DIRECCIÓN GESTIÓN DE RECURSOS HUMANOS</B>';
                TITULO2 := '<B>CERTIFICACIÓN</B>';
                
                BLOQUEA := (EMPRESA_REAL||'_*'||NIT_REAL||'_*'||ENCABEZA1||'_*'||ENCABEZA2||'_*'||ENCABEZA3||'_*'||ENCABEZA4||'_*'||ENCABEZA5||'_*'||TITULO1||'_*'||TITULO2);      
            END IF;        
           
            IF (BLOQUE='B') THEN -- CUERPO DEL CERTIFICADO 
                            
                BEGIN 
                    --DATOS DEL EMPLEADO
                    select c.SEXO, NOM_EPL||' '||APE_EPL,CEDULA,SAL_BAS,NOM_CAR,TO_CHAR(INI_CTO,'DD-MM-YYYY'), TO_CHAR(FEC_RET,'DD-MM-YYYY'), 
                    TO_CHAR(VTO_CTO,'DD-MM-YYYY'),a.TIPO_DOC, CON.NOM_CTO 
                    INTO SEXO, NOMBRE_EPL, CEDULA, SAL_BAS, NOM_CAR, INI_CTO, FEC_RET, VTO_CTO, TIP_DOC, NOM_CTO
                    from empleados_basic a, cargos b, empleados_gral c, contratos con 
                    where a.cod_car=b.cod_car and a.cod_epl=c.cod_epl and A.ESTADO='A' AND a.cod_epl=CODIGO_EPL and A.COD_CTO=CON.COD_CTO;
                    
                    VOk :=  ImportEnLetras(SAL_BAS); -- LLAMO LA FUNCION PARA CONVERTIR NUMEROS EN LETRAS
                  
                    VOk := (UPPER(VOk));                
                    SALARIO := (TO_CHAR (SAL_BAS, '999G999G999'));
                    SALARIO := TRIM(SALARIO);
                    XVALOR := TRIM(SAL_BAS);
                    
                    IF (XVALOR < 1) THEN
                        XVALOR := ' CERO PESOS ';
                        ELSE
                        IF (XVALOR >= 1 ) AND (XVALOR <= 2) THEN
                            XVALOR := ' UN PESO ';
                            ELSE
                            IF (XVALOR >=2) THEN
                                XVALOR := ' PESOS M/CTE ';
                            END IF;                                
                        END IF;                                 
                    END IF;
                                                            
                    IF (TIP_DOC='C') THEN
                        TIP_DOC2 := 'cedula de ciudadania ';
                        ELSE
                        IF (TIP_DOC='E')THEN
                            TIP_DOC2 := 'cedula de extranjeria';
                            ELSE
                            IF (TIP_DOC='T') THEN
                                TIP_DOC2 := 'tarjeta de identidad';
                            END IF;
                        END IF;               
                    END IF;       
                    
                    IF VTO_CTO IS NOT NULL THEN
                        F_VENCI := ' hasta el '||VTO_CTO;
                    END IF;                          
                END;
                
                BEGIN                
                    SELECT CASE WHEN COD_GRU='2' THEN 'INTEGRAL' WHEN COD_GRU='1' THEN 'BÁSICO' WHEN COD_GRU IN('3','5') THEN 'APRENDICES' END
                    INTO TIPO_CONTRATO                
                    FROM EPL_GRUPOS
                    WHERE COD_EPL=CODIGO_EPL AND COD_GRU IN (1,2);
                    
                    IF (TIPO_CONTRATO='INTEGRAL') THEN
                        CADENA6 := ' bajo la modalidad de <B>SALARIO INTEGRAL.</B>';
                        CADENA7 := ' una asignacion salarial mensual';
                        CADENA8 := ' trabajo a termino <B>'||NOM_CTO||'/B';
                        ELSE
                        IF (TIPO_CONTRATO='APRENDICES') THEN
                            CADENA6 := ' bajo la modalidad de <B>APOYO DE SOSTENIMIENTO.</B>';
                            CADENA7 := ' asignacion mensual ';
                            CADENA8 := 'B'||NOM_CTO||'/B';      
                            ELSE
                            IF (TIPO_CONTRATO='BÁSICO') THEN
                                CADENA6 := ' bajo la modalidad de <B>SALARIO BASICO.</B>';
                                CADENA7 := ' una asignacion salarial mensual ';
                                CADENA8 := ' trabajo a termino <B>'||NOM_CTO||'</B>';
                            END IF;                                                                                  
                        END IF;                                           
                    END IF;                    
                END;
                
                BEGIN                                      
                    --FECHA INICIO
                    DIA := EXTRACT (DAY FROM SYSDATE);
                    MES := EXTRACT (MONTH FROM SYSDATE);                        
                    AÑO := EXTRACT (YEAR FROM SYSDATE);
                    
                    IF (MES='1')THEN
                        NOM_MES := 'Enero';
                        ELSE
                        IF (MES='2')THEN
                            NOM_MES := 'Febrero';
                            ELSE
                            IF (MES='3')THEN
                                NOM_MES := 'Marzo';
                                ELSE
                                IF (MES='4')THEN
                                     NOM_MES := 'Abril';
                                     ELSE
                                     IF (MES='5') THEN
                                        NOM_MES := 'Mayo';
                                        ELSE
                                        IF (MES='6') THEN
                                            NOM_MES := 'Junio';
                                            ELSE
                                            IF (MES='7') THEN
                                                NOM_MES := 'Julio';
                                                ELSE
                                                IF (MES='8') THEN
                                                    NOM_MES := 'Agosto';
                                                    ELSE
                                                    IF (MES='9') THEN
                                                        NOM_MES := 'Septiembre';
                                                        ELSE
                                                        IF (MES='10') THEN
                                                            NOM_MES := 'Octubre';
                                                            ELSE
                                                            IF (MES='11') THEN
                                                                NOM_MES := 'Noviembre';
                                                                ELSE
                                                                IF (MES='12') THEN
                                                                    NOM_MES := 'Diciembre';
                                                                END IF;                                                                    
                                                            END IF;                                                                    
                                                        END IF;                                                                    
                                                    END IF;                                                                        
                                                END IF;                                                                    
                                            END IF;                                                                    
                                        END IF;                                                                    
                                    END IF;                                                                                                                                        
                                END IF;         
                            END IF;                                
                        END IF;                        
                    END IF;
                END;
                
                BLOQUEA := ('LA DIRECCION GESTION DE RECURSOS HUMANOS certifica que <B>'||NOMBRE_EPL||'</B> con <B>'||TIP_DOC2||' No. '||CEDULA||'</B>, se encuentra vinculado(a) para la compañia desde el '||INI_CTO||F_VENCI||', con un contrato de '||CADENA8||', en el cargo de <B>'||NOM_CAR||'</B> con '||CADENA7||' de <B>'||VOk||XVALOR||'($'||SALARIO||') </B>'|| CADENA6||'</BR>'
                ||'</BR>'||'La presente certificacion se expide a solicitud del interesado a los '||DIA||' dias del mes de '||NOM_MES||' de '||AÑO||' para ser presentado a '||DESTINATARIO||'.'||'</BR>'||'</BR>'||'Para confirmar este certificado, comuniquese con la linea unica nacional 018000361645.');
             
            END IF;
             
            IF (BLOQUE='C') THEN            
                BEGIN
                    SELECT var_carac, descripcion
                    INTO FIRMA, CARGO 
                    FROM parametros_nue 
                    WHERE nom_var = 't_epl_fir_cer_lab';
                END;
                CORDIALMENTE := 'Cordialmente,';
                
                BLOQUEA := (CORDIALMENTE||'<BR>'||'<B>'||FIRMA||'</B>'||'<BR>'||chr(13)||CARGO);        
            END IF;        
            
            ELSE
            ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------- CERTIFICADO NORMAL SIN SALARIO ---------------------------------------------------------------------------------------------------------------------------------------
            ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------            
            IF (TIPO='2') THEN  

                IF (BLOQUE='A') THEN -- CABECERA Y TITULO DEL CERTIFICADO
                    
                    BEGIN                    
                        SELECT P.NOM_EMP, P.NIT_EMP||' - '||P.DIGITO_VER
                        INTO EMPRESA_REAL, NIT_REAL
                        FROM EMPLEADOS_BASIC E, EMPRESAS P
                        WHERE E.COD_EMP=P.COD_EMP AND E.COD_EPL=CODIGO_EPL;
                    END;                    
                    
                    BEGIN
                        SELECT COUNT(*)+1 
                        INTO CANTIDAD2
                        FROM LOG_CERTIFICADOS;
                    END;
                    
                    ENCABEZA1 := 'Transv. 60 (Av. Suba) No. 114 A-55';
                    ENCABEZA2 := 'Bogotá D.C. - Colombia';
                    ENCABEZA3 := 'LÍnea Única Nacional 018000361645';
                    ENCABEZA4 := 'www.telefonica.co';
                    ENCABEZA5 := 'Consecutivo: 000'||CANTIDAD2;
                    TITULO1 := '<B>DIRECCIÓN GESTIÓN DE RECURSOS HUMANOS</B>';
                    TITULO2 := '<B>CERTIFICACIÓN</B>';
                    
                    BLOQUEA := (EMPRESA_REAL||'_*'||NIT_REAL||'_*'||ENCABEZA1||'_*'||ENCABEZA2||'_*'||ENCABEZA3||'_*'||ENCABEZA4||'_*'||ENCABEZA5||'_*'||TITULO1||'_*'||TITULO2);            
                
                END IF;        
               
                IF (BLOQUE='B') THEN -- CUERPO DEL CERTIFICADO 
                                
                    BEGIN 
                        --DATOS DEL EMPLEADO
                        select c.SEXO, NOM_EPL||' '||APE_EPL,CEDULA,SAL_BAS,NOM_CAR,TO_CHAR(INI_CTO,'DD-MM-YYYY'), TO_CHAR(FEC_RET,'DD-MM-YYYY'), 
                        TO_CHAR(VTO_CTO,'DD-MM-YYYY'),a.TIPO_DOC, CON.NOM_CTO 
                        INTO SEXO, NOMBRE_EPL, CEDULA, SAL_BAS, NOM_CAR, INI_CTO, FEC_RET, VTO_CTO, TIP_DOC, NOM_CTO
                        from empleados_basic a, cargos b, empleados_gral c, contratos con 
                        where a.cod_car=b.cod_car and a.cod_epl=c.cod_epl and A.ESTADO='A' AND a.cod_epl=CODIGO_EPL and A.COD_CTO=CON.COD_CTO;
                                            
                        IF (TIP_DOC='C') THEN
                            TIP_DOC2 := 'cedula de ciudadania ';
                            ELSE
                            IF (TIP_DOC='E')THEN
                                TIP_DOC2 := 'cedula de extranjeria';
                                ELSE
                                IF (TIP_DOC='T') THEN
                                    TIP_DOC2 := 'tarjeta de identidad';
                                END IF;
                            END IF;               
                        END IF;       
                        
                        IF VTO_CTO IS NOT NULL THEN
                            F_VENCI := ' hasta el '||VTO_CTO;
                        END IF;                          
                    END;
                    
                    BEGIN                
                        SELECT CASE WHEN COD_GRU='2' THEN 'INTEGRAL' WHEN COD_GRU='1' THEN 'BÁSICO' WHEN COD_GRU IN('3','5') THEN 'APRENDICES' END
                        INTO TIPO_CONTRATO                
                        FROM EPL_GRUPOS
                        WHERE COD_EPL=CODIGO_EPL AND COD_GRU IN (1,2);
                        
                        IF (TIPO_CONTRATO='INTEGRAL') THEN
                            CADENA8 := ' trabajo a termino <B>'||NOM_CTO||'</B>';
                            ELSE                            
                            IF (TIPO_CONTRATO='APRENDICES') THEN
                                CADENA8 := '<B>'||NOM_CTO||'</B>';      
                                ELSE
                                IF (TIPO_CONTRATO='BÁSICO') THEN
                                    CADENA8 := ' trabajo a termino <B>'||NOM_CTO||'</B>';
                                END IF;                                                                                  
                            END IF;                                           
                        END IF;                    
                    END;
                    
                    BEGIN                                      
                        --FECHA INICIO
                        DIA := EXTRACT (DAY FROM SYSDATE);
                        MES := EXTRACT (MONTH FROM SYSDATE);                        
                        AÑO := EXTRACT (YEAR FROM SYSDATE);
                        
                        IF (MES='1')THEN
                            NOM_MES := 'Enero';
                            ELSE
                            IF (MES='2')THEN
                                NOM_MES := 'Febrero';
                                ELSE
                                IF (MES='3')THEN
                                    NOM_MES := 'Marzo';
                                    ELSE
                                    IF (MES='4')THEN
                                         NOM_MES := 'Abril';
                                         ELSE
                                         IF (MES='5') THEN
                                            NOM_MES := 'Mayo';
                                            ELSE
                                            IF (MES='6') THEN
                                                NOM_MES := 'Junio';
                                                ELSE
                                                IF (MES='7') THEN
                                                    NOM_MES := 'Julio';
                                                    ELSE
                                                    IF (MES='8') THEN
                                                        NOM_MES := 'Agosto';
                                                        ELSE
                                                        IF (MES='9') THEN
                                                            NOM_MES := 'Septiembre';
                                                            ELSE
                                                            IF (MES='10') THEN
                                                                NOM_MES := 'Octubre';
                                                                ELSE
                                                                IF (MES='11') THEN
                                                                    NOM_MES := 'Noviembre';
                                                                    ELSE
                                                                    IF (MES='12') THEN
                                                                        NOM_MES := 'Diciembre';
                                                                    END IF;                                                                    
                                                                END IF;                                                                    
                                                            END IF;                                                                    
                                                        END IF;                                                                        
                                                    END IF;                                                                    
                                                END IF;                                                                    
                                            END IF;                                                                    
                                        END IF;                                                                                                                                        
                                    END IF;         
                                END IF;                                
                            END IF;                        
                        END IF;
                    END;
                    
                    BLOQUEA := ('LA DIRECCION GESTION DE RECURSOS HUMANOS certifica que <B>'||NOMBRE_EPL||'</B> con <B>'||TIP_DOC2||' No. '||CEDULA||'</B>, se encuentra vinculado(a) para la compañia desde el '||INI_CTO||F_VENCI||', con un contrato de '||CADENA8||', en el cargo de <B>'||NOM_CAR||'</B>.'
                    ||'<BR>'||'<BR>'||'La presente certificacion se expide a solicitud del interesado a los '||DIA||' dias del mes de '||NOM_MES||' de '||AÑO||' para ser presentado a '||DESTINATARIO||'.'||'<BR>'||'<BR>'||'Para confirmar este certificado, comuniquese con la linea unica nacional 018000361645.');
                 
                END IF;
                 
                IF (BLOQUE='C') THEN            
                    BEGIN
                        SELECT var_carac, descripcion
                        INTO FIRMA, CARGO 
                        FROM parametros_nue 
                        WHERE nom_var = 't_epl_fir_cer_lab';
                    END;
                    CORDIALMENTE := 'Cordialmente,';
                    
                    BLOQUEA := (CORDIALMENTE||chr(13)||FIRMA||chr(13)||CARGO);        
                END IF;
            END IF;
        END IF;      
          

END TW_PC_CERT_LABORALES1;