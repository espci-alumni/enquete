<?php

class agent_bounce extends agent
{
    public $get = array('__1__');

    function control()
    {
        if ($this->get->__1__)
        {
            DB()->autoExecute(
                'admin_user',
                array('bounced' => 1),
                MDB2_AUTOQUERY_UPDATE,
                "user_key=" . DB()->quote($this->get->__1__)
            );
        }
    }
}
