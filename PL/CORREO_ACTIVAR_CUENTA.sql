create or replace PROCEDURE         CORREO_ACTIVAR_CUENTA 
/******************************************************************************
    CREATE BY NELSON GALEANO
    Procedimiento que almacena el formato para el envio de correo al solicitar vacaciones
    
   NOTES:
    VARIABLES DE ENTRADA    
        KEY_PASS         Contraseña encriptada del usuario
        ID_LOGIN         Identificador del usuario
        OPERACION        Controla el mensaje del correo.
                        C = Activar usuario por primera vez
                        U = Cambiar la clave del usuario.
        
    VARIABLES DE SALIDA
        MENSAJE         Variable que almacena el contenido del correo        
******************************************************************************/
(
    KEY_PASS IN TW_TB_IDENTITY.NUM_REC%TYPE, 
    ID_LOGIN IN  EMPLEADOS_BASIC.CEDULA%TYPE, 
    OPERACION IN VARCHAR2,   
    MENSAJE OUT VARCHAR2
)
                                                                                                           
IS
TOKEN VARCHAR2(1000);
V_BODY VARCHAR2(700); 

BEGIN 
    TOKEN := 'http://localhost:8080/yii2/Autogestion2/web/index.php?r=site%2Fasignapassword'||Chr(38)||'tokenreset='||KEY_PASS||Chr(38)||'usuario='||ID_LOGIN||Chr(38)||'operacion=T';

    IF OPERACION ='C' THEN
        V_BODY := 'Para activar su usuario ingrese al siguiente link y cree una contrase'||CHR(38)||'#241;a:';
    END IF;

    IF OPERACION ='U' THEN
        V_BODY := 'Para cambiar su clave ingrese al siguiente link: ';
    END IF;

    MENSAJE := '
    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Document</title>
        <style>
            *{
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            body{
                font-family: sans-serif;
                color: #333;
            }
            body,html{
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }
            .main{
                width: 100%;
                height: 100%;
                padding: 40px 0;
            }
            .bg{
                background: #1d2d47;
                background: -moz-radial-gradient(center, ellipse cover, rgba(49,72,109,1) 1%, rgba(29,45,71,1) 100%);
                background: -webkit-radial-gradient(center, ellipse cover, rgba(49,72,109,1) 1%,rgba(29,45,71,1) 100%);
                background: radial-gradient(ellipse at center, rgba(49,72,109,1) 1%,rgba(29,45,71,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#2e446d", endColorstr="#1d2d47",GradientType=1 );
            }
            .pdg-24{
                padding: 24px;
            }
            .container{
                width: 80%;
            }
            .center{
                margin-left: auto;
                margin-right: auto;
            }
            .content-logo{
                margin-bottom: 20px;
            }
            .text-center{
                text-align: center;
            }
            .box-white{
                background-color: #ffffff;
                box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
            }
            .btn{
                background-color: #2861ff;
                color: rgba(255,255,255, 0.84);
                border: none;
                border-radius: 2px;
                position: relative;
                padding: 8px 30px;
                margin: 10px 1px;
                font-size: 14px;
                font-weight: 700;
                text-transform: uppercase;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                letter-spacing: 0;
                -ms-touch-action: manipulation;
                touch-action: manipulation;
                will-change: box-shadow, transform;
                -webkit-transition: -webkit-box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                -o-transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                transition: box-shadow 0.2s cubic-bezier(0.4, 0, 1, 1), background-color 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                outline: 0;
                cursor: pointer;
                text-decoration: none;
            }
            .shdw{
                box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
            }
            .btn:hover, .btn:focus, .btn:active{
                background-color: #2878ff;
                text-decoration: none;
                outline: 0;
            }
            .btn:focus:active:hover{
                -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.18), 0 8px 16px rgba(0, 0, 0, 0.36);
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.18), 0 8px 16px rgba(0, 0, 0, 0.36);
            }
            .footer{
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class=" main bg">
            <div class="container center text-center">
                <div class="content-logo">
                    <img src="http://talentsw.com/contactenos/imagenes/autogestion/logo_small.png" alt="Auto Gestión" class="resposive-img">
                </div>
                <div class="box-white pdg-24">                
                    <p>'||V_BODY||'</p>
                    <br>
                    <a href="'||TOKEN||'" class="btn shdw">Activar cuenta</a>
                </div>
                <div class="footer pdg-24">
                    <small>Copyright '||CHR(38)||'#169; 2017 Talentos y Tecnolog'||CHR(38)||'iacute;a, todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </body>
    </html>';

END CORREO_ACTIVAR_CUENTA;