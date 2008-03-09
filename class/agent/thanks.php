<?php

class extends agent
{
	public $get = '__1__';

	protected $enquete;

	function compose($o)
	{
		$db = DB();

		$sql = 'SELECT * FROM admin_user u
			WHERE user_key = ?
				AND (
					(hors_delai = 0 AND (
						SELECT 1 FROM admin_enquete
						WHERE enquete=u.enquete AND etat_enquete="ouvert"
					))
					OR
					DATE_ADD(date_envoi, INTERVAL hors_delai DAY) > NOW()
				)';
		$o = $db->getRow($sql, null, array($this->get->__1__));

		if (!$o) p::redirect('index');

		$sql = 'SELECT * FROM admin_enquete WHERE enquete=?';
		$this->enquete = $db->getRow($sql, null, array($o->enquete));

		$o->owner = $this->enquete->owner;

		$sql = 	'SELECT 1
			FROM PCORG.system
			WHERE REPLACE(nom, "-", " ") = REPLACE(?, "-", " ")
				AND REPLACE(prenom, "-", " ") = REPLACE(?, "-", " ")
				AND promotion = ?';
		$o->membre = (bool) $db->getOne($sql, null, array($o->nom, $o->prenom, $o->promo));

		if ($this->enquete->lien_promo)
		{
			$form = new pForm($o);
			$send = $form->add('submit', 'send');

			$form->add('text', 'subject', array('default' => 'Fw: enquête ' . $o->enquete));
			$form->add('textarea', 'template', array('default' => "Bonjour,

Je t'envoie une invitation pour que tu puisses répondre à l'enquête {$o->enquete} menée par {$this->enquete->owner}.
Si ce n'est pas déjà fait, tu devrais aussi t'inscrire sur espci.org, ça faciliterait les prochaines enquêtes...

Salutations,
{$o->prenom}
"));

			$send->add(
				'subject', "Merci de compléter le sujet du mail qui sera envoyé", "",
				'template', "", ""
			);

			$o->PC1 = new loop_pc1nondestinataires($o->enquete, $o->promo, $form, $send, true);

			if ($send->isOn())
			{
				$template = $send->getData();
				$subject = $template['subject'];
				$template = $template['template'];

				while ($data = $o->PC1->loop())
				{
					$data = array(
						'subject' => $subject,
						'template' => $template,

						'source_key' => $o->user_key,
						'promo' => $o->promo,
						'nom' => $data->nom,
						'prenom' => $data->prenom,
						'email' => $data->f_email->getValue(),
					);

					if (FILTER::get($data['email'], 'email')) $this->save($o, $data);
				}

				p::redirect();
			}
		}

		return $o;
	}

	function save($o, $data)
	{
		$data['hors_delai'] = $o->hors_delai;

		$enquete = 'enquete_' . $this->enquete->enquete;
		$enquete = new $enquete($this->enquete);
		$enquete->send("\"{$o->prenom} {$o->nom}\" <invitation@espci.org>", $o->email, $this->enquete, $data, false);
	}
}
