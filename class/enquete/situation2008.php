<?php

class extends enquete
{
	function setupForm($form, $save)
	{
		$form->add('textarea', 'adresse');
		$form->add('check', 'actif', array(
			'item' => array('oui' => 'oui', 'non' => 'non', 'idem' => "ma situation n'a pas changé depuis la dernière enquête")
		));

		$form->add('date', 'date_debut');
		$form->add('text', 'type_emploi');
		$form->add('date', 'date_fin');
		$form->add('text', 'intitule_poste');
		$form->add('text', 'domaine_activite');
		$form->add('text', 'societe');
		$form->add('text', 'pays');
		$form->add('check', '1er_emploi', array(
			'item' => array('oui' => 'oui', 'non' => 'non')
		));

		$form->add('text', 'salaire', array('valid' => 'int', 7200));
		$form->add('text', 'prime', array('valid' => 'int', 0));
		$form->add('check', 'etudiant', array(
			'item' => array('oui' => 'oui', 'non' => 'non')
		));

		$form->add('textarea', 'difficulte');
		$form->add('textarea', 'historique');
		$form->add('textarea', 'remarque');

		$save->attach(
			'adresse', "", "",
			'actif', "Avez-vous actuellement un emploi ?", "",
			'date_debut', "", "Entrez une date au format dd-mm-aaaa",
			'type_emploi', "", "",
			'date_fin', "", "Entrez une date au format dd-mm-aaaa",
			'intitule_poste', "", "",
			'domaine_activite', "", "",
			'societe', "", "",
			'pays', "", "",
			'1er_emploi', "", "",
			'salaire', "", "Merci de saisir un nombre entier correspondant à votre salaire brut annuel",
			'prime', "", "Merci de saisir un nombre entier pour votre prime annuelle",
			'etudiant', "", "",
			'difficulte', "", "",
			'historique', "", "",
			'remarque', "", ""
		);
	}
}
