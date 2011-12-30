<?php

class agent_admin_header extends agent
{
    public $get = array('owner_key');

    function compose($o)
    {
        $db = DB();

        $sql = "SELECT e.*,
                    COUNT(*) AS nb_envoye,
                    COUNT(DISTINCT promo) AS nb_promo,
                    COUNT(DISTINCT result_id) AS nb_user,
                    COUNT(DISTINCT IF(statut IN ('ouvert','enregistre'),result_id,NULL)) AS nb_ouvert,
                    COUNT(DISTINCT IF(statut='enregistre',result_id,NULL)) AS nb_enregistre
                FROM admin_enquete e
                    JOIN admin_user u USING (enquete)
                WHERE owner_key=" . $db->quote($this->get->owner_key) . "
                GROUP BY enquete";
        if ($sql = $db->queryRow($sql)) $o = $sql;

        return $o;
    }
}
