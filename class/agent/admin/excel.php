<?php

require_once 'Spreadsheet/Excel/Writer.php';

class extends agent_admin
{
	const binary = true;

	protected $template = 'bin';
	protected $maxage = 0;

	function compose($o)
	{
		$db = DB();

		$enquete = $this->enquete->enquete;

		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->setVersion(8);
		$workbook->send("enquete_{$enquete}.xls");
		$worksheet = $workbook->addWorksheet('Resultats');
		$worksheet->setInputEncoding('UTF-8');

		$format = $workbook->addFormat();
		$format->setBold();

		$sql = "SHOW COLUMNS FROM enquete_{$enquete}";
		$entete = new loop_sql($sql);
		for ($i = 0; $a = $entete->loop(); ++$i) $worksheet->writeString(0, $i, $a->Field, $format);

		$sql = "SELECT * FROM enquete_{$enquete}
			WHERE result_id IN (SELECT result_id FROM admin_user WHERE statut='enregistre')";
		$results = new loop_sql($sql);
		for ($i = 1; $a = $results->loop(); ++$i)
		{
			$j = 0;
			foreach ($a as &$value)
			{
				$worksheet->writeString($i, $j, $value);
				++$j;
			}
		}

		$workbook->close();

		return $o;
	}
}
