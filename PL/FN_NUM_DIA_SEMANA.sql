create or replace FUNCTION FN_NUM_DIA_SEMANA(IN_FECHA VARCHAR2, FORMATO_FEC VARCHAR2)
RETURN NUMBER
AS 
NUM_DIA     NUMBER;
BEGIN

--RAISE_APPLICATION_ERROR(-20001, IN_FECHA||' - '||FORMATO_FEC);
    
    SELECT  CASE to_char (TO_DATE(IN_FECHA,FORMATO_FEC,'nls_date_language=english'), 'FmDay', 'nls_date_language=english')
        when 'Monday' then 1
        when 'Tuesday' then 2
        when 'Wednesday' then 3
        when 'Thursday' then 4
        when 'Friday' then 5
        when 'Saturday' then 6
        when 'Sunday' then 7
    end DAYS
    INTO NUM_DIA
    FROM DUAL;
    
    RETURN NUM_DIA;

END FN_NUM_DIA_SEMANA;