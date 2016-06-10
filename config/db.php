<?php

return [
    'class' => 'yii\db\Connection',
    //'class' => 'yii\apaoww\Oci8DbConnection',
	'dsn' => 'oci:dbname=(DESCRIPTION=
    (ADDRESS=
      (PROTOCOL=TCP)
      (HOST=10.80.6.233)
      (PORT=1521)
    )
    (CONNECT_DATA=
      (SERVER=dedicated)
      (SID=Telmovil)
    )
  );charset=AL32UTF8;', // Oracle
    'username' => 'WEBTALENTOS',
    'password' => 'Temporal01',
   // 'charset' => 'utf8',
'attributes'=>[PDO::ATTR_CASE=> PDO::CASE_LOWER],
					
];

