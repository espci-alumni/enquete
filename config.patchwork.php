<?php

$dsn = PCORG::dsn();
$dsn['database'] = 'enquete';

$CONFIG += array(

	'DSN' => $dsn,
	'clientside' => false,

);
