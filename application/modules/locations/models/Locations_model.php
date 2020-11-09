<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Locations_model extends CI_Model

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

		self::$db->from('locations'); 	
		
		self::$db->where('subdomain_id',$_SESSION['subdomain_id']); 
		 

		self::$db->order_by('id','ASC');

		return self::$db->get()->result();

    }

    

    static function find($id)

	{

		return self::$db->where('id',$id)->get('locations')->row();

	}

	

	static function location_name_exists($location_name,$id='')

	{		 

		if($id!='')

		{

			return self::$db->where('location_name',$location_name)->where('id != ',$id)->get('locations')->row();            

		}

		else 

		{

			return self::$db->where('location_name',$location_name)->get('locations')->row();            

		}

		

	}



	static function delete($id)

	{

		self::$db->where('id',$id)->delete('locations');

	}



}