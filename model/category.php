<?php
namespace Model;

use Lib\Abstract_model;
use Lib\Validator;

class Category extends Abstract_model {

	protected static $parents = array('contact');
	
	private static $table = 'category';
	
	private static $grid_fields = array(
		'id', 'title', 'updated_on'
	);
	
	public static function get_table() {
		return self::$table;
	}

	public static function get_grid_fields() {
		return static::$grid_fields;
	}
	
	public static function is_invalid(Array $data) {
		$errors = array();

		if (strlen($data['title']) < 1 || strlen($data['title']) > 128) {
			$errors['title'] = true;
		}
		
		return count($errors) == 0 ? false : $errors;
	}
	
}
