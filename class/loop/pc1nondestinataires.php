<?php

class extends loop_sql
{
	protected $enquete;
	protected $form;
	protected $send;

	function __construct($enquete, $promo, $form = false, $send = false, $hide_email = false)
	{
		$this->enquete = $enquete;
		$this->form = $form;
		$this->send = $send;

		$form = $form ? '' : 'AND ISNULL(s.uid)';

		parent::__construct(
			"SELECT p.pceen_id, p.nom, p.prenom, p.promo, " .( $hide_email ? "''" : "CONCAT(s.local_email, '@espci.org')" ). " AS email
			FROM PCORG.pceen p LEFT JOIN PCORG.system s ON p.uid=s.uid
			WHERE p.diplome AND !p.decede AND p.promo={$promo} {$form}
			ORDER BY p.nom, p.prenom"
		);
	}

	function next()
	{
		if ($data = parent::next())
		{
			$db = DB();
			$sql = 'SELECT 1
				FROM admin_user
				WHERE REPLACE(nom, "-", " ") = REPLACE(?, "-", " ")
					AND REPLACE(prenom, "-", " ") = REPLACE(?, "-", " ")
					AND promo = ?
					AND enquete = ?
					AND NOT bounced';
			if ($db->getOne($sql, null, array($data->nom, $data->prenom, $data->promo, $this->enquete))) return $this->next();
			else
			{
				$name = 'pc' . $data->pceen_id;
				$email = $data->email;

				$data = (object) array(
					'nom' => $data->nom,
					'prenom' => $data->prenom,
				);

				if ($this->form)
				{
					$data->f_email = $this->form->add('text', $name, array('valid' => 'email', 'default' => $email), false);
					$this->send->add($name, '', 'Email non valide');
				}

				return $data;
			}
		}
	}
}
