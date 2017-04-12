<?php

class settings_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function check_profileid_avail($userid=FALSE, $profileid=FALSE)
	{
		$this->db->where('profileid',$profileid);
		$this->db->where('userid !=',$userid);

		$query = $this->db->get('users');
		if ($query->num_rows()>0)
			return false;
		return true;	
	}

	public function check_email_avail($userid=FALSE, $email=FALSE)
	{
		$this->db->where('email',$email);
		$this->db->where('userid !=',$userid);

		$query = $this->db->get('users');
		if ($query->num_rows()>0)
			return false;
		return true;	
	}

		public function login_credential_check($userid, $password)
		{
			$query = $this->db->get_where('users',array('userid'=>$userid, 'password'=>$password));
			if ($query->num_rows() == 1)
				return true;
			return false;
		}
}

?>