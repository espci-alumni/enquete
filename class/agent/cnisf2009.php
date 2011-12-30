<?php

class agent_cnisf2009 extends agent_index
{
    function control()
    {
        if (!$this->get->__1__ || date('Y-m-d') < '2009-03-01')
        {
            Patchwork::redirect('http://enquete.cnisf.org/cnisf2009/');
        }

        parent::control();
    }
}
