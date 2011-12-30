<?php

class enquete_situation2011 extends enquete
{
    function setupForm($form, $save)
    {
        $form->add('check', 'situation', array(
            'item' => array(
                'emploi'    => "J'ai actuellement un emploi",
                'etudes'    => 'Je poursuis mes études',
                'recherche' => "Je suis en recherche d'emploi",
            )
        ));

        $form->add('text', 'salaire', array('valid' => 'int', 7200));
        $form->add('text', 'salaire_1er', array('valid' => 'int', 7200));
        $form->add('textarea', 'difficulte');
        $form->add('textarea', 'remarque');

        $save->attach(
            'situation',  "Quelle est votre situation actuelle ?", "",
            'salaire',    "", "Merci de saisir un nombre entier correspondant à votre salaire brut annuel",
            'salaire_1er',  "", "Merci de saisir un nombre entier correspondant à votre salaire brut annuel",
            'difficulte', "", "",
            'remarque',   "", ""
        );

        foreach (range(1, 5) as $i)
        {
            $form->add('text', 'type_'    . $i);
            $form->add('date', 'debut_'   . $i);
            $form->add('date', 'fin_'     . $i);
            $form->add('text', 'poste_'   . $i);
            $form->add('text', 'domaine_' . $i);
            $form->add('text', 'societe_' . $i);
            $form->add('text', 'pays_'    . $i);

            $save->attach(
                'type_'    . $i, '', '',
                'debut_'   . $i, '', '',
                'fin_'     . $i, '', '',
                'poste_'   . $i, '', '',
                'domaine_' . $i, '', '',
                'societe_' . $i, '', '',
                'pays_'    . $i, '', ''
            );
        }
    }
}
