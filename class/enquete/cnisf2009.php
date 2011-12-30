<?php

class enquete_cnisf2009 extends enquete
{
    protected

    $link_template = 'cnisf2009/%s',
    $thanks_template = 'cnisf2009/thanks/%s',
    $email_footer = '';

    protected function setupForm($form, $save)
    {
        Patchwork::redirect('http://enquete.cnisf.org/cnisf2009/');
    }
}
