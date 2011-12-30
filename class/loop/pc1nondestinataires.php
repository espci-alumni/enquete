<?php

class loop_pc1nondestinataires extends loop_sql
{
    protected $enquete;
    protected $form;
    protected $send;

    function __construct($enquete, $promo, $form = false, $send = false, $hide_email = false)
    {
        $this->enquete = $enquete;
        $this->form = $form;
        $this->send = $send;

        $form = $form ? '' : "AND login=''";

        parent::__construct(
            "SELECT contact_id, nom_usuel as nom, prenom_usuel as prenom, promotion as promo, " .( $hide_email ? "''" : "IF(login!='',CONCAT(login, '@espci.org'),'')" ). " AS email
            FROM tribes.contact_contact
            WHERE diplome AND NOT date_deces AND promotion={$promo} {$form}
            ORDER BY nom, prenom"
        );
    }

    function next()
    {
        if ($data = parent::next())
        {
            $db = DB();
            $sql = 'SELECT 1
                    FROM admin_user
                    WHERE REPLACE(nom, "-", " ") = REPLACE(?, "-", " ")
                        AND REPLACE(prenom, "-", " ") = REPLACE(?, "-", " ")
                        AND promo = ?
                        AND enquete = ?
                        AND NOT bounced';
            if ($db->getOne($sql, null, array($data->nom, $data->prenom, $data->promo, $this->enquete))) return $this->next();
            else
            {
                $name = 'pc' . $data->contact_id;
                $email = $data->email;

                $data = (object) array(
                    'nom' => $data->nom,
                    'prenom' => $data->prenom,
                );

                if ($this->form)
                {
                    $data->f_email = $this->form->add('text', $name, array('valid' => 'email', 'default' => $email), false);
                    $this->send->attach($name, '', 'Email non valide');
                }

                return $data;
            }
        }
    }
}
