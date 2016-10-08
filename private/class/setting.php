<?php
// setting class
class Setting
{	
	// get company name
	public function getCompanyName()
	{ 
		return 'Villazzo';
	}
	
	// get company phone
	public function getCompanyPhone()
	{ 
		return '1 (877) VILLAZZO';
	}
	
	// get company email
	public function getCompanyEmail()
	{ 
		return array('villas@villazzo.com', $this->getCompanyName());
	}
	
	// get company address
	public function getCompanyAddress()
	{
		return '';
	}
	
	// get tax rate
	public function getTaxState()
	{ 
		return 'FL';
	}
	
	// get tax rate
	public function getTaxRate()
	{ 
		return 7;
	}
}
?>