<?php

class extends enquete
{
	protected

	$link_template = 'cnisf2008/%s',
	$thanks_template = 'cnisf2008/thanks/%s',
	$email_footer = '';

	protected function setupForm($form, $save)
	{
		p::redirect('http://enquete.cnisf.org/cnisf2008/');
	}
}
