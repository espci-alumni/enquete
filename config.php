<?php

$dsn = PCORG::dsn();
$dsn['database'] = 'enquete';

$CONFIG += array(			// Config parameters

	'DSN' => $dsn,

);

CIA(__FILE__);
