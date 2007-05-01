<?php

class extends agent_admin
{
	const contentType = '';

	protected $template = 'bin';
	protected $maxage = 0;

	function compose($o)
	{
		$db = DB();

		$enquete = $this->enquete->enquete;

		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->send("enquete_{$enquete}.xls");
		$worksheet = $workbook->addWorksheet('Resultats');

		$format = $workbook->addFormat();
		$format->setBold();

		$worksheet->write(0, 0, 'promo', $format);

		$sql = "SHOW COLUMNS FROM enquete_{$enquete}";
		$entete = new loop_sql($sql);
		$entete->loop();
		for ($i = 1; $a = $entete->loop(); ++$i) $worksheet->write(0, $i, $a->Field, $format);

		$sql = "SELECT u.promo, e.*
			FROM enquete_{$enquete} e, admin_user u
			WHERE u.statut='enregistre' AND u.enquete='{$enquete}' AND e.result_id=u.result_id
			GROUP BY u.result_id";
		$results = new loop_sql($sql);
		for ($i = 1; $a = $results->loop(); ++$i)
		{
			$j = 0;
			foreach ($a as &$value)
			{
				1 != $j && $worksheet->write($i, $j>1 ? $j-1 : $j, $this->format($value));
				++$j;
			}
		}

		$workbook->close();

		return $o;
	}

	function format($value)
	{
		$value = utf8_decode($value);
		$value = strtr(str_replace("\r\n", "\n", $value), "\r", "\n");
		return $value;
	}
}
