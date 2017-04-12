<?php
	class review_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function getreviews($imageid)
		{

		}

		public function insert_review($review)
		{
			if (!is_array($review))
				return false;

			$this->db->insert('reviews',$review);
			return $this->db->affected_rows()>0;
		}

		public function removecomment($reviewid = FALSE, $userid = FALSE)
		{
			if ($reviewid===FALSE)
				return false;

			if ($userid === FALSE)
			{
				$this->db->delete('reviews',array('reviewid'=>$reviewid));
				return $this->db->affected_rows();
			}

			else
			{
				$query = "DELETE reviews FROM reviews WHERE reviewid = $reviewid AND imageid IN (SELECT imageid from images where userid = $userid)";
				$this->db->query($query);           
				return $this->db->affected_rows()>0;
			}


		}
	}
