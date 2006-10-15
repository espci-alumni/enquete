<?php

class enquete_situation extends enquete
{
	function setupForm($form, $save)
	{
		$form->add('check', 'present', array('item' => array(1 => 'oui', 0 => 'non')));
		$form->add('check', 'conseil', array('item' => array(1 => 'oui', -1 => 'non', 0 => "je m'abstiens")));
		$form->add('check', 'finance', array('item' => array(1 => 'oui', -1 => 'non', 0 => "je m'abstiens")));

		$form->add('textarea', 'libre');

		$save->add(
			'present', "Serez-vous présent à l'AG du 22 octobre ?", "",
			'conseil', "Approuvez-vous le nouveau conseil ?", "",
			'finance', "Approuvez-vous les comptes ?", "",
			'libre', "", "",
		);
	}
}
