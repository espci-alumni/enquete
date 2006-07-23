<?php // vim: set enc=utf-8 ai noet ts=4 sw=4 fdm=marker:

$dsn = PCORG::dsn();
$dsn['database'] = 'enquete';

$CONFIG += array(			// Config parameters

	'DSN' => $dsn,

);

CIA(__FILE__);
