<?php

class extends agent
{
	public $get = '__1__';

	function compose($o)
	{
		$user_key = $this->get->__1__;

		if ('' === $user_key)
		{
			$sql = "SELECT enquete, owner, subject, description, etat_enquete, anonyme
				FROM admin_enquete";
			$o->ENQUETE = new loop_sql($sql);

			return $o;
		}

		$db = DB();

		$sql = 'SELECT * FROM admin_user u
			WHERE user_key=?
				AND (
					(hors_delai = 0 AND (
						SELECT 1 FROM admin_enquete
						WHERE enquete=u.enquete AND etat_enquete="ouvert"
					))
					OR
					DATE_ADD(date_envoi, INTERVAL hors_delai DAY) > NOW()
				)';
		$o = $db->getRow($sql, null, array($user_key));

		if (!$o) p::redirect('message/error/user_key');

		$template = 'enquete_' . $o->enquete;
		$enquete = new $template($o);

		$enquete->setup();

		$this->template = str_replace('_', '/', $template);

		return $o;
	}
}
