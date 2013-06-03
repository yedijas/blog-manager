<?php
/**
 *	Blog Manager
 *	A blog managing PHP Application used to manage your blogs easily.
 * This App will require an extra plug in into your blog so that it can be managed.
 *
 * This file contains the "Admin". It will manage the admi view of the blog, and some admin features.
 *
 * @author Aditya Situmeang, Omeoo Media
 * @email bananab9001@gmail.com 
 */

class Admin extends CI_Controller{
	/**
	 *	Default constructor
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');

		if ($this->session->userdata('crole') != 1){
			// if user has already logged in, redirects
			redirect('/maincontroller/login');
		}
	}

	/**
	 *	Admin dashboard.
	 */
	public function index(){
		$data['title'] = "Blog Manager | Admin Panel";

		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/dashboard', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	private function ShowEditBlogForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/editblog', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	private function ShowAddBlogForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/addblog', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *	Index the blogs in list.
	 */
	public function indexblog($blogname = ''){
		$this->load->model('BlogModel');

		$data['title'] = "Blog Manager | Admin Panel - Blog Index";
		$data['blogdata'] = $this->BlogModel->GetListOfBlogs($blogname);

		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/indexblog', $data);
		$this->load->view('commons/footer');
	}

	public function detailblog($blogID){
		$this->load->model('BlogModel');

		$data['title'] = "Blog Manager | Admin Panel - Blog Index";
		$data['blogdata'] = $this->BlogModel->GetBlogFromID($blogID);

		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/detailblog', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function addblog(){
		$this->load->model('BlogModel');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('desc', 'desc', 'required');
		$this->form_validation->set_rules('key', 'key', 'required');
		$this->form_validation->set_rules('URL', 'URL', 'required');

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){
			if ($this->form_validation->run() === FALSE){
				$data['title'] = "Blog Manager | Admin Panel - Add Blog";

				self::ShowAddBlogForm($data);
			}else{
				$desc = $this->input->post('desc');
				$URL = $this->input->post('URL');
				$key = $this->input->post('key');
				if ($this->BlogModel->CreateBlog($desc, $URL, $key) === TRUE){
					redirect('/admin/indexblog');
				}else{
					$data['title'] = "Blog Manager | Admin Panel - Add Blog";

					self::ShowAddBlogForm($data);
				}
			}
		}else{
			$data['title'] = "Blog Manager | Admin Panel - Add Blog";

			self::ShowAddBlogForm($data);
		}
	}

