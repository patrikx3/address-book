<?php
namespace Model;

use Lib\Abstract_model;
use Lib\Validator;

class Contact extends Abstract_model {
	
	private static $table = 'contact';
	
	private static $grid_fields = array ('id', 'name', 'email', 'phone', 'created_on', 'updated_on' );
	
	protected static $relationships = array (
		'category' => array (
			'table' => 'contact_to_category', 
			'id_field' => 'contact_id', 
			'relation_field' => 'category_id',
			'always_load' => true,
			'always_save' => true
		)
	);
	
	public static function get_table() {
		return self::$table;
	}
	
	public static function get_grid_fields() {
		return static::$grid_fields;
	}
	
	public static function is_invalid(Array $data) {
		$errors = array ();
		if (! Validator::is_date ( $data ['created_on'] )) {
			$errors ['created_on'] = true;
		}
		
		if (strlen ( trim ( $data ['name'] ) ) < 1 || strlen ( trim ( $data ['name'] ) ) > 128) {
			$errors ['name'] = true;
		}
		
		if (! Validator::is_email ( $data ['email'] ) || strlen ( trim ( $data ['email'] ) ) < 1) {
			$errors ['email'] = true;
		}
		
		if (trim ( strlen ( $data ['phone'] ) ) > 0 && ! Validator::is_international_phone ( $data ['phone'] )) {
			$errors ['phone'] = true;
		}
		
		if (Category::count() > 0 && !isset($data['category'])) {
			$errors['category'] = true;
		}
		return count ( $errors ) == 0 ? false : $errors;
	}


}
