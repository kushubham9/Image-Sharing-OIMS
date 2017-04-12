<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settings extends CI_Controller {
	private $logged_in = FALSE;
	private $userid;
	
	function __construct()
	{ 
	   parent::__construct();
	   $this->load->helper('url');
	   $this->load->model('user_model');
	   $this->load->model('settings_model');
	   $this->load->library('session');
	   $this->load->config('oims_config');
	   $this->globalcategory();

	   if ($this->check_logged_in())
	   	$this->logged_in = TRUE;

	   else
	   {
	   	$this->session->set_flashdata('failure_mess','No Access to this page, Login First.');
	   	redirect('user/login','refresh');
	   	return;
	   }
	   
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

	public function index()
	{
		$this->load->helper(array('form'));

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		$this->form_validation->set_message('check_profileid', 'Sorry, This Profile Id is already taken.');
		$this->form_validation->set_message('check_email_avail','Sorry, This Email id is already taken.');
	
		$this->form_validation->set_rules('profileid', 'User Name', 'required|trim|callback_check_profileid');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_check_email_avail');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Settings";
			$data['userdetails'] = $this->user_model->get_user($this->userid);
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}

		else
		{
			
			$userdata['profileid'] = $this->input->post('profileid');
			$userdata['email'] = $this->input->post('email');
			
			if ($this->user_model->update_user_table($this->userid, $userdata))
				$data['success_mess']="Successfully Updated";
			$data['userdetails'] = $this->user_model->get_user($this->userid);

			$data['success_mess']='Update Successfull.';
			$data['title'] = "Settings";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}

		
	}

	public function profile()
	{
		$this->load->helper(array('form'));

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Settings";
			$data['userdetails'] = $this->user_model->get_user($this->userid);
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}

		else
		{
			$userdata['first_name'] = $this->input->post('firstname');
			$userdata['last_name'] = $this->input->post('lastname');
			if ($this->user_model->update_user_table($this->userid, $userdata))
				$data['success_mess']="Successfully Updated";
			$data['userdetails'] = $this->user_model->get_user($this->userid);

			$data['title'] = "Settings";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}
	}

	public function password()
	{
		$this->load->helper(array('form'));

		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="has-error">', '</div>');
		
		$this->form_validation->set_message('check_currentpass', 'Sorry, You have specified an invalid password.');
		
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|min_length[6]|md5|callback_check_currentpass');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[password_conf]|min_length[6]|md5');
		$this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = "Settings";
			$data['userdetails'] = $this->user_model->get_user($this->userid);
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}

		else
		{
			$userdata['password'] = $this->input->post('password');
			if ($this->user_model->update_user_table($this->userid, $userdata))
				$data['success_mess']="Successfully Updated";
			
			$data['userdetails'] = $this->user_model->get_user($this->userid);

			$data['title'] = "Settings";
			$this->load->view('header/header.inc',$data);
			$this->load->view('user/settings',$data);
		}
	}

	public function check_profileid($str)
	{
		return $this->settings_model->check_profileid_avail($this->userid,$str);
	}

	public function check_email_avail($str)
	{
		return $this->settings_model->check_email_avail($this->userid,$str);
	}

	public function check_currentpass($str)
	{
		// return false;
		return $this->settings_model->login_credential_check($this->userid,$str);
	}
}