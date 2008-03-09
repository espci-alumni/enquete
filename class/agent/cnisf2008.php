<?php

class extends agent_index
{
	function compose($o)
	{
		$this->get->__1__ || p::redirect('http://enquete.cnisf.org/cnisf2008/');

		return parent::compose($o);
	}
}
