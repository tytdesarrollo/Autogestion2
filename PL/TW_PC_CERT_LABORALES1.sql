create or replace PROCEDURE         TW_PC_CERT_LABORALES1   
/***********************************OBJETIVO: GENERA LOS CERTIFICADOS LABORALES ************************************

-- PARAMETROS DE ENTRADA
   -- CODIGO_EPL          : CODIGO DEL EMPLEADO
   -- TIPO                : TIPO DE CERTIFICADO (NORMAL CON SALARIO Ó NORMAL SIN SALARIO)   
                            1 CON SALARIO
                            2 SIN SALARIO                            
   -- DESTINATARIO     : A QUIEN VA DIRIGIDO EL CERTIFICADO  
   -- CREADO POR       : NELSON GALEANO
   
   _*  SEPARADOR DE VARIABLES

************************************  DECLARACION DE VARIABLE  ************************************************************ */
(
    CODIGO_EPL IN EMPLEADOS_BASIC.COD_EPL%TYPE, 
    TIPO IN VARCHAR2, 
    DESTINATARIO IN VARCHAR2,                                                                                                           
    BLOQUEA OUT VARCHAR2, --Encabezado del Certificado
    BLOQUET OUT VARCHAR2, --Titulo del certificado
    BLOQUEB OUT CLOB, -- Cuerpo del mensaje
    BLOQUEC OUT VARCHAR2 -- Firma y cargo del certificado    
)
IS

FAX                           EMPRESAS.FAX%TYPE;
EMPRESA_REAL                  EMPRESAS.NOM_EMP%TYPE;
NIT_REAL                      VARCHAR2(50);
NOM_CIU                       CIUDADES.NOM_CIU%TYPE;
TEL_1                         EMPRESAS.TEL_1%TYPE;
SEXO                          EMPLEADOS_GRAL.SEXO%TYPE; 
NOMBRE_EPL                    VARCHAR2(150);
CEDULA                        EMPLEADOS_BASIC.CEDULA%TYPE;
SAL_BAS                       EMPLEADOS_BASIC.SAL_BAS%TYPE;
NOM_CAR                       CARGOS.NOM_CAR%TYPE;
INI_CTO                       VARCHAR2(10);
FEC_RET                       EMPLEADOS_BASIC.FEC_RET%TYPE;
VTO_CTO                       EMPLEADOS_BASIC.VTO_CTO%TYPE;
F_VENCI                       VARCHAR2(100);
TIP_DOC                       EMPLEADOS_BASIC.TIPO_DOC%TYPE;
TIP_DOC2                      VARCHAR(50);
NOM_CTO                       CONTRATOS.NOM_CTO%TYPE;
TIPO_CONTRATO                 VARCHAR2(20);
CADENA6                       VARCHAR2(150);
CADENA7                       VARCHAR2(150);
CADENA8                       VARCHAR2(150);
DIA                           INTEGER;
MES                           INTEGER;             
AÑO                           INTEGER;    
NOM_MES                       VARCHAR2(20);     
SALARIO                       VARCHAR2(100);
XVALOR                        VARCHAR2(150);
VOk                           VARCHAR2(200);
ENCABEZA1                     VARCHAR2(150); 
ENCABEZA2                     VARCHAR2(150);
ENCABEZA3                     VARCHAR2(150); 
ENCABEZA4                     VARCHAR2(150); 
ENCABEZA5                     VARCHAR2(150);
CANTIDAD2                     INTEGER;
TITULO1                       VARCHAR2(150);          
TITULO2                       VARCHAR2(150);
FIRMA                         VARCHAR2(100);  
CARGO                         VARCHAR2(100);

