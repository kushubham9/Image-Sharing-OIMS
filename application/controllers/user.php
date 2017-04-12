<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {
	private $logged_in = FALSE;
	private $userid = false;

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
		if ($userdata)
			$this->userid = $userdata;
		return $userdata;
	}

	public function index()
	{
		if ($this->userid)
			{
				$profileid = $this->session->userdata('profileid');
				redirect ('user/view/'.$profileid,'refresh');
			}
		
		else
		{
			redirect ('user/login','refresh');
			return;
		}	
	}

	public function view($profileid=FALSE)
	{
		if ($profileid===FALSE)
		{
			if ($this->userid)
			{
				$profileid = $this->session->userdata('profileid');
				redirect ('user/view/'.$profileid,'refresh');
			}

			else
				redirect ('user/login','refresh');
			return;
		}

		else
		{
			$data['userdetails'] = $this->user_model->get_userdetails(false,$profileid);

			if ($data['userdetails']['userid'] == $this->userid && $this->userid)
			{
				$data['profile_owner'] = true;
			}

			if (!isset($data['userdetails']['userid']))
			{
				$this->session->set_flashdata('failure_mess','Sorry, Invalid Profile ID Specified.');
				redirect('','refresh');
				return;
			}



			else
			{
				$this->load->library("pagination");
				$this->load->model('image_model');
				$config = array();
		        $config["base_url"] = site_url() . "/user/view/$profileid/";

		        $config["total_rows"] = $this->image_model->countuserimages($data['userdetails']['userid']);

		        $config['full_tag_open'] = "<ul class='pagination'>";
				$config['full_tag_close'] ="</ul>";
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
				$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
				$config['next_tag_open'] = "<li>";
				$config['next_tagl_close'] = "</li>";
				$config['prev_tag_open'] = "<li>";
				$config['prev_tagl_close'] = "</li>";
				$config['first_tag_open'] = "<li>";
				$config['first_tagl_close'] = "</li>";
				$config['last_tag_open'] = "<li>";
				$config['last_tagl_close'] = "</li>";
		        $data['userdetails']['image_num']=$config['total_rows'];
		      
		        $config["per_page"] = 20;
		        $config["uri_segment"] = 4;
 
        		$this->pagination->initialize($config);

        		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		     	
		     	$data['userimages'] = $this->image_model->getuserimages($data['userdetails']['userid'],false,$config["per_page"], $page);
				
				if (sizeof($data['userimages'])>0)
				{
					foreach($data['userimages'] as $key => $subarray) {
					   foreach($subarray as $subkey => $subsubarray) {
					   	if ($subkey == 'src')
					      $data['userimages'][$key]['thumb_src'] =  $this->get_thumbimage($data['userimages'][$key]['src']);
					   }
					}
				}

				$data["links"] = $this->pagination->create_links();

				$this->load->model('album_model');
				$data['useralbums'] = $this->album_model->getuseralbums($data['userdetails']['userid']);
				$data['userdetails']['album_num'] = sizeof($data['useralbums']);
				

				$data['additional_js'] = '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/style1.css'.'"/>';
				$this->load->view('header/header.inc',$data);
				$this->load->view('user/viewprofile',$data);
				return;
			}
		}
	}

	public function get_thumbimage($imgsrc)
	{
		$offset = strpos($imgsrc, '.');
		return substr_replace($imgsrc, '_thumb', $offset,0);
	}

	public function registration()
	{
		if ($this->logged_in)
		{
			$this->session->set_flashdata('failure_mess','Sorry,You are already registered.');
			redirect('','refresh');
			return;
		}
		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		$this->form_validation->set_message('check_profileid', 'Sorry, This Profile Id is already taken.');
		$this->form_validation->set_message('check_email_avail','Sorry, This Email id is already taken.');

		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim');
		$this->form_validation->set_rules('profileid', 'User Name', 'required|trim|callback_check_profileid');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email_avail');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_conf]|min_length[6]|md5');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "User Registration";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/registration',$data);
			return;
		}
		else
		{
			$userdetails = array();
			$userdetails['first_name'] = $this->input->post('firstname');
			$userdetails['last_name'] = $this->input->post('lastname');
			$userdetails['gender'] = $this->input->post('gender');
			$userdetails['profileid'] = $this->input->post('profileid');
			$userdetails['password'] = $this->input->post('password');
			$userdetails['email'] = $this->input->post('email');
			$userdetails['date_registered'] = date('Y-m-d',strtotime("now"));

			if ($this->user_model->registration($userdetails))
			{
				$this->session->set_flashdata('success_mess','Successfully Registered. Login & share unlimited images.');
				redirect('','refresh');
				return;
			}
			
		}
	}

	public function login()
	{
		if ($this->logged_in)
		{
			$this->session->set_flashdata('failure_mess','Sorry,You are already logged in.');
			redirect('user','refresh');
			return;
		}

		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		
		$this->form_validation->set_message('check_email','Invalid Email Id specified. Kindly <a href="'.site_url('user/registration').'"> Register </a>');

		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|md5');
	
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "User Login";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/login',$data);
			return;
		}

		else
		{
			$logindetails = array();
			$logindetails['email'] = $this->input->post('email');
			$logindetails['password'] = $this->input->post('password');

			$userdetails = $this->user_model->login($logindetails);
			if ($userdetails) /*Login Successfull*/
			{
				$userdata = array();
				$userdata['firstname']= $userdetails['first_name'];
				$userdata['profileid']= $userdetails['profileid'];
				$userdata['userid']= $userdetails['userid'];
				
				$this->session->set_flashdata('success_mess','Howdy '.$userdata['firstname']);
			
				$this->session->set_userdata($userdata);
				redirect('user','refresh');
			}

			else /*Login Failure*/
			{
				$data['title'] = "Invalid Credentials Specified | User Login";
				
				$data['customerror']= "Sorry, The email & password combination doesn't match. <a href='".site_url('user/forgotpassword')."'>Forgot Password</a>. ";
				$this->load->view('header/header.inc',$data);
				$this->load->view('user/login',$data);	
				return;
			}
		}
	}

	public function forgotpassword()
	{
		if ($this->logged_in)
		{
			$this->session->set_flashdata('failure_mess','Sorry,You are already logged in.');
			redirect('user','refresh');
			return;
		}

		$this->load->helper(array('form'));

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		
		$this->form_validation->set_message('check_email','Invalid Email Id specified. Kindly <a href="'.site_url('user/registration').'"> Register </a>');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Password Recovery";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/forgotpassword',$data);
		}

		else
		{
			$email = $this->input->post('email');
			$userdetails = $this->user_model->get_userdetails($email);
			echo site_url('user/resetpassword/'.$this->user_model->generate_resetkey($userdetails['userid']));

		}

	}

	public function resetpassword($resetkey=FALSE)
	{
	  if ($this->logged_in)
	  {
	      $this->session->set_flashdata('failure_mess','Sorry, You are already logged in.');
		redirect('user','refresh');
			return;
	  }

	  if ($resetkey===FALSE)
	  {
	    show_404();
	  }

	  $resetkeyinfo = $this->user_model->check_resetkey($resetkey);
 
	  if (is_array($resetkeyinfo))
	  {
	  	$expirytime = strtotime($resetkeyinfo['expirytime']);
		$currenttime = time();

		if ($currenttime > $expirytime)
		{
			if ($this->user_model->deactivate_resetkey($resetkeyinfo['resetid']))
				echo ('Sorry, but the reset key has expired. Kindly Reset your password again.');

			return;

		}

	    $sess_array = array(
	         'userid' => $resetkeyinfo['userid'],
	          'resetid' => $resetkeyinfo['resetid']
	        );
	     
	    $this->session->set_userdata('resetpasswordsession', $sess_array); 
	    $this->load->helper(array('form'));
	    $data['title'] = "Provide New Password";
	    $this->load->view('header/header.inc',$data);
		$this->load->view('user/password_reset_form',$data);	
	    return;

	  }

	  else
	  {
	    $this->session->set_flashdata('failure_mess','Sorry, Reset Key specified is invalid.');
			redirect('','refresh');
			return;
	  }

	 }

	

	 public function change_reset_pass()
	 {
	  if ($this->logged_in)
	  	{echo ('already logged in');
	  	return;}

	  if (!$this->session->userdata('resetpasswordsession'))
	   { show_404();
	   	return;
	   }


	  	$this->load->library('form_validation');
	  	$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
	  	$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_conf]|min_length[6]|md5');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required');
	    
	    if($this->form_validation->run() == FALSE)  //Field validation failed.  User redirected to login page
	    {
	    	$data['title'] = "Passwords doesn't match";
	    	$this->load->view('header/header.inc',$data);
			$this->load->view('user/password_reset_form',$data);	
			return;

	    }

	    else
	    {
	      $data = array('password' => $this->input->post('password'));
	      $sessiondata = $this->session->userdata('resetpasswordsession');

	      $update_user_table = $this->user_model->update_user_table($sessiondata['userid'],$data);

			if ($update_user_table)
	        { $this->user_model->deactivate_resetkey($sessiondata['resetid']);
	          $this->session->sess_destroy();
	          echo ('Password changed');
	      	}

	      else
	      {
	        echo 'something went wrong';
	      }
	    }
	 }
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->logged_in=FALSE;
		$this->session->set_flashdata("success_mess",'Successfully Logged Out');
		redirect('','refresh');
	}

	public function check_profileid($str)
	{
		if ($this->user_model->usercheck_profileid($str))
			return true;
		return false;
	}

	public function check_email_avail($str)
	{
		if ($this->user_model->usercheck_email($str))
			return true;
		return false;
	}

	public function check_email($str)
	{
		if ($this->user_model->usercheck_email($str))
			return false;
		return true;
	}
}