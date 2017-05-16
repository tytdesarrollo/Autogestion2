create or replace PROCEDURE         TW_PC_IDENTITY (ID_LOGIN IN EMPLEADOS_BASIC.CEDULA%TYPE, IN_PASS IN VARCHAR2, OPERACION IN VARCHAR2,KEY_ACT IN VARCHAR2,
                                                     EMPLOYEE_ID OUT EMPLEADOS_BASIC.CEDULA%TYPE, OUTPUT OUT NUMBER, MESSAGE OUT VARCHAR2 ) IS

/******************************************************************************
   NAME:       TW_IDENTITY
   PURPOSE:    

   REVISIONS:
   Ver        Date        Author           Description
   ---------  ----------  ---------------  ------------------------------------
   1.0        25/08/2016          1. Created this procedure.

   NOTES:
    VARIABLES DE ENTRADA
        ID_LOGIN        Identificador de Usuario
        PASS            Clave de Acceso
        OPERACION       L-Logeo Usuario Creado, C-Crea Usuario y Contraseña
                        U-Actualiza clave de usuario existente
        KEY_ACT         Llave para activar clave cuando se crea o actualiza
    VARIABLES DE SALIDA
        EMPLOYEE_ID     Identificador (Cedula) del empleado que se conecto
        OUTPUT          Numero de la salida, si es negativo se puede identificar como un error
        MESSAGE         Mensaje de ayuda de salida o errror
        
******************************************************************************/

QUANTITY            NUMBER;                             --Variable como validador de existencia
LAST_LOG            DATE;                               --Fecha de creación o cambio de clave
NUMB_LOG            TW_TB_IDENTITY.NUM_ATP%TYPE;        --Número de intentos de logeo
REG_PASS            TW_TB_IDENTITY.PASS%TYPE;           --Clave registrada
KEY_PASS            TW_TB_IDENTITY.NUM_REC%TYPE;        --Llave generada para activación de clave
USER_ADMIN          PARAMETROS_NUE.VAR_CARAC%TYPE;      --Usuario Administrador del sistema.
CORREO              EMPLEADOS_GRAL.EMAIL%TYPE;          --Correo para envío de claves de activación.
TOKEN               VARCHAR(800);
MENSAJE VARCHAR2(9000);
  
