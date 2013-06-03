<?php
/**
 *	Blog Manager
 *	A blog managing PHP Application used to manage your blogs easily.
 * This App will require an extra plug in into your blog so that it can be managed.
 *
 * This file contains the "MainController". It will manage the first view of the blog, and some main features.
 *
 * @author Aditya Situmeang, Omeoo Media
 * @email bananab9001@gmail.com 
 */

class MainController extends CI_Controller {
	const INVALID_LOGIN_MSG = 'Bang! Username and Password invalid, Dude!';

	/**
	 *	Default constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}	
	
	/**
	 *	Main page
	 */
	public function index(){
		$data['title'] = "Blog Manager | Home";
		
		$this->load->view('commons/header', $data);
		$this->load->view('mainview',$data);
		$this->load->view('commons/footer', $data);
	}

	public function validate_login(){
		$this->load->model('UserModel');
		return $this->UserModel->ValidateLogin($this->input->post('email'), $this->input->post('password'));
	}

	/**
	 *	Display and process login
	 */
	public function login(){
		if ($this->session->userdata('cemail') != FALSE){
			// if user has already logged in, redirects
			redirect('/maincontroller');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->model('UserModel');

		$data['title'] = "Blog Manager | Login";
		$data['fieldnames'] = $this->UserModel->GetLoginFormView();

		$this->form_validation->set_rules('email', 'email', 'required|valid_email|callback_validate_login');
		$this->form_validation->set_rules('password', 'password', 'required');

		$this->form_validation->set_message('validate_login', self::INVALID_LOGIN_MSG);

		if ($this->form_validation->run() === FALSE){
			$this->load->view('commons/header', $data);
			$this->load->view('login', $data);
			$this->load->view('commons/footer', $data);
		}else{
			redirect('/maincontroller','location');
		}
	}

	/**
	 *	Display and process register
	 */
	public function register(){
		if ($this->session->userdata('cemail') != FALSE){
			// if user has already logged in, redirects
			redirect('/maincontroller');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('UserModel');

		$data['title'] = "Blog Manager | Registration";
		$data['fieldnames'] = $this->UserModel->GetRegisterFormView();
		$data['extraError'] = '';

		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('confirm', 'confirm', 'required|matches[password]');
		$this->form_validation->set_rules('fname', 'fname', 'required');
		$this->form_validation->set_rules('lname', 'lname', 'required');

		if ($this->form_validation->run() === FALSE){
			$this->load->view('commons/header', $data);
			$this->load->view('register', $data);
			$this->load->view('commons/footer', $data);
		}else{
			// this part means the user will register right away.
			$registrationStatus = $this->UserModel->RegisterUser($this->input->post('email'), $this->input->post('password'), $this->input->post('fname'), $this->input->post('lname'), 2);
			if ($registrationStatus === 1){
				// success, means auto login and redirect
				$this->UserModel->DoLogin($this->input->post('email'));
				redirect('/maincontroller');
			}else if ($registrationStatus === 2){
				// mail exist
				$data['extraError'] = 'Sorry, but your email has already been used.';
			}else if ($registrationStatus === 3){
				// other error
				$data['extraError'] = 'There is an error in registration, please contact Admin';
			}
		}
	}

	/**
	 *	Log the user out.
	 */
	public function logout(){
		if ($this->session->userdata('cemail') != FALSE){
			$this->load->model('UserModel');

			$this->UserModel->DoLogout();
		}
		redirect('/maincontroller');
	}

	/**
	 *	Display and process blog choosing
	 */
	public function chooseblog($args){
		$chooseBlogArgs = array('addpost',
			'addphoto');
		if ($this->session->userdata('cemail') === FALSE){
			redirect('/maincontroller');
		}
		$valid_args = FALSE;
		foreach ($chooseBlogArgs as $singleArgs){
			if ($args === $singleArgs)
				$valid_args = TRUE;
		}

		if ($valid_args){
			$this->load->model('BlogModel');

			$data['title'] = "Blog Manager | Choose Your Blog";
			$data['blogList'] = $this->BlogModel->GetListOfBlogs();
			$data['arg'] = $args;
			// $data['args'] = $chooseBlogArgs;

			$this->load->view('commons/header', $data);
			$this->load->view('blogging/chooseblog', $data);
			$this->load->view('commons/footer');
		}else{
			redirect('/maincontroller');
		}
	}

	/**
	 *	Add a post to the corresponding blog.
	 */
	public function addpost($blogID){
		if ($this->session->userdata('cemail') === FALSE){
			redirect('/maincontroller');
		}
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('BlogModel');
		$this->load->model('UserModel');

		$this->form_validation->set_rules('title', 'title', 'required');
		$this->form_validation->set_rules('content', 'content', 'required');
		$this->form_validation->set_rules('tag', 'tag', 'required');
		$this->form_validation->set_rules('category', 'category', 'required');

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // post. show the form
			if ($this->form_validation->run() === FALSE){
				$data['title'] = "Blog Manager | Write your post!";
				// $data['mediaList'] = json_decode($this->BlogModel->GetMediaFromBlog($blogID), TRUE);
				$data['blogData'] = $this->BlogModel->GetBlogFromID($blogID);
				$data['fieldnames'] = $this->BlogModel->GetCreatePostFormLabels();
				$data['categories'] = $this->BlogModel->GetBlogCategories($blogID);
				
				self::ShowAddPostForm($data);
			}else{
				$blogID = $this->input->post('ID');
				$postTitle = $this->input->post('title');
				$postContent = $this->input->post('content');
				$categories = $this->input->post('category');
				$postCategories = "";
				foreach($categories as $cat){
					$postCategories .= '|' . $cat;
				}
				$postCategories = substr($postCategories, 1);
				$postTags = $this->input->post('tag');

				if ($this->BlogModel->PostToblog($blogID, $postTitle, $postContent, $postCategories, $postTags) != 0){
					$this->UserModel->AddPoint($this->session->userdata('cemail'));
					redirect('/maincontroller');
				}else{
					$data['title'] = "Blog Manager | Write your post!";
					// $data['mediaList'] = json_decode($this->BlogModel->GetMediaFromBlog($blogID), TRUE);
					$data['blogData'] = $this->BlogModel->GetBlogFromID($blogID);
					$data['fieldnames'] = $this->BlogModel->GetCreatePostFormLabels();
					$data['categories'] = $this->BlogModel->GetBlogCategories($blogID);
					$data['extraerror'] = "Posting fail, something is wrong with server";

					self::ShowAddPostForm($data);
				}
			}
		}else{
			$data['title'] = "Blog Manager | Write your post!";
			// $data['mediaList'] = json_decode($this->BlogModel->GetMediaFromBlog($blogID), TRUE);
			$data['blogData'] = $this->BlogModel->GetBlogFromID($blogID);
			$data['fieldnames'] = $this->BlogModel->GetCreatePostFormLabels();
			$data['categories'] = $this->BlogModel->GetBlogCategories($blogID);
			
			self::ShowAddPostForm($data);
		}
	}

	public function browse($blogID){
		// $this->load->helper('form');
		// if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // post. show the form
		// 	$url = $this->input->post('uri');
		// 	// $funcNum = $this->input->get('CKEditorFuncNum'); //$_GET['CKEditorFuncNum']

		// 	echo "<script type='text/javascript'>window.opener.CKEDITOR.tools.callFunction($funcNum, '$url');</script>";
		// }else{
			$this->load->model('BlogModel');

			$data['title'] = "Blog Manager | Browse your images!";
			$data['mediaList'] = json_decode($this->BlogModel->GetMediaFromBlog($blogID), TRUE);
			$data['ID'] = $blogID;

			$this->load->view('commons/header', $data);
			$this->load->view('blogging/browse', $data);
			$this->load->view('commons/footer');
		// }
	}

	private function ShowAddPostForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('blogging/addpost', $data);
		$this->load->view('commons/footer');
	}

	private function ShowAddPhotoForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('blogging/addphoto', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function addphoto($blogID){
		$this->load->model('BlogModel'); // the model that communicate with blog

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['overwrite'] = FALSE;
		$this->load->library('upload');


		$funcNum = $this->input->get('CKEditorFuncNum'); //$_GET['CKEditorFuncNum']
		$this->upload->initialize($config);
			
		if (!$this->upload->do_upload('upload')){ // upload the file, 'upload' is the name of the field from CKEditor
			 // failed upload
			$message = "Upload failed on blog manager server.";
			$url = '';
		
		}else{ // success copy to wp server
			$upload_result = base_url() . 'uploads/'. $this->upload->data()['file_name'];
			$upload_name = $this->upload->data()['file_name'];

			// after finished uploading, it will receive a URL
			$url = $this->BlogModel->UploadImage($blogID, $upload_result, $upload_name); 

			$message = 'Upload success!';
		}
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
	}
}


/** EOF **/ ?>