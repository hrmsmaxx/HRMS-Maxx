<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Price_per_employees extends CI_Model
{

	private static $db;

	function __construct(){
		parent::__construct();
		self::$db = &get_instance()->db;
	}

	static function list_items()
	{
	    $user_id = User::get_id();
		return self::$db->order_by('employee_count','asc')->get('price_per_employee')->result();
	}

	static function view_item($id)
	{
		return self::$db->where('id',$id)->get('price_per_employee')->row();
	}
	
	

}

/* End of file model.php */