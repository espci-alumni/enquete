<?php

class extends agent_admin
{
	protected $enteteLength = 0;

	function compose($o)
	{
		$o = $this->enquete;

		$db = DB();

		$enquete = $o->enquete;

		$sql = "SHOW COLUMNS FROM enquete_{$enquete}";
		$o->ENTETE = new loop_sql($sql, array($this, 'filterEntete'));

		$this->enteteLength = $o->ENTETE->getLength();

		$sql = "SELECT *
			FROM admin_user u, enquete_{$enquete} e
			WHERE u.result_id = e.result_id AND u.enquete='{$enquete}'
			GROUP BY u.result_id
			ORDER BY u.bounced, FIELD(u.statut, 'enregistre', 'ouvert', 'envoye')";
		$o->USER = new loop_sql($sql, array($this, 'filterUser'));

		$form = $this->form = new iaForm($o);

		$relancer = $form->add('submit', 'relancer');

		$form->add('text', 'subject', array('default' => $o->subject));
		$form->add('textarea', 'template', array('default' => $o->template));

		$relancer->add(
			'subject', "Quel est le sujet du mail à envoyer ?", "",
			'template', "", ""
		);

		if ($relancer->isOn())
		{
			$data = $relancer->getData();

			$user = (array) @$_POST['relance'];
			foreach ($user as &$user)
			{
				$sql = 'SELECT *
					FROM admin_user
					WHERE result_id=? AND enquete=?
					ORDER BY bounced, FIELD(statut, "enregistre", "ouvert", "envoye")';
				if ($user = $db->getRow($sql, null, array($user, $enquete)))
				{
					$this->save(array(
						'subject' => $data['subject'],
						'template' => $data['template'],

						'result_id' => $user->result_id,
						'promo' => $user->promo,
						'nom' => $user->nom,
						'prenom' => $user->prenom,
						'email' => $user->email,
						'source_key' => $user->source_key,
					));
				}
			}

			CIA::redirect('admin/' . $this->argv->__1__ . '?order_by_date=1');
		}

		return $o;
	}

	function filterEntete($data)
	{
		return (object) array(
			'entete' => $data->Field
		);
	}

	function filterUser($data)
	{
		$a = (object) array(
			'f_relance' => new iaForm_check($this->form, 'relance', array(
				'item' => array($data->result_id => ''),
				'multiple' => true
			)),

			'promo' => $data->promo,
			'nom' => $data->nom,
			'prenom' => $data->prenom,
			'statut' => $data->statut,
			'bounced' => $data->bounced,
		);

		$data = array_values( (array) $data );
		$data = array_slice($data, 1 - $this->enteteLength);

		$a->DATA = new loop_array($data);

		return $a;
	}
}
