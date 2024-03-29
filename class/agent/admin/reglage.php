<?php

class agent_admin_reglage extends agent_admin
{
    function compose($o)
    {
        $o = $this->enquete;

        $form = $this->form = new pForm($o);

        $db = DB();

        $sql = 'SELECT * FROM admin_enquete WHERE enquete=?';
        $defaults = $db->fetchAssoc($sql, array($o->enquete));

        if ($defaults) $form->setDefaults($defaults);

        $save = $form->add('submit', 'save');
        $form->add('check', 'etat_enquete', array(
            'item' => array('ouvert' => 'ouvert', 'ferme' => 'fermé')
        ));
        $form->add('textarea', 'description');
        $form->add('text', 'hors_delai', array('valid' => 'int', 1));

        $save->attach(
            'etat_enquete', "", "",
            'description', "", "",
            'hors_delai', "Préciser le délai d'expiration des clés hors délais", "Délai non valide"
        );

        if ($save->isOn())
        {
            $this->save($save->getData());
            Patchwork::redirect();
        }

        return $o;
    }

    function save($data)
    {
        DB()->update(
            'admin_enquete',
            $data,
            array('enquete' => $this->enquete->enquete)
        );
    }
}