BEGIN
    
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------- CERTIFICADO NORMAL CON SALARIO ---------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
    IF (TIPO='1') THEN                            
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
        
        BLOQUEA := (EMPRESA_REAL||'<BR>'||NIT_REAL||'<BR>'||ENCABEZA1||'<BR>'||ENCABEZA2||'<BR>'||ENCABEZA3||'<BR>'||ENCABEZA4||'<BR>'||ENCABEZA5);      
                                            
        BLOQUET := '<BR>'||TITULO1||'<BR><BR>'||TITULO2;
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
            
            CASE MES
                WHEN '1' THEN NOM_MES := 'Enero';
                WHEN '2' THEN NOM_MES := 'Febrero';    
                WHEN '3' THEN NOM_MES := 'Marzo';
                WHEN '4' THEN NOM_MES := 'Abril';
                WHEN '5' THEN NOM_MES := 'Mayo';
                WHEN '6' THEN NOM_MES := 'Junio';
                WHEN '7' THEN NOM_MES := 'Julio';
                WHEN '8' THEN NOM_MES := 'Agosto';
                WHEN '9' THEN NOM_MES := 'Septiembre';
                WHEN '10' THEN NOM_MES := 'Octubre';
                WHEN '11' THEN NOM_MES := 'Noviembre';
                ELSE NOM_MES := 'Diciembre';
            END CASE;   
        END;
        
        BLOQUEB := ('LA DIRECCIÓN GESTIÓN DE RECURSOS HUMANOS certifica que <B>'||NOMBRE_EPL||'</B> con <B>'||TIP_DOC2||' No. '||CEDULA||'</B>, se encuentra vinculado(a) para la compañía desde el '||INI_CTO||F_VENCI||', con un contrato de '||CADENA8||', en el cargo de <B>'||NOM_CAR||'</B> con '||CADENA7||' de <B>'||VOk||XVALOR||'($'||SALARIO||') </B>'|| CADENA6||'</BR>'
        ||'<BR><BR><BR>'||'La presente certificación se expide a solicitud del interesado a los '||DIA||' dias del mes de '||NOM_MES||' de '||AÑO||' para ser presentado a '||DESTINATARIO||'.'||'<BR><BR><BR>'||'Para confirmar este certificado, comuniquese con la linea unica nacional 018000361645.'||'<BR><BR><BR><BR><BR>'||'Cordialmente,');
         
        BEGIN
            SELECT var_carac, descripcion
            INTO FIRMA, CARGO 
            FROM parametros_nue 
            WHERE nom_var = 't_epl_fir_cer_lab';
        END;        
        
        BLOQUEC := ('<B>'||FIRMA||'</B>'||'<BR>'||CARGO);           
    ELSE
        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        ----------------------------------------------------------------- CERTIFICADO NORMAL SIN SALARIO ---------------------------------------------------------------------------------------------------------------------------------------
        ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------            
        IF (TIPO='2') THEN              
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
            
            BLOQUEA := (EMPRESA_REAL||'<BR>'||NIT_REAL||'<BR>'||ENCABEZA1||'<BR>'||ENCABEZA2||'<BR>'||ENCABEZA3||'<BR>'||ENCABEZA4||'<BR>'||ENCABEZA5);      
                                                
            BLOQUET := '<BR>'||TITULO1||'<BR><BR>'||TITULO2;
                                            
            BEGIN 
                --DATOS DEL EMPLEADO
                SELECT c.SEXO, NOM_EPL||' '||APE_EPL,CEDULA,SAL_BAS,NOM_CAR,TO_CHAR(INI_CTO,'DD-MM-YYYY'), TO_CHAR(FEC_RET,'DD-MM-YYYY'), 
                TO_CHAR(VTO_CTO,'DD-MM-YYYY'),a.TIPO_DOC, CON.NOM_CTO 
                INTO SEXO, NOMBRE_EPL, CEDULA, SAL_BAS, NOM_CAR, INI_CTO, FEC_RET, VTO_CTO, TIP_DOC, NOM_CTO
                from empleados_basic a, cargos b, empleados_gral c, contratos con 
                where a.cod_car = b.cod_car 
                and a.cod_epl = c.cod_epl 
                and A.ESTADO = 'A' 
                AND a.cod_epl = CODIGO_EPL 
                and A.COD_CTO = CON.COD_CTO;
                                    
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
                
                CASE MES
                    WHEN '1' THEN NOM_MES := 'Enero';
                    WHEN '2' THEN NOM_MES := 'Febrero';    
                    WHEN '3' THEN NOM_MES := 'Marzo';
                    WHEN '4' THEN NOM_MES := 'Abril';
                    WHEN '5' THEN NOM_MES := 'Mayo';
                    WHEN '6' THEN NOM_MES := 'Junio';
                    WHEN '7' THEN NOM_MES := 'Julio';
                    WHEN '8' THEN NOM_MES := 'Agosto';
                    WHEN '9' THEN NOM_MES := 'Septiembre';
                    WHEN '10' THEN NOM_MES := 'Octubre';
                    WHEN '11' THEN NOM_MES := 'Noviembre';
                    ELSE NOM_MES := 'Diciembre';
                END CASE;   
            END;
            
            BLOQUEB := ('LA DIRECCIÓN GESTIÓN DE RECURSOS HUMANOS certifica que <B>'||NOMBRE_EPL||'</B> con <B>'||TIP_DOC2||' No. '||CEDULA||'</B>, se encuentra vinculado(a) para la compañía desde el '||INI_CTO||F_VENCI||', con un contrato de '||CADENA8||', en el cargo de <B>'||NOM_CAR||'</B>.'
            ||'<BR><BR><BR>'||'La presente certificación se expide a solicitud del interesado a los '||DIA||' dias del mes de '||NOM_MES||' de '||AÑO||' para ser presentado a '||DESTINATARIO||'.'||'<BR><BR><BR><BR>'||'Para confirmar este certificado, comuniquese con la linea unica nacional 018000361645.'||'<BR><BR><BR><BR><BR>'||'Cordialmente,');

            BEGIN
                SELECT var_carac, descripcion
                INTO FIRMA, CARGO 
                FROM parametros_nue 
                WHERE nom_var = 't_epl_fir_cer_lab';
            END;
            
            BLOQUEC := ('<B>'||FIRMA||'</B><BR>'||CARGO);    

        END IF;
    END IF;      
END TW_PC_CERT_LABORALES1;