BEGIN
    
    IF OPERACION = 'T' THEN
        QUANTITY    := 0;  
        LAST_LOG    := NULL;
        EMPLOYEE_ID := NULL;
        REG_PASS    := NULL; 
        OUTPUT      := -20000;
        MESSAGE     := 'Error de Logeo';    
        
        BEGIN
            SELECT COD_EPL INTO EMPLOYEE_ID
            FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A' AND ROWNUM =1;
                    
            EXCEPTION WHEN NO_DATA_FOUND THEN
                EMPLOYEE_ID         :=      NULL;
                OUTPUT              :=      -20001;
                MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';    
        END;
        
        IF EMPLOYEE_ID IS NOT NULL THEN
            /*Validamos si el usuario ingresado ya esta registrado, de lo contrario debe crear una contraseña */
            SELECT COUNT(*) INTO QUANTITY
            FROM TW_TB_IDENTITY WHERE ID_USER = ENCRIPTA.ENCRIP(EMPLOYEE_ID);
                    
            IF QUANTITY = 0 THEN
                BEGIN
                    EMPLOYEE_ID := ID_LOGIN;
                    OUTPUT      := 0;
                    MESSAGE     := 'El usuario '||ID_LOGIN||' no existe, debe crearlo y asignar una contraseña segura';
                END; 
            ELSE 
                BEGIN
                    SELECT NUM_REC, DATE_MOD INTO REG_PASS, LAST_LOG
                    FROM TW_TB_IDENTITY
                    WHERE ID_USER = ENCRIPTA.ENCRIP(EMPLOYEE_ID);
                
                    EXCEPTION 
                        WHEN OTHERS THEN
                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                END;
                
                IF REG_PASS = KEY_ACT THEN
                    
                    IF TO_DATE (LAST_LOG, 'DD-MM-YYYY')+5 >= TO_DATE (SYSDATE, 'DD-MM-YYYY') THEN                    
                        
                            EMPLOYEE_ID         :=      ID_LOGIN;
                            OUTPUT              :=      10;
                            MESSAGE             :=      'Acceso correcto, por favor cree una clave para su cuenta';                        
                    ELSE
                        EMPLOYEE_ID         :=      NULL;
                        OUTPUT              :=      11;
                        MESSAGE             :=      'Su periodo de activación ha caducado, por favor genere una nueva solicitud';
                    END IF;
                    
                ELSE
                    EMPLOYEE_ID         :=      NULL;
                    OUTPUT              :=      12;
                    MESSAGE             :=      'Su link de activación no es valido';
                END IF;
            
            END IF;
        END IF;
        
    ELSE IF OPERACION ='F' THEN
        QUANTITY    := 0;  
        EMPLOYEE_ID := NULL;
        OUTPUT      := -20000;
        MESSAGE     := 'Error de Logeo';    
        
        BEGIN
            SELECT COD_EPL INTO EMPLOYEE_ID
            FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A' AND ROWNUM =1;
                    
            EXCEPTION WHEN NO_DATA_FOUND THEN
                EMPLOYEE_ID         :=      NULL;
                OUTPUT              :=      -20001;
                MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';    
        END;
        
        IF EMPLOYEE_ID IS NOT NULL THEN
                
            /*Se valida que no exista el usuario que se intenta crear*/
            SELECT COUNT(*) INTO QUANTITY FROM TW_TB_IDENTITY 
            WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                
            /*Si existe el usaurio sobre el cual se quiere modificar la contraseña continua el proceso, sino 
            informa que debe crear el usuario*/
            IF QUANTITY > 0 THEN
                /*Validamos la similitud de la contraseña ingresada con el historico de contraseñas usadas en los ultimos 6 meses,
                si coincide en mas de un 95%, se debe solicita que ingreso otro valor como contraseña*/
                BEGIN
                    SELECT MAX(UTL_MATCH.JARO_WINKLER_SIMILARITY(ENCRIPTA.DESCENCRIP(PASS),IN_PASS))
                    INTO QUANTITY FROM TW_TB_HIST_IDENTITY
                    WHERE ID_USER =ENCRIPTA.ENCRIP (EMPLOYEE_ID)
                    AND DATE_MOD BETWEEN SYSDATE-180 AND SYSDATE;
                        
                    EXCEPTION
                        WHEN NO_DATA_FOUND THEN
                            QUANTITY := 0;                            
                        WHEN OTHERS THEN
                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                END;
                                            
                IF QUANTITY >= 95 THEN
                    EMPLOYEE_ID :=  ID_LOGIN;
                    OUTPUT      :=  8;
                    MESSAGE     :=  'La clave ingresada, coincide en un '||QUANTITY||'% a alguna usada en los ultimos 6 meses, por favor digite una nueva';
                ELSE        
                                
                    BEGIN
                        UPDATE TW_TB_IDENTITY SET PASS =ENCRIPTA.ENCRIP (IN_PASS), DATE_MOD = SYSDATE, NUM_ATP =0,NUM_REC =NULL 
                        WHERE ID_USER=ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                            
                        EXCEPTION
                            WHEN OTHERS THEN
                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                    END;
                    
                    EMPLOYEE_ID :=  ID_LOGIN;
                    OUTPUT      :=  1;
                    MESSAGE     :=  'Acceso Correcto';
                    
                END IF;
                
            ELSE
                EMPLOYEE_ID         :=      NULL;
                OUTPUT              :=      -20001;
                MESSAGE             :=      'El usuario ingresado no existe o no esta activo en la nómina';    
            END IF;
        ELSE
            EMPLOYEE_ID         :=      NULL;
            OUTPUT              :=      -20001;
            MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';
        END IF;
    
    /*Valida usuario y clave de acceso a la web*/
    ELSE IF OPERACION ='L' THEN
        QUANTITY    := 0;
        LAST_LOG    := NULL;
        NUMB_LOG    := 0;
        REG_PASS    := NULL;    
        EMPLOYEE_ID := NULL;
        OUTPUT      := -20000;
        MESSAGE     := 'Error de Logeo';
        
        /*Devuelve el usuario administrador del sistema*/
        BEGIN
            SELECT VAR_CARAC INTO USER_ADMIN FROM PARAMETROS_NUE
            WHERE NOM_VAR ='t_adminweb';
                        
            EXCEPTION
                WHEN NO_DATA_FOUND THEN
                    USER_ADMIN  := NULL;
        END;
    
        /*Determina si el id_login(cedula) existe como empleado activo de la nómina*/
        SELECT COUNT(*) INTO QUANTITY 
        FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A';
        
        /*Si es el usuario administrador o un empleado con acceso, continua la validación de acceso*/
        IF (QUANTITY > 0) OR (ID_LOGIN = USER_ADMIN) THEN
            BEGIN
                IF ID_LOGIN = USER_ADMIN THEN
                    EMPLOYEE_ID := ID_LOGIN;
                ELSE
                    BEGIN
                        SELECT COD_EPL INTO EMPLOYEE_ID
                        FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A' AND ROWNUM =1;
                    
                        EXCEPTION WHEN NO_DATA_FOUND THEN
                            EMPLOYEE_ID         :=      NULL;
                            OUTPUT              :=      -20001;
                            MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';    
                    END;
                END IF;
                
                /*EL usuario de ingreso se transforma en el codigo de empleado o usuario administrador para continuar el acceso*/
                IF EMPLOYEE_ID IS NOT NULL THEN
                    /*Validamos si el usuario ingresado ya esta registrado, de lo contrario debe crear una contraseña */
                    SELECT COUNT(*) INTO QUANTITY
                    FROM TW_TB_IDENTITY WHERE ID_USER = ENCRIPTA.ENCRIP(EMPLOYEE_ID);
                    
                    IF QUANTITY = 0 THEN
                        BEGIN
                            EMPLOYEE_ID := ID_LOGIN;
                            OUTPUT      := 0;
                            MESSAGE     := 'El usuario '||ID_LOGIN||' no existe, debe crearlo y asignar una contraseña segura';
                        END; 
                    ELSE
                        /*Obtenermos los datos de logeo para el usuario existente*/
                        BEGIN
                            SELECT NUM_ATP, DATE_MOD, PASS, NUM_REC INTO NUMB_LOG, LAST_LOG, REG_PASS, KEY_PASS               
                            FROM TW_TB_IDENTITY WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                            
                            EXCEPTION
                                WHEN NO_DATA_FOUND THEN
                                    NUMB_LOG    :=  0;
                                    LAST_LOG    :=  NULL;
                                    REG_PASS    :=  NULL;
                                    KEY_PASS    :=  NULL;
                                WHEN OTHERS THEN
                                    RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                        END;
                        
                        /*Si hay una código de activación, se debe ingresar y continuar con el proceso de logeo*/                       
                        IF  KEY_PASS IS NULL THEN
                            /*Si la clave ingresada es igual a la almacena continua proceso de logeo, por el contrario
                              actualizará el numero de intentos fallidos, al tercer intento quedará como bloqueado y debera
                              crear una nueva clave*/                            
                            IF REG_PASS = ENCRIPTA.ENCRIP(IN_PASS) THEN
                                IF  NUMB_LOG <= 3 THEN 
                                    /*Si la clave fue creada o ctualizada hace más de 60 días pedira cambio de clave. 
                                    Si la fecha no ha superado los 60 dias, en este punto hay un acceso exitoso*/
                                    IF TO_DATE (LAST_LOG, 'DD-MM-YYYY')+60 >= TO_DATE (SYSDATE, 'DD-MM-YYYY') THEN
                                                                    
                                        BEGIN
                                            UPDATE TW_TB_IDENTITY SET NUM_ATP = 0, NUM_REC = NULL 
                                            WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID) AND DATE_MOD = LAST_LOG; 
                                            
                                            EXCEPTION
                                                WHEN OTHERS THEN
                                                    RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                                        END;
                            
                                        EMPLOYEE_ID :=  ID_LOGIN;
                                        OUTPUT      :=  1;
                                        MESSAGE     :=  'Acceso Correcto';
                            
                                    ELSE
                                        EMPLOYEE_ID :=  ID_LOGIN;
                                        OUTPUT      :=  2;
                                        MESSAGE     :=  'Su contraseña ha caducado, por favor cree una nueva';
                                    END IF;
                    
                                ELSE
                                    EMPLOYEE_ID :=  ID_LOGIN;
                                    OUTPUT      :=  3;
                                    MESSAGE     :=  'El número de intentos fallidos a superado el limite, por favor cree una nueva contraseña';
                                END IF;  
                    
                            ELSE
                                NUMB_LOG := NUMB_LOG +1;
                                                        
                                IF  NUMB_LOG <= 4 THEN
                                                        
                                    BEGIN
                                        UPDATE TW_TB_IDENTITY SET NUM_ATP = NUMB_LOG, NUM_REC = NULL 
                                        WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                                        
                                        EXCEPTION
                                            WHEN OTHERS THEN
                                                RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                                    END; 
                                
                                    EMPLOYEE_ID := NULL;
                                    OUTPUT      := -20002;
                                    MESSAGE     := 'Clave No valida, lleva '|| NUMB_LOG||' intento(s) fallido(s).';
                                ELSE
                                    EMPLOYEE_ID :=  ID_LOGIN;
                                    OUTPUT      :=  3;
                                    MESSAGE     :=  'El número de intentos fallidos a superado el limite, por favor cree una nueva contraseña';
                                END IF;
                            
                            END IF;
                        
                        ELSE
                            IF KEY_ACT IS NULL THEN
                                EMPLOYEE_ID :=  ID_LOGIN;
                                OUTPUT      :=  4;
                                MESSAGE     :=  'Debe activar su cuenta, ingrese el código de validación enviado a su correo para activar el usuario';
                            ELSE
                                IF KEY_PASS = KEY_ACT THEN
                                    IF REG_PASS = ENCRIPTA.ENCRIP(IN_PASS) THEN
                                        IF  NUMB_LOG <= 3 THEN 
                                            /*Si la clave fue creada o ctualizada hace más de 60 días pedira cambio de clave. 
                                              Si la fecha no ha superado los 60 dias, en este punto hay un acceso exitoso*/
                                            IF TO_DATE (LAST_LOG, 'DD-MM-YYYY')+60 >= TO_DATE (SYSDATE, 'DD-MM-YYYY') THEN
                                                                    
                                                BEGIN
                                                    UPDATE TW_TB_IDENTITY SET NUM_ATP = 0, NUM_REC = NULL 
                                                    WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID); 
                                                    
                                                    EXCEPTION
                                                        WHEN OTHERS THEN
                                                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                                                END;
                            
                                                EMPLOYEE_ID :=  ID_LOGIN;
                                                OUTPUT      :=  1;
                                                MESSAGE     :=  'Acceso Correcto';
                            
                                            ELSE
                                                EMPLOYEE_ID :=  ID_LOGIN;
                                                OUTPUT      :=  2;
                                                MESSAGE     :=  'Su contraseña ha caducado, por favor cree una nueva';
                                            END IF;
                    
                                        ELSE
                                            EMPLOYEE_ID :=  ID_LOGIN;
                                            OUTPUT      :=  3;
                                            MESSAGE     :=  'El número de intentos fallidos a superado el limite, por favor cree una nueva contraseña';
                                        END IF;  
                    
                                    ELSE
                                        NUMB_LOG := NUMB_LOG +1;
                                                                
                                        IF  NUMB_LOG <= 4 THEN
                                                        
                                            BEGIN
                                                UPDATE TW_TB_IDENTITY SET NUM_ATP = NUMB_LOG
                                                WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                                                
                                                EXCEPTION
                                                    WHEN OTHERS THEN
                                                        RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                                            END; 
                                
                                            EMPLOYEE_ID := NULL;
                                            OUTPUT      := -20002;
                                            MESSAGE     := 'Clave No valida, lleva '|| NUMB_LOG||' intento(s) fallido(s).';
                                        ELSE
                                            EMPLOYEE_ID :=  ID_LOGIN;
                                            OUTPUT      :=  3;
                                            MESSAGE     :=  'El número de intentos fallidos a superado el limite, por favor cree una nueva contraseña';
                                        END IF;
                            
                                    END IF;                                
                                
                                ELSE
                                    EMPLOYEE_ID := ID_LOGIN;
                                    OUTPUT      := 5;
                                    MESSAGE     := 'El código de validación ingresado no corresponde al generado, por favor verifique';       
                                END IF;
                            END IF;    
                        
                        END IF;    
                    END IF;
                    
                END IF;
                
            END;
            
        ELSE
            EMPLOYEE_ID         :=      NULL;
            OUTPUT              :=      -20001;
            MESSAGE             :=      'El usuario ingresado no existe o no esta activo en la nómina';
        END IF;
    
    /*La operación permite crear nuevos usuarios con su respectiva contraseña*/        
    ELSE IF OPERACION ='C' THEN 
        QUANTITY    := 0;  
        EMPLOYEE_ID := NULL;
        OUTPUT      := -20000;
        MESSAGE     := 'Error de Logeo';
        
        /*Devuelve el usuario administrador del sistema*/
        BEGIN
            SELECT VAR_CARAC, DESCRIPCION INTO USER_ADMIN, CORREO FROM PARAMETROS_NUE
            WHERE NOM_VAR ='t_adminweb';
                        
            EXCEPTION
                WHEN NO_DATA_FOUND THEN
                    USER_ADMIN  := NULL;
        END;
        
        /*Determina si el id_login(cedula) existe como empleado activo de la nómina*/
        SELECT COUNT(*) INTO QUANTITY 
        FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A';
        
        /*Si es el usuario administrador o un empleado con acceso, continua la validación de acceso*/
        IF (QUANTITY > 0) OR (ID_LOGIN = USER_ADMIN) THEN
            
            IF ID_LOGIN = USER_ADMIN THEN
                EMPLOYEE_ID := ID_LOGIN;
            ELSE
                BEGIN
                    SELECT E.COD_EPL, G.EMAIL INTO EMPLOYEE_ID, CORREO
                    FROM EMPLEADOS_BASIC E, EMPLEADOS_GRAL G
                    WHERE E.CEDULA = ID_LOGIN AND E.COD_EPL = G.COD_EPL (+) AND E.ESTADO ='A' AND ROWNUM =1;
                    
                    EXCEPTION 
                        WHEN NO_DATA_FOUND THEN
                            EMPLOYEE_ID         :=      NULL;
                            OUTPUT              :=      -20001;
                            MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';   
                        WHEN OTHERS THEN
                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                END;
            END IF;
            
            /*Si es un empleado registrado en la nómina o es el usuario administrador continúa el registro*/
            IF EMPLOYEE_ID IS NOT NULL THEN
            
                /*Se valida que no exista el usuario que se intenta crear*/
                SELECT COUNT(*) INTO QUANTITY FROM TW_TB_IDENTITY 
                WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                /*Si no existe el usuario, se crea y genera y envia correo con código de activación*/
                IF QUANTITY = 0 THEN
                    KEY_PASS := DBMS_RANDOM.string('X', 20);
                    
                    BEGIN
                        INSERT INTO TW_TB_IDENTITY (ID_USER, DATE_MOD, NUM_ATP,PASS, NUM_REC  ) 
                        VALUES (ENCRIPTA.ENCRIP (EMPLOYEE_ID), SYSDATE, 0,ENCRIPTA.ENCRIP (EMPLOYEE_ID),KEY_PASS);
                        
                        EXCEPTION
                            WHEN OTHERS THEN
                                RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                    END;
                    
                    BEGIN
                        --DBMS_OUTPUT.PUT_LINE('Correo Jefe = '|| correo_jef);
                    
                        --mensaje:=   'Para activar su usuario ingrese la siguiente clave en su próximo ingreso: '||REG_PASS;      
                    
                        CORREO :='vladimir.bello@talentsw.com ';
                        --TOKEN    := 'http://localhost:8080/yii2/Autogestion2/web/index.php?r=site%2Fasignapassword'||Chr(38)||'tokenreset='||KEY_PASS||Chr(38)||'usuario='||ID_LOGIN||Chr(38)||'operacion=T';
                        CORREO_ACTIVAR_CUENTA (KEY_PASS, ID_LOGIN,OPERACION,MENSAJE);
                        ENVIA_CORREO.EMAIL(sender => 'tyt.correoprueba@gmail.com',
                                       sender_name => 'Talentos y Tecnología SAS',
                                       recipients => correo,
                                       subject => 'WEB AUTOGESTIÓN - Activación de Usuario',
                                       message =>MENSAJE );
                                       --message => 'Para activar su usuario ingrese al siguiente link y creee una contrase'||CHR(38)||'ntilde;a : '||CHR(10)||TOKEN);
                    END;
                
                    EMPLOYEE_ID :=  ID_LOGIN;
                    OUTPUT      :=  6;
                    MESSAGE     :=  'Hemos enviado las instrucciones de activaci'||CHR(38)||'oacute;n al correo electronico que tienes registrado en n'||CHR(38)||'oacute;mina, por favor revisa tu bandeja de entrada.';
                ELSE
                    EMPLOYEE_ID :=  ID_LOGIN;
                    OUTPUT      :=  7;
                    MESSAGE     :=  'El usuario '||EMPLOYEE_ID||' ya existe, si lo requiere recupere su contraseña';
                END IF;              
            ELSE
                EMPLOYEE_ID         :=      NULL;
                OUTPUT              :=      -20001;
                MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';
            END IF;
        ELSE
            EMPLOYEE_ID         :=      NULL;
            OUTPUT              :=      -20001;
            MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';
        END IF;
        
    ELSE IF OPERACION ='U' THEN 
        QUANTITY    := 0;  
        EMPLOYEE_ID := NULL;
        OUTPUT      := -20000;
        MESSAGE     := 'Error de Logeo';
        
        /*Devuelve el usuario administrador del sistema*/
        BEGIN
            SELECT VAR_CARAC, DESCRIPCION INTO USER_ADMIN, CORREO FROM PARAMETROS_NUE
            WHERE NOM_VAR ='t_adminweb';
                        
            EXCEPTION
                WHEN NO_DATA_FOUND THEN
                    USER_ADMIN  := NULL;
        END;
       
        /*Si es el usuario administrador o un empleado con acceso, continua la validación de acceso*/
        SELECT COUNT(*) INTO QUANTITY 
        FROM EMPLEADOS_BASIC WHERE CEDULA = ID_LOGIN AND ESTADO ='A';
        
        IF (QUANTITY > 0) OR (ID_LOGIN = USER_ADMIN) THEN
        
            IF ID_LOGIN = USER_ADMIN THEN
                EMPLOYEE_ID := ID_LOGIN;
            ELSE
                BEGIN
                    SELECT E.COD_EPL, G.EMAIL INTO EMPLOYEE_ID, CORREO
                    FROM EMPLEADOS_BASIC E, EMPLEADOS_GRAL G
                    WHERE E.CEDULA = ID_LOGIN AND E.COD_EPL = G.COD_EPL (+) AND E.ESTADO ='A' AND ROWNUM =1;
                    
                    EXCEPTION 
                        WHEN NO_DATA_FOUND THEN
                            EMPLOYEE_ID         :=      NULL;
                            OUTPUT              :=      -20001;
                            MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';    
                        WHEN OTHERS THEN
                            RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                END;
            END IF;
            
            /*Si es un empleado registrado en la nómina o es el usuario administrador continúa el registro*/
            IF EMPLOYEE_ID IS NOT NULL THEN
            
                /*Se valida que no exista el usuario que se intenta crear*/
                SELECT COUNT(*) INTO QUANTITY FROM TW_TB_IDENTITY 
                WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                
                SELECT COUNT(NUM_REC) INTO KEY_PASS FROM TW_TB_IDENTITY 
                WHERE ID_USER = ENCRIPTA.ENCRIP (EMPLOYEE_ID);
               
                IF (KEY_PASS > 0) THEN
                    BEGIN
                        EMPLOYEE_ID :=  ID_LOGIN;
                        OUTPUT      :=  4;
                        MESSAGE     :=  'Señor usuario, anteriormente se le envio un correo para activar la cuenta, por favor activelo o contacte al administrador.';
                    END;
                ELSE
                
                /*Si existe el usaurio sobre el cual se quiere modificar la contraseña continua el proceso, sino 
                  informa que debe crear el usuario*/
                    IF QUANTITY > 0 THEN
                        /*Validamos la similitud de la contraseña ingresada con el historico de contraseñas usadas en los ultimos 6 meses,
                          si coincide en mas de un 95%, se debe solicita que ingreso otro valor como contraseña*/                                          
                        /*Guardamaos la contraseña existente para el historico y actualizamos la nueva */            
                        BEGIN
                            INSERT INTO TW_TB_HIST_IDENTITY (ID_USER, PASS, DATE_MOD)
                            SELECT ID_USER, PASS, DATE_MOD FROM TW_TB_IDENTITY
                            WHERE ID_USER =ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                                
                        EXCEPTION
                            WHEN OTHERS THEN
                                RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                        END;
                            
                        BEGIN
                            KEY_PASS := DBMS_RANDOM.string('X', 20);
                            
                            UPDATE TW_TB_IDENTITY SET PASS =ENCRIPTA.ENCRIP (EMPLOYEE_ID), DATE_MOD = SYSDATE, NUM_ATP =0,NUM_REC =KEY_PASS 
                            WHERE ID_USER=ENCRIPTA.ENCRIP (EMPLOYEE_ID);
                                
                            EXCEPTION
                                WHEN OTHERS THEN
                                    RAISE_APPLICATION_ERROR (-20000, 'Error: '||SQLCODE||' '||SQLERRM);
                        END;
                            
                        BEGIN
                            --DBMS_OUTPUT.PUT_LINE('Correo Jefe = '|| correo_jef);
                        
                            --mensaje:=   'Para activar su usuario ingrese la siguiente clave en su próximo ingreso: '||REG_PASS;      
                            CORREO :='vladimir.bello@talentsw.com';
                            --TOKEN    := 'http://localhost:81/yii2/Autogestion2/web/index.php?r=site%2Fasignapassword'||Chr(38)||'tokenreset=';
                            CORREO_ACTIVAR_CUENTA (KEY_PASS, ID_LOGIN,OPERACION,MENSAJE);
                        
                            ENVIA_CORREO.EMAIL(sender => 'vladimir.bello@talentsw.com',
                                               sender_name => 'Talentos y Tecnología SAS',
                                               recipients => correo,
                                               subject => 'WEB AUTOGESTIÓN - Cambio de Clave',
                                               message => MENSAJE);
                                               --message => 'Para activar su clave ingrese al siguiente link: '||CHR(10)||TOKEN||KEY_PASS||Chr(38)||'usuario='||ID_LOGIN||Chr(38)||'operacion=T');
                        END;
                    
                        EMPLOYEE_ID :=  ID_LOGIN;
                        OUTPUT      :=  9;
                        MESSAGE     :=  'Hemos enviado un  link de activación al correo que tengas registrado en la base de datos';
                        
                    ELSE
                        
                        EMPLOYEE_ID := NULL;
                        OUTPUT      := 0;
                        MESSAGE     := 'El usuario '||ID_LOGIN||' no existe, debe crearlo y asignar una contraseña segura';
                        
                    END IF;   
                END IF;      
            ELSE
                EMPLOYEE_ID         :=      NULL;
                OUTPUT              :=      -20001;
                MESSAGE             :=      'El usuario ingresado no existe, o no esta activo en nómina';
            END IF;
        ELSE
            EMPLOYEE_ID         :=      NULL;
            OUTPUT              :=      -20001;
            MESSAGE             :=      'El usuario ingresado no existe o no esta activo';
        END IF;
           
    END IF;
        
    END IF;
    
    END IF;
    
    END IF;
        
    END IF;
    
END TW_PC_IDENTITY;