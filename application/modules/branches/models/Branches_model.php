<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Branches_model extends CI_Model

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

		self::$db->from('branches'); 	
		
		self::$db->where('subdomain_id',$_SESSION['subdomain_id']); 
		 

		self::$db->order_by('id_code','ASC');

		return self::$db->get()->result();

    }

    

    static function find($branch_id)

	{

		return self::$db->where('id',$branch_id)->get('branches')->row();

	}

	

	static function branch_name_exists($branch_name,$id='')

	{		 

		if($id!='')

		{

			return self::$db->where('branch_name',$branch_name)->where('id != ',$id)->get('branches')->row();            

		}

		else 

		{

			return self::$db->where('branch_name',$branch_name)->get('branches')->row();            

		}

		

	}



	static function delete($id)

	{

		self::$db->where('id',$id)->delete('branches');

	}



}