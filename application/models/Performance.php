<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Performance extends CI_Model
{

	private static $db;


	function __construct(){
		parent::__construct();
		self::$db = &get_instance()->db;
	}

	/**
	* Insert records to companies table and return INSERT ID
	*/
	static function save($data = array()) {
		self::$db->insert('smart_goal_configuration',$data);
		return self::$db -> insert_id();
	}

	static function get_performance_competency()
	{
		return self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->get('performance_competency')->result_array();
	}

	static function save_performance_competency($data = array()) {
		self::$db->insert('performance_competency',$data);
		return self::$db -> insert_id();
	}

	static function delete_performance_competencies($id)
	{
		self::$db->where('id',$id)->delete('performance_competency');
	}
	static function okr_ratings_save($data = array()) {
		self::$db->insert('okr_ratings',$data);
		return self::$db -> insert_id();
	}
	static function competency_ratings_save($data = array()) {
		self::$db->insert('competency_ratings',$data);
		return self::$db -> insert_id();
	}
	/**
	* Update client information
	*/
	static function update($id, $data = array()) {
		
		self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->where('rating_scale',$id)->update('smart_goal_configuration',$data);

		return self::$db->affected_rows();

	}

	//Inser record to offer approvers table and return insert ID
	static function save_offer_approvers($data = array()) {
		self::$db->insert('offer_approvers',$data);
		return self::$db -> insert_id();
	}

	static function okr_description_save($data = array()) {
		self::$db->insert('okr_description',$data);
		return self::$db -> insert_id();
	}
	

	static function okr_description()
	{
		// return self::$db->order_by('id','DESC')->limit(1)->get('okr_description')->row_array();
		return self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->get('okr_description')->row_array();
	}
	static function kpi_desc()
	{
		// return self::$db->order_by('id','DESC')->limit(1)->get('okr_description')->row_array();
		return self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->get('dgt_kpi')->row_array();
	}
	static function performance_competencies()
	{
		// return self::$db->order_by('id','DESC')->limit(1)->get('okr_description')->row_array();
		return self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->get('dgt_performance_competencies')->row_array();
	}
	static function delete_okr_description(){

        return self::$db->where('subdomain_id',$_SESSION['subdomain_id'])->delete('okr_description');
    }
	// Get all clients
	static function get_all_clients()
	{
		return self::$db->where(array('is_lead' => 0,'co_id >'=> 0,'subdomain_id',$_SESSION['subdomain_id']))->order_by('company_name','ASC')->get('companies')->result();
	}
	// Get all departments
	static function get_all_departments()
	{
		return self::$db->order_by('depthidden','ASC')->where('subdomain_id',$_SESSION['subdomain_id'])->get('departments')->result();
	}

}
/* End of file model.php */
