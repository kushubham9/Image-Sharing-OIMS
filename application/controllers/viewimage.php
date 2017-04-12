<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Image Controller*/

class viewimage extends CI_Controller {
	private $logged_in = FALSE;
	private $userid;
	
	function __construct()
	{  
		parent::__construct();
	   	$this->load->helper('url');
	   	$this->load->model('user_model');
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
		$this->userid = $userdata;
		return $userdata;
	}

	public function index($imageid=FALSE)
	{
		echo ('no access');
	}

	public function id ($imageid=FALSE)
	{
		if ($imageid===FALSE)
		{
			$this->session->set_flashdata('failure_mess','Invalid Image Specified.');
			redirect ('upload','refresh');
			return;
		}

		$this->load->helper('form');
		$this->load->model('image_model');
		$data['imagedetails'] = $this->image_model->getimagedetails($imageid);

		if (!isset($data['imagedetails']['imageid']))
		{
			$this->session->set_flashdata('failure_mess','Invalid Image Specified.');
			redirect ('upload','refresh');
			return;
		}

		else
		{
			$data['userreviews'] = $this->getuserreviews($imageid);
			
			if ($this->userid)
				$data['userdetails'] = $this->user_model->get_user($this->userid);

			if ($data['imagedetails']['userid']!='')
				$data['img_owner_details'] = $this->user_model->get_user($data['imagedetails']['userid']);

			if ($data['imagedetails']['userid'] == $this->userid && $this->userid)
				$data['delcomment'] = TRUE;
			else
				$data['delcomment']=FALSE;

			
			if ($data['imagedetails']['albumid'])
			{
				$this->load->model('album_model');
				$data['otheralbumimages']=$this->album_model->getalbumimages($data['imagedetails']['albumid'],6);
			}


			if (isset($data['otheralbumimages']))
			{
			foreach($data['otheralbumimages'] as $key => $subarray) {
			   foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['otheralbumimages'][$key]['src'] =  $this->get_thumbimage($data['otheralbumimages'][$key]['src']);
			   }
			}
			}


			

			if ($this->userid)
				{
					$this->load->model('album_model');
					$data['useralbums'] = $this->album_model->getuseralbums($this->userid);
				}

			$data['title'] = $data['imagedetails']['title'];
			$data['additional_js']='
				<script type="text/javascript">var switchTo5x=true;</script>	
				<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
				<script type="text/javascript">stLight.options({publisher: "ab116343-30af-4b4e-b04f-68a5d6c1c5b7", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>';
			
			$this->load->view('header/header.inc',$data);
			$this->load->view('viewimage',$data);
		
			$update_view['views'] = $data['imagedetails']['views']+1;
			$this->image_model->edit_image_details($update_view,$data['imagedetails']['imageid']);
		}
	}


	public function get_thumbimage($imgsrc)
	{
		$offset = strpos($imgsrc, '.');
		return substr_replace($imgsrc, '_thumb', $offset,0);
	}

	public function addcomment()
	{
		if (!$this->input->post('submit'))
		{	
			$this->session->set_flashdata('failure_mess','Sorry, Invalid Link Specified');
			redirect('upload','refresh');
			return;
		}
		
		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'First Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email_avail');
		$this->form_validation->set_rules('description', 'Description', 'required|trim');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Invalid Form credentials specified');
			redirect ($_SERVER['HTTP_REFERER']);
			return;
		}

