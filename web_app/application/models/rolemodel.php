<?php
/**
 *	Blog Manager
 *	A blog managing PHP Application used to manage your blogs easily.
 * This App will require an extra plug in into your blog so that it can be managed.
 *
 * This file contains the "BlogModel".
 *
 * @author Aditya Situmeang, Omeoo Media
 * @email bananab9001@gmail.com 
 */

class RoleModel extends CI_Model{
	/**
	 *	
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 *	
	 */
	public function RoleToText($roleID){
		$this->load->database();

		$this->db->where('ID', $roleID);
		return $this->db->get('bm_role')->result_array()[0]['name'];
	}

	public function GetRole(){
		$this->load->database();

		$roles = array();

		foreach ($this->db->get('bm_role')->result_array() as $row){
			$roles[$row['ID']] = $row['name'];
		}

		return $roles;
	}
}

?>