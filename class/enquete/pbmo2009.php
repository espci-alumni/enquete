<?php

class extends enquete
{
	function setupForm($form, $save)
	{
		$yes_no_item = array('item' => array('X' => 'oui', ' ' => 'non'));

		$form->add('check', 'org_chef_corse', $yes_no_item);
		$form->add('check', 'org_chef_conti', $yes_no_item);
		$form->add('check', 'org_multicarte', $yes_no_item);
		$form->add('check', 'org_agent', $yes_no_item);
		$form->add('text', 'org_autre');

		$form->add('date', 'org_chef_corse_date');
		$form->add('date', 'org_chef_conti_date');
		$form->add('date', 'org_multicarte_date');
		$form->add('date', 'org_agent_date');
		$form->add('date', 'org_autre_date');

		$form->add('text', 'corse_magasins', array('valid' => 'int', 0));
		$form->add('text', 'corse_visits_y', array('valid' => 'int', 0));
		$form->add('text', 'corse_precisions');

		$form->add('text', 'conti_semaines', array('valid' => 'int', 0));
		$form->add('text', 'conti_precisions');

		$form->add('textarea', 'commentaire');

		$save->attach(
			'org_chef_corse', "", "",
			'org_chef_conti', "", "",
			'org_multicarte', "", "",
			'org_agent', "", "",
			'org_autre', "", "",

			'org_chef_corse_date', "", "",
			'org_chef_conti_date', "", "",
			'org_multicarte_date', "", "",
			'org_agent_date', "", "",
			'org_autre_date', "", "",

			'corse_magasins', "", "",
			'corse_visits_y', "", "",
			'corse_precisions', "", "",

			'conti_semaines', "", "",
			'conti_precisions', "", "",

			'commentaire', "", ""
		);
	}
}
