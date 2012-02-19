<?php

class enquete_ag2006 extends enquete
{
    function setupForm($form, $save)
    {
        $o = $this->data;

        $sql = 'SELECT 1
                FROM PCORG.system
                WHERE REPLACE(nom, "-", " ") = REPLACE(?, "-", " ")
                    AND REPLACE(prenom, "-", " ") = REPLACE(?, "-", " ")
                    AND promotion = ?';
        $o->membre = (bool) DB()->getOne($sql, null, array($o->nom, $o->prenom, $o->promo));

        $form->add('check', 'present', array('item' => array('oui' => 'oui', 'non' => 'non', 'blanc' => "je ne sais pas encore")));
        $form->add('check', 'conseil', array('item' => array('oui' => 'oui', 'non' => 'non', 'blanc' => "je m'abstiens")));
        $form->add('check', 'comptes2006', array('item' => array('oui' => 'oui', 'non' => 'non', 'blanc' => "je m'abstiens")));
        $form->add('check', 'previsionnel2007', array('item' => array('oui' => 'oui', 'non' => 'non', 'blanc' => "je m'abstiens")));

        $form->add('textarea', 'libre');

        $save->attach(
            'present', "Serez-vous présent à l'AG du 22 octobre ?", "",
            'conseil', "Approuvez-vous le nouveau conseil ?", "",
            'comptes2006', "Approuvez-vous les comptes 2006 ?", "",
            'previsionnel2007', "Soutenez-vous les comptes prévisionnels 2007 ?", "",
            'libre', "", ""
        );
    }
}
