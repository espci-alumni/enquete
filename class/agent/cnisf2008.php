<?php

class agent_cnisf2008 extends agent_index
{
    function compose($o)
    {
        $this->get->__1__ || Patchwork::redirect('http://enquete.cnisf.org/cnisf2008/');

        return parent::compose($o);
    }
}
