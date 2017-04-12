<?php
	class album_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
		}

		public function getalbumdetails ($albumid=FALSE)
		{
			if ($albumid===FALSE)
				return false;

			else
			{
				$query= $this->db->get_where('albums',array('albumid'=>$albumid));
				return $query->row_array();
			}
		}

		public function getalbumimages($albumid,$limit=FALSE)
		{
			if ($limit!==FALSE)
				$this->db->limit($limit);
			$this->db->order_by('date_uploaded','desc');
			$query = $this->db->get_where('images',array('albumid'=>$albumid));
			return $query->result_array();
		}


		public function checkalbum_auth($albumid, $userid)
		{
			$this->db->where('albumid',$albumid);
			$this->db->where('userid',$userid);
			$query= $this->db->get('albums');
			if ($query->num_rows()>0)
				return true;

			else
				return false;
		}

		public function addtoalbum($imageid,$albumid)
		{
			if ($albumid==0)
				$data['albumid'] = NULL;

			else
				$data['albumid'] = $albumid;

			$this->db->where('imageid',$imageid);
			$this->db->update('images',$data);
			return $this->db->affected_rows()>0;
		}

		public function albumname_avail($albumname, $userid)
		{
			$this->db->where('album_name',$albumname);
			$this->db->where('userid',$userid);
			$query = $this->db->get('albums');
			if ($query->num_rows()>0)
				return false;

			return true;
		}

		public function album_name_chk($album_name,$userid,$albumid)
		{
			$this->db->where('album_name',$album_name);
			$this->db->where('userid',$userid);
			$this->db->where('albumid !=',$albumid);
			$query = $this->db->get('albums');
			return $query->num_rows()>0;
		}

		public function updatealbum($albumdata,$albumid)
		{
			$this->db->where('albumid',$albumid);
			$this->db->update('albums',$albumdata);
			return $this->db->affected_rows()>0;
		}

		public function add_album($albumdata)
		{
			$this->db->insert('albums',$albumdata);
			return $this->db->affected_rows()>0;
		}

		public function getuseralbums($userid)
		{
			$this->db->order_by('date_created','desc');
			$query = $this->db->get_where('albums',array('userid'=>$userid));

			return $query->result_array();
		}

		public function deletealbum($albumid,$userid)
		{
			if (!is_array($albumid))
				$albumid = (array)$albumid;

			$this->db->where_in('albumid',$albumid);
			$this->db->where('userid',$userid);
			$this->db->delete('albums');
			return $this->db->affected_rows()>0;
		}

	}

?>