<?php
	class upload_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function upload_image($imagedata)
		{
			$this->db->insert('images',$imagedata);
			
			if ($this->db->affected_rows() > 0)
				return $this->db->insert_id();

			else
				return false;
		}

		public function update_image($imageid=FALSE,$imagedata)
		{
			if ($imageid===FALSE || !is_array($imagedata))
				return false;

			$this->db->where('imageid',$imageid);
			$this->db->update('images',$imagedata);
			return $this->db->affected_rows()>0;
		}

		public function getimagedetails($imageid=FALSE)
		{
			if ($imageid===FALSE)
				return false;

			else
			{
				$query = $this->db->get_where('images',array('imageid'=>$imageid));
				return $query->row_array();
			}
		}
	}