	/**
	 *
	 */
	public function editblog($blogID){
		$this->load->model('BlogModel');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('desc', 'desc', 'required');
		$this->form_validation->set_rules('key', 'key', 'required');
		$this->form_validation->set_rules('URL', 'URL', 'required');

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // post. show the form
			if ($this->form_validation->run() === FALSE){
				$data['blog'] = $this->BlogModel->GetBlogFromID($blogID);
				$data['title'] = "Blog Manager | Admin Panel - Edit Blog";

				self::ShowEditBlogForm($data);
			}else{
				$ID = $this->input->post('ID');
				$key = $this->input->post('key');
				$URL = $this->input->post('URL');
				$desc = $this->input->post('desc');
				if ($this->BlogModel->EditBlog($ID, $desc, $URL, $key) === TRUE){
					redirect('/admin/detailblog/' . $ID);
				}else{
					$data['blog'] = $this->BlogModel->GetBlogFromID($blogID);
					$data['title'] = "Blog Manager | Admin Panel - Edit Blog";

					self::ShowEditBlogForm($data);
				}
			}
		}else{ // not a post, then showing the form
			$data['blog'] = $this->BlogModel->GetBlogFromID($blogID);
			$data['title'] = "Blog Manager | Admin Panel - Edit Blog";

			self::ShowEditBlogForm($data);
		}
	}

	/**
	 *
	 */
	public function deactivateblog($blogID){
		$this->load->model('BlogModel');

		if ($this->BlogModel->DeactivateBlog($blogID) === TRUE){
			redirect('/admin/indexblog');
		}
	}

	/**
	 *
	 */
	public function activateblog($blogID){
		$this->load->model('BlogModel');

		if ($this->BlogModel->ActivateBlog($blogID) === TRUE){
			redirect('/admin/indexblog');
		}
	}

	/**
	 *
	 */
	public function deleteblog($blogID){
		$this->load->model('BlogModel');

		if ($this->BlogModel->DeleteBlog($blogID) === TRUE){
			redirect('/admin/indexblog');
		}
	}

	/**
	 *
	 */
	public function indexuser(){
		$this->load->model('UserModel');

		$data['userdata'] = $this->UserModel->GetUsers();
		$data['title'] = "Blog Manager | Admin Panel - User Index";

		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/indexuser', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function detailuser($userID){
		$this->load->model('UserModel');
		$this->load->model('RoleModel');

		$data['userdata'] = $this->UserModel->GetUserFromID($userID);
		$data['title'] = "Blog Manager | Admin Panel - User Detail";

		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/detailuser', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function adduser(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model(array('UserModel', 'RoleModel'));

		$this->form_validation->set_rules('fname', 'fname', 'required');
		$this->form_validation->set_rules('lname', 'lname', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('confirm', 'confirm', 'required|matches[password]');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // post. show the form
			if ($this->form_validation->run() === FALSE){
				$data['title'] = "Blog Manager | Admin Panel - Add User";
				$data['roles'] = $this->RoleModel->GetRole();

				self::ShowAddUserForm($data);
			}else{
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$role = $this->input->post('role');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				if ($this->UserModel->RegisterUser($email, $password, $fname, $lname, $role) === TRUE){
					redirect('/admin/indexuser');
				}else{
					$data['title'] = "Blog Manager | Admin Panel - Add User";
					$data['roles'] = $this->RoleModel->GetRole();

					self::ShowAddUserForm($data);
				}
			}
		}else{ // not a post, then showing the form
			$data['title'] = "Blog Manager | Admin Panel - Add User";
			$data['roles'] = $this->RoleModel->GetRole();

			self::ShowAddUserForm($data);
		}
	}

	private function ShowAddUserForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/adduser', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function edituser($userID){
		$this->load->model(array('UserModel', 'RoleModel'));
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('fname', 'fname', 'required');
		$this->form_validation->set_rules('lname', 'lname', 'required');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');

		if ($_SERVER['REQUEST_METHOD'] === 'POST'){ // post. show the form
			if ($this->form_validation->run() === FALSE){
				$data['userdata'] = $this->UserModel->GetUserFromID($userID);
				$data['roles'] = $this->RoleModel->GetRole();
				$data['title'] = "Blog Manager | Admin Panel - Edit User";

				self::ShowEditUserForm($data);
			}else{
				$ID = $this->input->post('ID');
				$email = $this->input->post('email');
				$lname = $this->input->post('lname');
				$fname = $this->input->post('fname');
				$role = $this->input->post('role');
				if ($this->UserModel->EditUser($ID, $email, $fname, $lname, $role) === TRUE){
					redirect('/admin/indexuser');
				}else{
					$data['userdata'] = $this->UserModel->GetUserFromID($userID);
					$data['roles'] = $this->RoleModel->GetRole();
					$data['title'] = "Blog Manager | Admin Panel - Edit User";

					self::ShowEditUserForm($data);
				}
			}
		}else{
			$data['userdata'] = $this->UserModel->GetUserFromID($userID);
			$data['roles'] = $this->RoleModel->GetRole();
			$data['title'] = "Blog Manager | Admin Panel - Edit User";

			self::ShowEditUserForm($data);
		}
	}

	private function ShowEditUserForm($data){
		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/edituser', $data);
		$this->load->view('commons/footer');
	}

	/**
	 *
	 */
	public function deleteuser($userID){
		$this->load->view('commons/header', $data);
		$this->load->view('admin/sidemenu');
		$this->load->view('admin/indexuser', $data);
		$this->load->view('commons/footer');
	}
}

/** EOF **/ ?>