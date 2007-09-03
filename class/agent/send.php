<?php

class extends agent
{
	protected $maxage = -1;

	function compose($o)
	{
		$form = $this->form = new pForm($o);

		$send = $form->add('submit', 'send');

		$form->add('text', 'subject');
		$form->add('textarea', 'template');

		$send->add(
			'subject', "Quel est le sujet du mail à envoyer ?", "",
			'template', "", ""
		);

		return $o;
	}
}
