create or replace PROCEDURE CORREO_SOLICI_HORASEX
/******************************************************************************
CREATE BY NELSON GALEANO
- FORMATO DE CORREO PARA LA SOLICITUD DE HORAS EXTRAS

VARIABLES DE ENTRADA    
    V_NOM_EPL         
    V_APE_EPL         
    V_USUARIO         1=JEFE  ,  0=EMPLEADO
    
VARIABLES DE SALIDA
    V_MENSAJE         RETORNA TODO EL CUERPO DEL MENSAJE EN HTML
******************************************************************************/
(
    V_NOM_EPL IN EMPLEADOS_BASIC.NOM_EPL%TYPE,
    V_APE_EPL IN EMPLEADOS_BASIC.APE_EPL%TYPE,
    V_USUARIO IN INTEGER,
    V_MENSAJE OUT VARCHAR2
)

IS
BODY VARCHAR2(2000);

BEGIN 

    IF V_USUARIO = '1' THEN 
        -- USUARIO JEFE
        BODY := '<br>Se solicita el pago de horas extras para el empleado '||V_NOM_EPL||' '||V_APE_EPL||', ingresar a la aplicación para aprobar la solicitud.<br><br> 
        Muchas Gracias por utilizar este servicio. <br><br>Este mensaje es informativo por favor no dar respuesta a esta cuenta de correo.
        <br><br><strong> Ten en cuenta de habilitar en el mensaje de advertencia que te aparece en la parte superior del mail, 
        "agregar el dominio @telefonica.com en la lista de remitentes seguros" para que puedas ver la imagen. </strong>';
    ELSE
        IF V_USUARIO = '0' THEN 
            -- USUARIO EMPLEADO
            BODY := V_NOM_EPL||' '||V_APE_EPL||', la solicitud de  horas extras, ha sido enviada a tu Jefe para su aprobación.<br><br> Muchas Gracias por utilizar este servicio.
            <br><br>Este mensaje es informativo por favor no dar respuesta a esta cuenta de correo.<br><br><strong> Ten en cuenta de habilitar en el mensaje de advertencia que te 
            aparece en la parte superior del mail, "agregar el dominio @telefonica.com en la lista de remitentes seguros" para que puedas ver la imagen. </strong><br>&nbsp;<br>';
        END IF;
    END IF;

    V_MENSAJE := '
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
                width: 65%;
            }
            .center{
                margin-left: auto;
                margin-right: auto;
            }
            .content-logo{
                width: 100%;
            }
            .responsive-img{
                width: 100%;
                vertical-align: top;
            }
            .text-center{
                text-align: center;
            }
            .text-justify{
                text-align: justify;
            }
            .box-white{
                width: 100%;
                background-color: #ffffff;
                border-top: 1px solid #dddddd;
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
                    <img src="http://talentsw.com/contactenos/imagenes/autogestion/horas_extras.png" alt="Auto Gestión" class="responsive-img">
                </div>
                <div class="box-white pdg-24 text-justify">             
                    <p>'||BODY||'</p>
                    <br>                    
                </div>
                <div class="footer pdg-24">
                    <small>Copyright '||CHR(38)||'#169; 2017 Talentos y Tecnolog'||CHR(38)||'iacute;a, todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </body>
    </html>';
END CORREO_SOLICI_HORASEX;