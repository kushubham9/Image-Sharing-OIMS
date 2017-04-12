<?php
	class image_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function image_owner($imageid,$userid)
		{
			$this->db->where('imageid',$imageid);
			$this->db->where('userid',$userid);
			$query = $this->db->get('images');
			return $query->num_rows()>0;
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

		public function getreviews($imageid=FALSE)
		{
			if ($imageid===FALSE)
				return false;

			else
			{
				$this->db->order_by("date_added", "desc"); 
				$query = $this->db->get_where('reviews',array('imageid'=>$imageid));
				return $query->result_array();
			}
		}

		public function getuserimages($userid,$asc = FALSE,$limit,$start)
		{
			if ($asc)
				$this->db->order_by('date_uploaded','asc');
			else
				$this->db->order_by('date_uploaded','desc');

			$this->db->limit($limit, $start);
				$query = $this->db->get_where('images',array('userid'=>$userid));
				return $query->result_array();
		}

		public function countuserimages($userid)
		{
			$this->db->where('userid',$userid);
			$this->db->from('images');
			return $this->db->count_all_results();
			// return $this->db->count_all('images');;
		}

		public function deleteimage ($imageid)
		{
			$this->db->delete('images',array('imageid'=>$imageid));
			return $this->db->affected_rows()>0;
		}

		public function getcategories()
		{
			$this->db->order_by('categoryname','ASC');
			$query = $this->db->get('categories');

			return $query->result_array();
		}

		public function edit_image_details($imagedetails,$imageid)
		{
			if (!is_array($imagedetails))
				return false;

			$this->db->where('imageid',$imageid);
			$this->db->update('images',$imagedetails);
			return $this->db->affected_rows()>0;
		}

		public function get_multiple_images($imageid)
		{
			$imageid = (array)$imageid;
			$this->db->where_in('imageid',$imageid);
			$query = $this->db->get('images');

			return $query->result_array();
		}

		public function getrandomimages()
		{
			$this->db->limit(20);
			$this->db->order_by('RAND()',false);
			$query = $this->db->get('images');
			return $query->result_array();
		}

		public function getcategoryimages($categoryid)
		{
			$query = $this->db->get_where('images',array('categoryid'=>$categoryid));
			return $query->result_array();
		}

		public function getcategory($categoryid)
		{
			$query = $this->db->get_where('categories',array('categoryid'=>$categoryid));
			return $query->row_array();
		}
	}

?>