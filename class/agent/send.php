<?php // vim: set enc=utf-8 ai noet ts=4 sw=4 fdm=marker:

class extends agent
{
	protected $maxage = -1;

	function compose($o)
	{
		$form = $this->form = new iaForm($o);

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
