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

class BlogModel extends CI_Model{
	/**
	 * Default constructor.
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Get the labels for Create Post Form
	 */
	public function GetCreatePostFormLabels(){
		$data['title'] = "Post Title";
		$data['content'] = "Post Content";
		$data['tag'] = "Tags";
		$data['category'] = "Post Categories";

		return $data;
	}

	/**
	 *	Get the list of available blogs.
	 *	Used in both admin panel dashboard.
	 */
	public function GetListOfBlogs($blogname = ""){
		$this->load->database();

		if ($blogname != ""){
			$this->db->where('URL','%' . $blogname . '%');
		}

		return $this->db->get('bm_blog')->result_array();
	}

	/**
	 *	Get the blog detail using blogID.
	 *	Used in admin panel.
	 *	@param blogID ID of wanted blog
	 *	@return detail of the blog
	 */
	public function GetBlogFromID($blogID){
		$this->load->database();

		$this->db->where('ID', $blogID);

		return $this->db->get('bm_blog')->result_array()[0];
	}

	/**
	 *	Get the blog detail using blogURL.
	 *	Used in user panel.
	 *	@param blogURL URL of the blog wanted
	 *	@return detail of the blog
	 */
	public function GetBlogFromURL($blogURL){
		$this->load->database();

		$this->db->where('URL', $blogURL);

		return $this->db->get('bm_blog')->result_array()[0];
	}

	/**
	 *
	 */
	public function CreateBlog($desc, $URL, $key){
		$this->load->database();

		$this->db->set('url', $URL);
		$this->db->set('key', $key);
		$this->db->set('desc', $desc);
		$this->db->trans_start();
		$this->db->insert('bm_blog');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 *	Edit the blog.
	 *	@param blogname new name of the blog.
	 *	@param blogURL new URL of the blog.
	 *	@return TRUE if success
	 *	@throws Exceptions telling why the blog is failed to be added.
	 */
	public function EditBlog($blogID, $blogname = "", $blogURL = "", $key = ""){
		$this->load->database();

		$data = array(
			'URL' => $blogURL,
			'desc' => $blogname,
			'key' => $key
			);
		$this->db->where('ID', $blogID);
		$this->db->trans_start();
		$this->db->update('bm_blog', $data);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 *	Delete the blog
	 *	@param blogID ID of the blog
	 *	@return TRUE if success
	 *	@throws Exceptions telling why the blog is failed to be deleted
	 */
	public function DeleteBlog($blogID){
		$this->load->database();

		$this->db->trans_start();
		$this->db->where('ID', $blogID);
		$this->db->delete('bm_blog');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 *	Deactivate the blog
	 *	@param blogID ID of the blog
	 *	@return TRUE if success
	 *	@throws Exceptions telling why the blog is failed to be deactivated
	 */
	public function DeactivateBlog($blogID){
		$this->load->database();

		$this->db->trans_start();
		$this->db->set('status',0);
		$this->db->where('ID', $blogID);
		$this->db->update('bm_blog');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 *	Activate the blog
	 *	@param blogID ID of the blog
	 *	@return TRUE if success
	 *	@throws Exceptions telling why the blog is failed to be activated
	 */
	public function ActivateBlog($blogID){
		$this->load->database();

		$this->db->trans_start();
		$this->db->set('status',1);
		$this->db->where('ID', $blogID);
		$this->db->update('bm_blog');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 *
	 */
	public function GetBlogCategories($blogID){
		$this->load->database();

		$this->db->where('ID', $blogID);
		$blogURL = $this->db->get('bm_blog')->result_array()[0]['URL'];
		// create json call to blog
		//$categories = array("satu","dua","tiga");
		$url = $blogURL . '/wp-admin/admin-ajax.php';
		$vars = 'action=my_action&mom=get_categories';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$result = json_decode(curl_exec($ch), TRUE);
		foreach ($result as $key => $value){
				$categories[$key] = $value;
		}

		return $categories;
		//substr($result, $firstquote, strlen($result) - $length)) 
	}

	/**
	 *
	 */
	public function PostToblog($blogID, $postTitle, $postContent, $postCategories, $postTags){
		$this->load->database();

		$this->db->where('ID', $blogID);
		$blogURL = $this->db->get('bm_blog')->result_array()[0]['URL'];
		$url = $blogURL . '/wp-admin/admin-ajax.php';
		$vars = 'action=my_action&mom=post_me_up&'.
			'post_title=' . $postTitle . '&' .
			'post_name=' . str_replace(" ", "-", $postTitle) . '&' .
			'post_content=' . $postContent . '&' .
			'categories=' . $postCategories . '&' .
			'tags=' . $postTags;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = json_decode(curl_exec($ch), TRUE);

		return $result;
	}

	/**
	 *
	 */
	public function GetMediaFromBlog($blogID){
		$this->load->database();

		$this->db->where('ID', $blogID);
		$blogURL = $this->db->get('bm_blog')->result_array()[0]['URL'];
		$url = $blogURL . '/wp-admin/admin-ajax.php';
		$vars = 'action=my_action&mom=get_images';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		return $result;
	}

	public function UploadImage($blogID, $imageURL, $image_name){
		$this->load->database();

		$this->db->where('ID', $blogID);
		$blogURL = $this->db->get('bm_blog')->result_array()[0]['URL'];
		$url = $blogURL . '/wp-admin/admin-ajax.php';
		$vars = 'action=my_action&mom=post_image&uri=' . $imageURL .
			'&desc=' . $image_name;

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		$src = (string) reset(simplexml_import_dom(DOMDocument::loadHTML($result))->xpath("//img/@src"));

		return $src;
	}
}

?>