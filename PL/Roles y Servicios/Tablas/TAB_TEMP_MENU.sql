
CREATE GLOBAL TEMPORARY TABLE TT_MENU (
	MENU NUMBER NOT NULL,
	VALOR VARCHAR(5) NOT NULL
) ON COMMIT DELETE ROWS;