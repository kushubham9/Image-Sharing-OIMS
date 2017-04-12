<?php

	class User_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function registration ($userdetails = FALSE)
		{
			if ($userdetails === FALSE || !is_array($userdetails))
				return false;

			else
			{
				$this->db->insert('users',$userdetails);
				return $this->db->affected_rows() > 0;
			}
		}

		public function usercheck_email ($email = FALSE)
		{
			if ($email === FALSE)
				return false;

			else
			{
				$query = $this->db->get_where('users',array('email'=>$email));
				if ($query->num_rows() >=1)
					return false;
			}
			return true;
		}

		public function usercheck_profileid ($profileid = FALSE)
		{
			if ($profileid === FALSE)
				return false;

			else
			{
				$query = $this->db->get_where('users',array('profileid'=>$profileid));
				if ($query->num_rows() >=1)
					return false;
			}
			return true;
		}

		public function get_user($userid = FALSE)
		{
			if ($userid === FALSE)
				return false;

			else
			{
				$query = $this->db->get_where('users',array('userid'=>$userid));
				return $query->row_array();
			}
		}

		public function get_userdetails($email = FALSE, $profileid = FALSE)
		{
			if ($email!==FALSE)
			{
				$query = $this->db->get_where('users',array('email'=>$email));
				$userdetails = $query->row_array();
				return $userdetails;
			}

			else if ($profileid !== FALSE)
			{
				$query = $this->db->get_where('users',array('profileid'=>$profileid));
				$userdetails = $query->row_array();
				return $userdetails;
			}

			return false;
		}

		public function generate_resetkey($userid = FALSE)
		{
			if ($userid===FALSE)
				return false;

			$data['status'] = 0;
			$this->db->where('status',1);
			$this->db->where('userid',$userid);
			$this->db->update('passwordreset',$data);

			$resetdata['userid'] = $userid;
			$resetdata['expirytime'] = date('Y-m-d H:i:s', strtotime("+24 hours"));  
			$resetdata['resetkey'] = random_string('alnum', 32); // Generates 32 character string.
			$resetdata['dategenerated'] = date("Y-m-d",strtotime("now"));
			$resetdata['status'] = 1;
			
			$this->db->insert('passwordreset',$resetdata);
			return $resetdata['resetkey'];
		}

		public function check_resetkey($key=FALSE)
		{
			if ($key === FALSE)
				return false;

			else
			{
				$this->db->where('resetkey',$key);
				$this->db->where('status',1);
				$query = $this->db->get('passwordreset');

				if ($query->num_rows() != 1)
					return false;

				else
					return $query->row_array();
			}
		}

		public function deactivate_resetkey($resetid=FALSE)
		{
			if ($resetid===FALSE)
				return false;
			else
			{
				$data['status']=0;
				$this->db->where('resetid',$resetid);
				$this->db->update('passwordreset',$data);

				return $this->db->affected_rows() > 0;
			}
		}

		public function update_user_table($userid=FALSE,$data)
		{
			if (!is_array($data))
				return false;

			if ($userid === FALSE)
				return false;

			$this->db->where('userid',$userid);
			$this->db->update('users',$data);

			return $this->db->affected_rows() > 0;
		}


		public function login($logindetails=FALSE) /*Used by Login form to authenticate and log in the user. WOrks on email.*/
		{
			if ($logindetails===FALSE || !is_array($logindetails))
				return false;

			$userdetails = $this->get_userdetails($logindetails['email']);
			if (!strcmp($userdetails['password'], $logindetails['password']))
				return $userdetails;

			return false;
		}

	
	}