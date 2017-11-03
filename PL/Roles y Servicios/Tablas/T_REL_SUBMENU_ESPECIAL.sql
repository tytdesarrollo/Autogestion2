DROP TABLE TELEPRU.T_REL_SUBMENU_ESPECIAL CASCADE CONSTRAINTS;

CREATE TABLE TELEPRU.T_REL_SUBMENU_ESPECIAL
(
  COD_ROL_ESPECIAL  NUMBER,
  T_SUB_MENU        NUMBER
)
TABLESPACE TELEFONICA
PCTUSED    0
PCTFREE    10
INITRANS   1
MAXTRANS   255
STORAGE    (
            INITIAL          64K
            MINEXTENTS       1
            MAXEXTENTS       UNLIMITED
            PCTINCREASE      0
            BUFFER_POOL      DEFAULT
           )
LOGGING 
NOCOMPRESS 
NOCACHE
MONITORING;


ALTER TABLE TELEPRU.T_REL_SUBMENU_ESPECIAL ADD (
  FOREIGN KEY (COD_ROL_ESPECIAL) 
  REFERENCES TELEPRU.T_ROLES (COD_ROL)
  ENABLE VALIDATE,
  FOREIGN KEY (T_SUB_MENU) 
  REFERENCES TELEPRU.T_MENU (COD_MENU)
  ENABLE VALIDATE);
