<?php
/**
Plugin Name: Blog Manager
PLugin URI: http://omeoo.com
Description: Plugin to let your blog being managed by Omeoo Media
Version: 0.1
Author: Aditya Situmeang (Omeoo Media)
Author URI: http://adityayedija.wordpress.com/
*/
if (!class_exists("BlogManager")){
	class BlogManager{
		function BlogManager(){}

		function ProcessRequest(){
			switch ($_REQUEST['mom']){
				case 'get_categories':
					$output = self::Getcategories();
					break;
				case 'post_me_up':
					$post_title = $_REQUEST['post_title'];
					$post_name = $_REQUEST['post_name'];
					$post_content = $_REQUEST['post_content'];
					$categories = $_REQUEST['categories'];
					$tags = $_REQUEST['tags'];
					$output = self::PostMeUp($post_title, $post_content, $post_name, $categories, $tags);
					break;
				case 'get_images':
					$output = self::GetImages();
					break;
				case 'post_image':
					$uri = $_REQUEST['uri'];
					$desc = $_REQUEST['desc'];
					$output = self::UploadImage($uri, $desc);
					break;
				default:
					$output = 'No function specified';
					break;
			}
			echo(json_encode($output));
			die();
		}

		/**
		 *	Get the categories from blog
		 *	@return array ID and category names
		 */
		function GetCategories(){
			global $wpdb;

			$categories = get_all_category_ids();
			$separator = '|';
			$output = array();
			if($categories){
				foreach($categories as $category) {
					$temp_catname = get_cat_name($category);
					if ($temp_catname !== "Uncategorized"){
						$output[$category] = $temp_catname;
					}
				}
			}else{
				$output = 'test';
			}
			return $output;
		}

		/**
		 *	Post something up.
		 *	@param string post_title as title for the post
		 *	@param string post_content as content for the post
		 *	@param string post_name as name (slug) for the post
		 *	@param array tags as tags for the post
		 *	@return int post ID
		 */
		function PostMeUp($post_title, $post_content, $post_name, $categories, $tags){
			$categoriesToPost = array();

			foreach (explode('|', $categories) as $value) {
				$categoriesToPost[] = $value;
			}

			$post = array(
				'post_title' => $post_title,
				'post_content' => $post_content,
				'post_status' => 'draft',
				'tags_input' => $tags,
				'post_type' => 'post',
				'post_author' => 1,
				'comment_status' => 'open',
				'post_category'  => $categoriesToPost,
				'post_name' => $post_name
				);
			// return "TROLLED!";
			return wp_insert_post($post, FALSE);
			// $createdPostID = wp_insert_post($post, true);
			// wp_set_post_categories($createdPostID, $categories);
			// if (!empty($wp_error))
			// 	return $wp_error;
			// return $createdPostID;
		}

		/**
		 *
		 */
		function GetImages(){
			$args = array(
				'post_type' => 'attachment'
			);

			$images = get_posts($args);
			$result = array();

			foreach($images as $singleImage){
				$result[$singleImage->post_title] = $singleImage->guid;
			}

			return $result;
		}

		/**
		 *
		 */
		function UploadImage($uri, $desc){
			return media_sideload_image($uri, 0, $desc);
		}
	}
}

if (class_exists("BlogManager")){
	$blogManager = new BlogManager();
}

if (isset($blogManager)){
	add_action('wp_ajax_nopriv_my_action', array($blogManager, 'ProcessRequest'));
	add_action('wp_ajax_my_action', array($blogManager, 'ProcessRequest'));
}
?>