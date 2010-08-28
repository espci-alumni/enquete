<?php

class extends agent_index
{
	function control()
	{
		if (!$this->get->__1__ || date('Y-m-d') < '2009-03-01')
		{
			p::redirect('http://enquete.cnisf.org/cnisf2009/');
		}

		parent::control();
	}
}
