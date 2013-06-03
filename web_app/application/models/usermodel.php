<?php
/**
 *	Blog Manager
 *	A blog managing PHP Application used to manage your blogs easily.
 * 	This App will require an extra plug in into your blog so that it can be managed.
 *
 * 	This file contains the "UserModel".
 *
 * 	@author Aditya Situmeang, Omeoo Media
 * 	@email bananab9001@gmail.com 
 */

class UserModel extends CI_Model{
	var $email = '';
	// var $password = '';

	/**
	 *	Default constructor.
	 */
	public function __construct (){
		parent::__construct();
		$email = "";
	}

	/**
	 *	Get fields texts for login page
	 */
	public function GetLoginFormView(){
		$data['email'] = "Email";
		$data['password'] = "Password";
		
		return $data;
	}

	/**
	 *	Get fields text for register page
	 */
	public function GetRegisterFormView(){
		$data['email'] = "Email";
		$data['password'] = "Password";
		$data['confirm'] = "Password Confirmation";
		$data['fname'] = "First Name";
		$data['lname'] = "Last Name";

		return $data;
	}

	/**
	 *
	 */
	public function GetUsers($email = ""){
		$this->load->database();

		if (!empty($email)){
			$this->db->where('email',$email);
		}
		return $this->db->get('bm_user')->result_array();
	}

	/**
	 *
	 */
	public function GetUserFromID($userID){
		$this->load->database();

		$this->db->where('ID', $userID);
		return $this->db->get('bm_user')->result_array()[0];
	}

	/**
	 *	Check is email exist or not.
	 */
	private function IsEmailExist($email){
		$this->load->database();

		$this->db->where('email',$email);
		$query = $this->db->get('bm_user');

		if ($query->num_rows > 0)
			return TRUE;
		else
			return FALSE;
	}

	public function GetUserRole($email){
		$this->load->database();
		
		$this->db->select('role')->where('email', $email);

		return $this->db->get('bm_user')->result()[0]->role;
	}

	/**
	 *	Simple registering user into session.
	 */
	public function DoLogin($email){
		$this->load->library('session');

		$this->session->set_userdata('cemail', $email);
		$this->session->set_userdata('crole', self::GetUserRole($email));
	}

	public function DoLogOut(){
		$this->session->unset_userdata('cemail');
		$this->session->unset_userdata('crole');
	}

	/**
	 *	Register user into database.
	 *	@return TRUE if registration success
	 *	@param email as user email address
	 *	@param password as user password
	 *	@param fname as user first name
	 *	@param lname as user last name
	 */
//	public function RegisterUser($email, $password, $fname, $lname){
//		return RegisterUser($email, $password, $fname, $lname, 2);
//	}

	/**
	 *	Register user into database.
	 *	@return TRUE if registration success
	 *	@param email as user email address
	 *	@param password as user password
	 *	@param fname as user first name
	 *	@param lname as user last name
	 *	@param role as user role
	 */
	public function RegisterUser($email, $password, $fname, $lname, $role){
		$this->load->database();
		$this->load->library('encrypt');

		$dataToInsert = array(
			'email' => $email,
			'password' => $this->encrypt->encode($password),
			'fname' => $fname,
			'lname' => $lname,
			'role' => $role
		);

		if (self::IsEmailExist($email) === TRUE){
			// email exist
			return 2;
		}else{
			// email not exist
			$this->db->trans_start();

			$this->db->insert('bm_user', $dataToInsert);

			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return 3;
			}else{
				$this->db->trans_commit();
				return 1;
			}
		}
	}

	/**
	 *	Validate the user.
	 *	@return TRUE if email and password match
	 */
	public function ValidateLogin($email, $password){
		$this->load->database();
		$this->load->library('encrypt');
		// get from database
		if (self::IsEmailExist($email)){
			$this->db->select('password')->where('email', $email);
			if (strcmp($this->encrypt->decode($this->db->get('bm_user')->result()[0]->password), $password) == 0){
				self::DoLogin($email);
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function AddPoint($email){
		$this->load->database();

		$this->db->where('email', $email);
		$point = $this->db->get('bm_user')->result_array()[0]['point'];

		$this->db->where('email', $email);
		$this->db->set('point', $point + 10);
		$this->db->update('bm_user');
	}

	public function EditUser($ID, $email, $fname, $lname, $role = 2){
		$this->load->database();

		$this->db->set('email', $email);
		$this->db->set('fname', $fname);
		$this->db->set('lname', $lname);
		$this->db->set('role', $role);
		$this->db->where('ID', $ID);
		$this->db->trans_start();
		$this->db->update('bm_user');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}

?>