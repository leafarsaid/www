<?php



# ------------------------------------------------



// BANCO DE DADOS

define("DB_DRIVER", "mysql");




	define("DB_HOST", "mysql03.chronosat.com.br");

	define("DB_USER", "chronosat2");

	define("DB_PASS", "chrono2002");

	define("DB_BANCO", "chronosat2");







define("DB_DML", "^(INSERT|UPDATE|DELETE)"); // comandos DML permitidos

define("DB_QUERY", "^(\(?SELECT|CALL|SHOW)"); // queries permitidas

define("DB_UNBUFFERED", true); // suporta resultsets "unbuffereds"?



define("DB_PAG_LIMITE", 10); // resultados por página (paginação de resultados)



# ------------------------------------------------



?>



