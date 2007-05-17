<?php

class extends agent
{
	public $argv = array('__1__');

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
		$o = $db->getRow($sql, null, array($this->argv->__1__));

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
			$form = new iaForm($o);
			$send = $form->add('submit', 'send');

			$form->add('text', 'subject', array('default' => 'Fw: enquête ' . $o->enquete));
			$form->add('textarea', 'template', array('default' => "Hello,

Je t'envoie une invitation pour que tu puisses répondre à l'enquête {$o->enquete} de {$this->enquete->owner}.
Si ce n'est pas déjà fait, tu devrais aussi t'inscrire sur espci.org, ça faciliterait les prochaines enquêtes...

A+,
{$o->prenom}
"));

			$send->add(
				'subject', "Complétez le sujet du mail à envoyer", "",
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

					if (V($data['email'], 'email')) $this->save($o, $data);
				}

				p::redirect();
			}
		}

		return $o;
	}

	function save($o, $data)
	{
		$data['hors_delai'] = $o->hors_delai;

		enquete::send("\"{$o->prenom} {$o->nom}\" <invitation@espci.org>", $o->email, $this->enquete, $data, false);
	}
}
