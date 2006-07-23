<?php

class extends agent_admin
{
	function control()
	{
		parent::control();

		if (!$this->enquete->lien_promo) CIA::redirect('admin/' . $this->argv->__1__);
	}

	function compose($o)
	{
		$o = $this->enquete;

		$form = new iaForm($o);

		$form->add('text', 'subject', array('default' => $o->subject));
		$form->add('textarea', 'template', array('default' => $o->template));

		$form->add('text', 'promo', array('valid' => 'int', 1));
		$form->add('submit', 'showpromo')->add(
			'promo',
			"Quelle promotion souhaitez-vous afficher ?",
			'Numéro de promotion non valide'
		);

		if ($promo = $o->f_promo->getValue())
		{
			$send = $form->add('submit', 'send');
			$send->add(
				'subject', "Quel est le sujet du mail à envoyer ?", "",
				'template', "", ""
			);

			$o->PC1 = new loop_pc1nondestinataires($o->enquete, $promo, $form, $send);

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

						'promo' => $promo,
						'nom' => $data->nom,
						'prenom' => $data->prenom,
						'email' => $data->f_email->getValue(),
					);

					if (V($data['email'], 'email')) $this->save($data);
				}

				CIA::redirect('admin/' . $this->argv->__1__ . '?order_by_date=1');
			}
		}

		return $o;
	}
}
