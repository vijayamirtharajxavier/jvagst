<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
$this->load->helper('form');


    //   $this->load->model('common_model');
    //   $this->load->model('login_model');


$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    


    }


public function newfinyear()
{
	$data=array();
	$data['page'] = 'New Financial Year';
	$this->load->view('newfinyear',$data);
}

public function getallSettingslistbycid()
{
	$data=array();
	$compId = $this->session->userdata('id');

	$url=$this->config->item("api_url") . "/api/settings/settingsbycid/" . $compId;
	$data_array= array("compId"=>$compId);
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL,$url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
	  $setresponse = curl_exec($ch);
	  curl_close($ch); // Close the connection
	var_dump($setresponse);
	$settArr = json_decode($setresponse);
	
}



}
