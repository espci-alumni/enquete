<?php

class agent_bounce extends agent
{
    public $get = array('__1__');

    function control()
    {
        if ($this->get->__1__)
        {
            DB()->update(
                'admin_user',
                array('bounced' => 1),
                array('user_key' => $this->get->__1__)
            );
        }
    }
}
