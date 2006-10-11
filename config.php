<?php #extends ../..

$dsn = PCORG::dsn();
$dsn['database'] = 'enquete';

$CONFIG += array(

	'DSN' => $dsn,

);
