
CREATE OR REPLACE VIEW V_AUTOGES_ROLES_NO_RASOS
 -- =============================================      
 -- Author:  FELIPE SATIZABAL
 -- =============================================
AS 
	    SELECT DISTINCT EB.CEDULA 
    FROM EMPLEADOS_BASIC EB
    INNER JOIN EPL_GRUPOS EG
        ON EG.COD_GRU IN
            (SELECT VAR_CARAC
            FROM PARAMETROS_NUE PN
            WHERE PN.NOM_VAR IN('t_gru_sena','t_gru_sena_prod','t_gru_sena_aut_ind'))
        AND EG.COD_EPL = EB.COD_EPL
UNION ALL     
    SELECT DISTINCT EB.CEDULA
    FROM EMPLEADOS_BASIC EB
    INNER JOIN T_ADMIN TA
        ON TA.COD_EPL = EB.COD_EPL
UNION ALL 
    SELECT DISTINCT NRO_CEDULA 
    FROM JEFES;