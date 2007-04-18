<?php

$_GET['$bin'] = '';

$dsn = PCORG::dsn();
$dsn['database'] = 'enquete';

$CONFIG += array(

	'DSN' => $dsn,

);
