<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload extends CI_Controller {

	private $logged_in = FALSE;
	private $userid;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
	   	$this->load->model('user_model');
		$this->load->library('session');
	 	$this->load->config('oims_config');
	 	$this->globalcategory();
	 	$this->load->library('image_lib');
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
		if (!is_dir('upload'))
			mkdir('upload/',0777,true);

		$data['title'] = "Upload Images";
		$this->load->view('header/header.inc',$data);
		$this->load->view('upload',$data);
	}

	public function do_upload()
	{

		if (!$this->input->post('submit'))
		{	

			$this->session->set_flashdata('failure_mess','No Access.');
			redirect('upload','refresh');
			return;
		}
		$this->load->model('upload_model');

		$upload_path = date ('Y/m/d');
		$path = 'upload/'.$upload_path;
		if (!is_dir($path))
			mkdir($path,0777,true);

		$config['upload_path'] = $path;
		$config['allowed_types'] = 'jpg|png|bmp|jpeg';
		$config['max_size']	= 1024 * 5;
		$config['remove_spaces'] =true;
		$config['encrypt_name'] = false;
		$config['overwrite']=false;
		$config['max_filename']=20;

		$this->load->library('upload',$config);

		
		if ( ! $this->upload->do_upload('file'))
		{
			$this->session->set_flashdata('failure_mess',$this->upload->display_errors());
			unset($data);
			redirect('upload','refresh');
			return;
		}

		else
		{
			$data = $this->upload->data();
			
			if (!$this->input->post('title'))
				$imagedata['title'] = str_replace($data['file_ext'], "", $data['client_name']);

			else
				$imagedata['title'] = $this->input->post('title');
			
			if ($this->input->post('categoryid'))
			{
				$category = $this->input->post('categoryid');
				$imagedata['categoryid']=$category;
			}
			$imagedata['height'] = $data['image_height'];
			$imagedata['width']= $data['image_width'];
			$imagedata['size']=$data['file_size'];
			$imagedata['src']=$path.'/'.$data['file_name'];
			
			if ($this->userid)
				$imagedata['userid']=$this->userid;

			// $imagedata['date_uploaded'] = date('Y-m-d');
			$imageid = $this->upload_model->upload_image($imagedata);


			if ($imageid)
			{
				unset($config);

				$this->create_thumbnail($imagedata['src']);

				if (!$this->input->post('imagesize')=='0')
				{
					if ($this->input->post('imagesize')=='9')
					{
						$image_width = $this->input->post('width');
						$image_height = $this->input->post('height');
					}

					else
					{
						$dimension = explode('*', $this->input->post('imagesize'));
						$image_width = $dimension[0];
						$image_height = $dimension[1];
					}

					$config['image_library'] = 'gd2';
					$config['source_image']	= $imagedata['src'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['width']	= $image_width;
					$config['height']	= $image_height;

					$this->image_lib->initialize($config);

					if ( ! $this->image_lib->resize())
					{
					    $this->session->set_flashdata('failure_mess',$this->image_lib->display_errors());
					   	redirect('upload','refresh');
						return;
					}

					else
					{
						$newimgdata ['width'] = $image_width;
						$newimgdata ['height'] = $image_height;
						$newimgdata ['size'] = filesize($imagedata['src'])/1024;
						$this->upload_model->update_image ($imageid,$newimgdata);
					}
				}

				unset($data);
				$data['title'] = 'Upload Successfull';
				$data['success_mess'] = "Congratulations! Image Successfully Uploaded";
				$data['imagedetails'] = $this->upload_model->getimagedetails($imageid);
				
				if ($this->userid)
				{
					$this->load->model('album_model');
					$data['useralbums'] = $this->album_model->getuseralbums($this->userid);
				}
				$data['imagedetails']['thumb_img']=$this->get_thumbimage($data['imagedetails']['src']);
				$this->load->view('header/header.inc',$data);
				$this->load->view('upload_success',$data);
				return;
			}
		}
			
	}

	public function get_thumbimage($imgsrc)
	{
		$offset = strpos($imgsrc, '.');
		return substr_replace($imgsrc, '_thumb', $offset,0);
	}

	private function create_thumbnail($imgsrc)
	{
		$config['image_library'] = 'gd2';
		$config['source_image']	= $imgsrc;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= 240;
		$config['height']	= 160;
		$this->image_lib->initialize($config);
		$this->image_lib->resize();

	}

}