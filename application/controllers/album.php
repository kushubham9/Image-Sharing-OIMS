<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class album extends CI_Controller {

	private $logged_in = FALSE;
	private $userid;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
	   	$this->load->model('user_model');
	   	$this->load->model('album_model');
		$this->load->library('session');
	 	$this->load->config('oims_config');
	 	$this->globalcategory();
		if ($this->check_logged_in())
		   	$this->logged_in = TRUE;
	}

	private function globalcategory()
	{	
		$this->load->model('image_model');
		$categories = $this->image_model->getcategories();
		$this->session->set_userdata('globalcategory', $categories);
	}

	private function check_logged_in()
	{
		$userdata = $this->session->userdata('userid');
		if ($userdata)
			$this->userid = $userdata;
		return $userdata;
	}

	public function get_thumbimage($imgsrc)
	{
		$offset = strpos($imgsrc, '.');
		return substr_replace($imgsrc, '_thumb', $offset,0);
	}

	public function index ()
	{
		if (!$this->userid)
		{
			$this->session->set_flashdata('failure_mess','Sorry, You must login first.');
			redirect('user/login','refresh');
			return;
		}
		
		else
		{
			redirect('album/show/'.$this->userid,'refresh');
			return;
		}
		
	}

	public function show ($userid = FALSE)
	{
		if ($userid===FALSE)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Invalid Profile ID specified.');
			redirect('','refresh');
			return;
		}
		else
		{
			$data['userdetails'] = $this->user_model->get_user($userid);
			if (!isset($data['userdetails']['userid']))
			{
				$this->session->set_flashdata('failure_mess','Sorry, Invalid Profile ID specified.');
				redirect('','refresh');
				return;
			}

			if ($data['userdetails']['userid'] == $this->userid)
			{
				$data['control_perm'] = true;
			}

			else
				$data['control_perm']=false;

			$data['albumdetails'] = $this->album_model->getuseralbums($userid);

			$data['userdetails']['album_num'] = sizeof($data['albumdetails']);
			$this->load->model('image_model');
			$data['userdetails']['image_num'] = $this->image_model->countuserimages($userid);

			foreach ($data['albumdetails'] as $key => $value) {
				$data['imagedetails'][$value['albumid']] = $this->album_model->getalbumimages($value['albumid'],4);
			
			foreach ($data['imagedetails'][$value['albumid']] as $key => $subarray) {
				foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['imagedetails'][$value['albumid']][$key]['thumb_src'] =  $this->get_thumbimage($data['imagedetails'][$value['albumid']][$key]['src']);
			   }
			}
			}

			$data['title'] = 'Album Details';
			$data['additional_js']='<link rel="stylesheet" type="text/css" href="'.base_url().'assets/style1.css'.'"/>
				<script type="text/javascript">var switchTo5x=true;</script>	
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher: "ab116343-30af-4b4e-b04f-68a5d6c1c5b7", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>';
		
			$this->load->view('header/header.inc',$data);
			$this->load->view('albums',$data);
		}
	}

	public function view($albumid)
	{
		$data['albumdetails'] = $this->album_model->getalbumdetails ($albumid);
		$data['control_perm'] = false;
		if (!isset($data['albumdetails']['albumid']))
		{
			$this->session->set_flashdata('failure_mess','Invalid Album Specified');
			redirect('','refresh');
			return;
		}

		if ($data['albumdetails']['private']==1 && $data['albumdetails']['userid']!=$this->userid)
		{
			$this->session->set_flashdata('failure_mess','Private Album. Permission not granted.');
			redirect('','refresh');
			return;
		}

		if ($data['albumdetails']['userid']==$this->userid && $this->userid)
		{
			$data['control_perm']=true;
		}

		$data['userdetails']=$this->user_model->get_user($data['albumdetails']['userid']);
		$data['useralbums']=$this->album_model->getuseralbums($data['albumdetails']['userid']);
		$data['userdetails']['album_num'] = sizeof($data['useralbums']);
		$data['imagedetails'] = $this->album_model->getalbumimages($albumid);

		foreach($data['imagedetails'] as $key => $subarray) {
			   foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['imagedetails'][$key]['src'] =  $this->get_thumbimage($data['imagedetails'][$key]['src']);
			   }
			}

		$data['albumdetails']['image_num']=sizeof($data['imagedetails']);

		$this->load->model('image_model');
			$data['userdetails']['image_num'] = $this->image_model->countuserimages($data['albumdetails']['userid']);

		
		$data['additional_js']='<link rel="stylesheet" type="text/css" href="'.base_url().'assets/style1.css'.'"/>
				<script type="text/javascript">var switchTo5x=true;</script>	
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher: "ab116343-30af-4b4e-b04f-68a5d6c1c5b7", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>';
			
		$data['title'] = $data['albumdetails']['album_name'];
		$this->load->view('header/header.inc',$data);
		$this->load->view('viewalbum',$data);
		return;
	}

	public function editalbum($albumid=FALSE)
	{
		if ($albumid===FALSE)
		{
			$this->session->set_flashdata('failure_mess','Access Denied');
			redirect('','refresh');
			return;

		}

		if (!$this->userid)
		{
			$this->session->set_flashdata('failure_mess','Permission Denied, Login First');
			redirect('user/login','refresh');
			return;
		}
		$data['albumdetails'] = $this->album_model->getalbumdetails ($albumid);
		if (!isset($data['albumdetails']['albumid']))
		{
			$this->session->set_flashdata('failure_mess','Invalid Album Specified.');
			redirect('','refresh');
			return;
		}

		if ($data['albumdetails']['userid'] != $this->userid)
		{
			$this->session->set_flashdata('failure_mess','Access Denied. Album Ownership Failure.');
			redirect('','refresh');
			return;
		}

		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		$this->form_validation->set_message('checkalbum_avail', 'Sorry, But the album name is already registered.');
		
		$this->form_validation->set_rules('albumname', 'Album Name', 'required|trim|callback_checkalbum_avail');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{

			$data['title'] = "Modify Album";
			$this->load->view('header/header.inc',$data);
			$this->load->view('editalbum',$data);
		}

		else
		{
			$albumdata['album_name']=$this->input->post('albumname');
			$albumdata['description']=$this->input->post('description');
			$albumdata['private']=$this->input->post('privacy');

			if ($this->album_model->updatealbum($albumdata,$data['albumdetails']['albumid']))
			{
				$this->session->set_flashdata('success_mess','Update Successfull');
				
			}

			redirect ($_SERVER['HTTP_REFERER'],'refresh');
			return;

		}

	}


	// public function checkalbum_avail2($str,$albumid)
	// {
	// 	if (!$this->album_model->album_name_chk($str,$this->userid,$albumid))
	// 		return true;
	// 	return false;

	// }


	public function movetoalbum($images=FALSE)
	{
		if (!$this->userid)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Please login first.');
			redirect('','refresh');
			return;

		}

		if (!isset($_GET['albumid']))
		{
			$this->session->set_flashdata('failure_mess','No Image Specified');
			redirect('','refresh');
			return;
		}


		$albumid = $this->input->get('albumid');
		if (!$albumid == 0)
		{
			if (!$this->album_model->checkalbum_auth($albumid,$this->userid))
			{
				$this->session->set_flashdata('failure_mess','Permission Denied.');
				redirect('','refresh');
				return;
			}

		}

		if ($images===FALSE)
		{
			if (!$this->input->get('imageid'))
				return false;

			else
				$images = $this->input->get('imageid');
		}

		if (!is_array($images))
			$images = (array)$images;
		
		$this->load->model('image_model');

		foreach ($images as $value) {
			{
				if ($this->image_model->image_owner($value,$this->userid))
					$this->album_model->addtoalbum($value,$albumid);
			}
		}
		$this->session->set_flashdata('success_mess','Images Moved to Album successfully');
		redirect($_SERVER['HTTP_REFERER'],'refresh');
		return;
	}

	public function createalbum()
	{
		if (!$this->userid)
		{
			die ('permission error');
			return;
		}

		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		$this->form_validation->set_message('checkalbum_avail', 'Sorry, But the album name is already registered.');
		
		$this->form_validation->set_rules('albumname', 'Album Name', 'required|trim|callback_checkalbum_avail');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title']="Create an Album";
			$this->load->view('header/header.inc',$data);
			$this->load->view('newalbum',$data);
		}

		else
		{
			$albumdata['album_name']= $this->input->post('albumname');
			$albumdata['description']= $this->input->post('description');
			$albumdata['userid']= $this->userid;
			$albumdata['private']= $this->input->post('privacy');
		

			if ($this->album_model->add_album($albumdata))
				{
					$this->session->set_flashdata('success_mess','Album Created Successfully.');
					return;
				}
		}
	}

	public function checkalbum_avail($str)
	{
		if ($this->input->post('albumid'))
		{
			$albuminfo = $this->album_model->getalbumdetails($this->input->post('albumid'));
			if ($albuminfo['album_name'] = $str)
				return true;
		}
		return $this->album_model->albumname_avail($str,$this->userid);
	}

	public function deletemultiplealbum()
	{
		if (!$this->userid)
			die ('login first');

		if (!$this->input->get('albumid'))
			die ('no album selected');

		$albumid = $this->input->get('albumid');

		$this->album_model->deletealbum($albumid,$this->userid);
		$this->session->set_flashdata('success_mess','Albums Deleted.');
		redirect ($_SERVER['HTTP_REFERER'],'refresh');
	}

}