		else
		{
			$review['username'] = $this->input->post('username');
			$review['email']=$this->input->post('email');
			$review['imageid'] = $this->input->post('imageid');
			$review['description']=$this->input->post('description');
			$review['ip']=$_SERVER['REMOTE_ADDR'];

			$this->load->model('review_model');
			if ($this->review_model->insert_review($review))
			{	
				$this->session->set_flashdata('success_mess','Review posted successfully');
				redirect ($_SERVER['HTTP_REFERER']);
			}

			else
			{
				$this->session->set_flashdata('failure_mess','Sorry, Something went wrong.');
				redirect ($_SERVER['HTTP_REFERER']);
				return;
			}


			return;

		}
	}

	public function deletecomment($reviewid = FALSE)
	{
		if ($reviewid===FALSE)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Invalid Link Specified.');
			redirect ('upload','refresh');
			return;
		}

		if (!$this->userid)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Login First.');
			redirect ('user/login','refresh');
			return;
		}

		$this->load->model('review_model');
		if ($this->review_model->removecomment($reviewid,$this->userid))
		{	
			$this->session->set_flashdata('success_mess','Review deleted successfully');
			redirect ($_SERVER['HTTP_REFERER']);
			return;
		}

		else
		{	
			$this->session->set_flashdata('failure_mess','Review deletion failed');
			redirect ($_SERVER['HTTP_REFERER']);
			return;
		}
	}

	private function getuserreviews($imageid)
	{
		$this->load->model('image_model');
		return $this->image_model->getreviews($imageid);
	}

	public function deleteimage ($imageid)
	{
		$this->load->model('image_model');
		
		$imagedetails = $this->image_model->getimagedetails($imageid);
		if (isset($imagedetails['userid']) && $imagedetails['userid']!='')
		{
			if ($imagedetails['userid']==$this->userid)
			{
				$this->image_model->deleteimage ($imageid);
				unlink ($imagedetails['src']);
				unlink ($this->get_thumbimage($imagedetails['src']));
				redirect ($_SERVER['HTTP_REFERER'],'refresh');
			}
			else
			{
				die('Permission error');
			}
		}
		
		else
		{
			echo ('Image not found');
		}
	
	}

	public function deletemultiple ()
	{
		$this->load->model('image_model');
		if ($this->input->get('imageid'))
		{
			$images = $this->input->get('imageid');

			foreach ($images as $value) {
				$imagedetails = $this->image_model->getimagedetails($value);
				if (isset($imagedetails['userid']) && $imagedetails['userid']!='')
				{
					if ($imagedetails['userid']==$this->userid)
					{
						$this->image_model->deleteimage ($value);
						unlink ($imagedetails['src']);
					}
					else
					{
						die('Permission error');
					}
				}
			}

			redirect ($_SERVER['HTTP_REFERER'],'refresh');

		}

		else
			return false;

	}


	public function editimage($imageid=FALSE)
	{
		if (!$this->userid)
			die('no permission, do login');

		if ($imageid===FALSE)
			return false;

		$this->load->model('image_model');
		$data['imagedetails'] = $this->image_model->getimagedetails($imageid);
		if (isset($data['imagedetails']['imageid']))
		{
			if (!$data['imagedetails']['userid']==$this->userid)
				die('no permission');

			else
			{
				$data['categories'] = $this->image_model->getcategories();
				$this->load->model('album_model');
				$data['useralbum']=$this->album_model->getuseralbums($this->userid);
				$this->load->helper('form');

				$data['title'] = "Edit Image Information";

				$this->load->view('header/header.inc',$data);
				$this->load->view('editimage',$data);
			}
		}

		else
		{
			die('invalid image specified.');
		}
	}

	public function embeded_code()
	{
		$images = $this->input->get('imageid');
		if (!$images)
		{
			$this->session->set_flashdata('failure_mess','Sorry, Invalid Request Made');
			redirect('','refresh');
			return;
		}
		$this->load->model('image_model');
		$data['imagedetails'] = $this->image_model->get_multiple_images($images);

		foreach($data['imagedetails'] as $key => $subarray) {
			   foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['imagedetails'][$key]['thumb_src'] =  $this->get_thumbimage($data['imagedetails'][$key]['src']);
			   }
			}
		$data['success_mess']="Embedded Code generated for ".sizeof($data['imagedetails'])." Images";
		$data['title']="Embedded Code";
		$this->load->view('header/header.inc',$data);
		$this->load->view('embeded_code',$data);
		return;
	}

	public function editimage_doedit()
	{
		if (!$this->userid)
			die('no permission, do login');

		if (!$this->input->post('imageid'))
			die ('no image selected');

		else
			$imageid = $this->input->post('imageid');

		$this->load->model('image_model');
		$data['imagedetails'] = $this->image_model->getimagedetails($imageid);
		if (isset($data['imagedetails']['imageid']))
		{
			if (!$data['imagedetails']['userid']==$this->userid)
				die('no permission');

			else
			{
				$newimagedata['categoryid']=$this->input->post('categoryid');
				$newimagedata['title']=$this->input->post('title');
				$newimagedata['albumid']=$this->input->post('albumid');

				foreach ($newimagedata as $key => $value) {
					if ($value == '')
						$newimagedata[$key] = NULL;
				}

				if ($this->image_model->edit_image_details($newimagedata,$imageid))
					$this->session->set_flashdata('success_mess', 'Changes have been made successfully. ');
				
				redirect ($_SERVER['HTTP_REFERER'],'refresh');
			}
		}
	}

	public function random()
	{
		$data['title'] = "Random Images";
		$data['additional_js'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/style1.css'.'"/>';
				
		$this->load->model('image_model');
		$data['imagedetails']= $this->image_model->getrandomimages();
		if ($this->userid)
		{
			$data['userdetails'] = $this->user_model->get_user($this->userid);
			$this->load->model('album_model');
			$data['useralbums'] = $this->album_model->getuseralbums($this->userid);
			$data['userdetails']['album_num'] = sizeof($data['useralbums']);
			$data['userdetails']['image_num'] = $this->image_model->countuserimages($this->userid);
		}

		foreach($data['imagedetails'] as $key => $subarray) {
			   foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['imagedetails'][$key]['thumb_src'] =  $this->get_thumbimage($data['imagedetails'][$key]['src']);
			   }
			}
		$this->load->view('header/header.inc',$data);	
		$this->load->view('random',$data);
		
	}

	public function category($categoryid = FALSE)
	{
		if ($categoryid===FALSE)
		{
			$this->session->set_flashdata("failure_mess",'Invalid Category Specified');
			redirect('','refresh');
			return;
		}
		$this->load->model('image_model');
		$data['additional_js'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/style1.css'.'"/>';
		
		$data['categorydetails'] = $this->image_model->getcategory($categoryid);
		if (!$data['categorydetails']['categoryid'])
		{
			$this->session->set_flashdata("failure_mess",'Invalid Category Specified');
			redirect('','refresh');
			return;
		}

		else
		{
			$data['imagedetails'] = $this->image_model->getcategoryimages($categoryid);

			if (sizeof($data['imagedetails'])==0)
			{
				$this->session->set_flashdata("failure_mess",'No Images Belongs to this category.');
				redirect('','refresh');
				return;
			}
		
			
			foreach($data['imagedetails'] as $key => $subarray) {
			   foreach($subarray as $subkey => $subsubarray) {
			   	if ($subkey == 'src')
			      $data['imagedetails'][$key]['thumb_src'] =  $this->get_thumbimage($data['imagedetails'][$key]['src']);
			   }
			}

			if ($this->userid)
			{
				$data['userdetails'] = $this->user_model->get_user($this->userid);
				$this->load->model('album_model');
				$data['useralbums'] = $this->album_model->getuseralbums($this->userid);
				$data['userdetails']['album_num'] = sizeof($data['useralbums']);
				$data['userdetails']['image_num'] = $this->image_model->countuserimages($this->userid);
			}
			
		}
			$this->load->view('header/header.inc',$data);
			$this->load->view('viewcategory',$data);
	}
}
