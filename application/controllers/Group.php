<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

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

    public function index(){
        $data = array();
        $data['page'] = 'Group List';
        $this->load->view('group_list', $data);
    }



public function getallgrouplist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") ."/api/group";

//$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $groupresponse = curl_exec($ch);
  //$result = json_decode($response);
 $groupresponse;
//var_dump($contraresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($groupresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditcontra'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"groupname"=>$d['group_name']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}

public function deleteTransactionbyid()
{
$id= $this->input->get('id');
$trans_type=$this->input->get('trans_type');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$url=$this->config->item("api_url") . "/api/transaction/" . $id ;
$data_array=array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);
 curl_close($ch); // Close the connection
 echo $delresponse;
}





public function getGroupbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
$url=$this->config->item("api_url") . "/api/group/" . $id;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $receiptbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;
//var_dump($receiptbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($receiptbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);

$tbl .='<table id="editcontra" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Group Name<input type="text" class="form-control" autocomplete="off"  id="contrano" name="contrano" value="'.$value["group_name"].'"></td></tr>
</table>';


}



echo $tbl;
}



public function createGroup()
{
$groupname = $this->input->post('groupname');


$data_post=array("group_name"=>$groupname);

$url=$this->config->item("api_url") . "/api/group";

//$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$contratArray = json_decode($response, true);

echo $response;


}



function editGroup()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$receiptno = $this->input->post('groupname');



$data_post=array(
//"id" => $id,
"groupname"=>$groupname);




$url=$this->config->item("api_url") . "/api/group/" . $id;

//$url=$this->config->item("api_url") . "/api/accounts";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");      
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}






}


