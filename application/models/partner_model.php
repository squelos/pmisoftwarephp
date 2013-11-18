<?php

class Partner_model extends CI_Model  {   

	function Partner_model()
	{
		parent::__construct();
		$this->load->database('default');
	}
	
	function test()
	{
		$queryPartner = $this->db->query('SELECT * FROM test');
		
		return $queryPartner;
	}
}
?>