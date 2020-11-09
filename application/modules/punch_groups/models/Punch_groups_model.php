<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Punch_groups_model extends CI_Model

{

    private static $db;



    function __construct()

    {

		parent::__construct();

		self::$db = &get_instance()->db;

	}



    static function all()

	{	

		self::$db->select('*');

		self::$db->from('punch_groups'); 	
		
		self::$db->where('subdomain_id',$_SESSION['subdomain_id']); 
		 

		self::$db->order_by('id','ASC');

		return self::$db->get()->result();

    }

    

    static function find($id)

	{

		return self::$db->where('id',$id)->get('punch_groups')->row();

	}

	

	static function punch_group_name_exists($group_name,$id='')

	{		 

		if($id!='')

		{

			return self::$db->where('punch_group_name',$group_name)->where('id != ',$id)->get('punch_groups')->row();            

		}

		else 

		{

			return self::$db->where('punch_group_name',$group_name)->get('punch_groups')->row();            

		}

		

	}



	static function delete($id)

	{

		self::$db->where('id',$id)->delete('punch_groups');

	}



}