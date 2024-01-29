<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Productlist extends CI_Controller {

	public function __construct(){
        parent::__construct();
     //   check_login_user();
       // $this->load->library('curl');
$this->load->helper('form');
       $this->load->database();
      $this->load->model('data_model');

}

public function get_opbal()
{
  extract($_POST);
  $data_arr=get_defined_vars();
  $compid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  //var_dump($data_arr);
  $data=array([]);
  $opbalData=$this->data_model->getopbalData($compid,$finyear);
  //var_dump($opbalData);

  if($opbalData)
  {
    $ldg_name="";
//array("ldger_id"=>$ldg_id,"open_bal"=>$opbal_amt,"finyear"=>$finyear,"company_id"=>$compId);
    foreach ($opbalData as  $od) {

      $ldg_id = $od['ldger_id'];



      $ldgdata= $this->data_model->getLedgerbyidbycid($compid,$ldg_id);
      if($ldgdata)
      {
        foreach($ldgdata as $ldg)
        {
          $ldg_name=$ldg['account_name'];		
    
        }
      }
    
      $opbal = $od['open_bal'];

      $btn ='<button type="button" onclick="deleteOpbal(' . $ldg_id . ')"  class="btn btn-danger btn-circle btn-xs center-block"><i class="fa fa-times"></i></button>';
      $data['data'][]=array("id"=>$ldg_id,"account_name"=>$ldg_name,"open_bal"=>$opbal,"action"=>$btn);

    
    }
  }
  echo json_encode($data);
  
}



    
public function opbal()
    {

        $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
 //var_dump($data_arr);
   $compid=$data_arr['compId'];
   //$finyear=$data_arr['finyear'];
   $finyear=$data_arr['finyear'];

/*        if(!empty($id)){
            $data = $this->db->get_where("ledgermaster_tbl", ['id' => $id])->row_array();
        }else{*/
$ldgData=$this->data_model->getall_ledgers($compid);
$opbal=0;
if($ldgData)
{
  foreach ($ldgData as $key => $lvalue) {
    # code...

$ldg_id=$lvalue['id'];
$account_name=$lvalue['account_name'];


$opbalData=$this->data_model->getopbalData($compid,$finyear,$ldg_id);
//var_dump($opbalData);
if($opbalData)
{
 $opbal = $opbalData[0]['open_bal'];

}

else {
  $opbal=0;
}
$o_bal ='<input type="text" id="open_bal" value="'.$opbal.'" name="open_bal[]" style="text-align:right">';
$data['data'][]=array("id"=>$ldg_id,"account_name"=>$account_name,"open_bal"=>$opbal);

  } //Ledgermaster loop

echo json_encode($data);

}
else
{
  echo "data[]";
}


        
     

    }



    public function deleteproduct($id,$cid)
    {
      $input = $this->input->post();
      $input = $this->input->post();
      extract($_POST);
      $data_arr=get_defined_vars();
     
      $this->db->where('company_id',$cid);
      $this->db->where('id',$id);
         $status = $this->db->update('products_tbl',$input);
         $msg= array("status"=>$status, "success"=>true,"messages"=>"Record deleted successfully");     
echo json_encode($msg);    
    }



    public function updateproduct($id)
    {
      $input = $this->input->post();

      extract($_POST);
      $data_arr=get_defined_vars();
   
      $compid=$data_arr['company_id'];
      $prod_name=$data_arr['prod_name'];
      
      $this->db->where('company_id',$compid);
      $this->db->where('id',$id);
         $q = $this->db->get('products_tbl');
      
         if ( $q->num_rows() > 0 ) 
         {
          $this->db->where('company_id',$compid);
          $this->db->where('id',$id);
          $status =  $this->db->update('products_tbl',$input);
         } else {
            $this->db->set('id', $id);
          $status =  $this->db->insert('products_tbl',$input);
         }
      
      
      if($status)
      {
        $msg= array("status"=>$status, "success"=>true,"messages"=>"Record updated successfully");     
      
      }
      
      echo json_encode($msg);
      }
    
        

public function insertProduct()
{
  $input = $this->input->post();

  extract($_POST);
  $data_arr=get_defined_vars();

  $compid=$data_arr['company_id'];
  $prod_name=$data_arr['prod_name'];
  
  $this->db->where('company_id',$compid);
  $this->db->where('prod_name',$prod_name);
     $q = $this->db->get('products_tbl');
  
     if ( $q->num_rows() > 0 ) 
     {
      $this->db->where('company_id',$compid);
      $this->db->where('prod_name',$prod_name);
      $status =  $this->db->update('products_tbl',$input);
     } else {
        $this->db->set('prod_name', $prod_name);
      $status =  $this->db->insert('products_tbl',$input);
     }
  
  
  if($status)
  {
    $msg= array("status"=>$status, "success"=>true,"messages"=>"Record updated successfully");     
  
  }
  
  echo json_encode($msg);
  }



public function accountstrans($trans_type=null)
{

	$input = $this->input->post();

if($trans_type=="RCPT")
{
$msg="Receipt Entry Inserted successfully..!";
}

if($trans_type=="PYMT")
{
$msg="Payment Entry Inserted successfully..!";
}

if($trans_type=="CNTR")
{
$msg="Contra Entry Inserted successfully..!";
}

if($trans_type=="JRNL")
{
$msg="Journal Entry Inserted successfully..!";
}

$status = $this->db->insert('transaction_tbl',$input);
$msg= array("status"=>$status, "success"=>true,"messages"=>$msg);     
echo json_encode($msg);
//$this->response($msg, REST_Controller::HTTP_OK);


 //   extract($_POST);
 //   $data_arr=get_defined_vars();
//var_dump($data_arr);

//     $this->db->insert('openingbalance_tbl',$input);
  //   $msg= array("status"=>"1", "success"=>true,"messages"=>"Invoice updated successfully");     
  //  echo json_encode($msg);
    // $this->response($msg, REST_Controller::HTTP_OK);
    
    
     //       $this->db->insert('openingbalance_tbl ',$input);
      //      $msg= array("status"=>"1", "success"=>true,"messages"=>"Invoice updated successfully");     
      //      $this->response($msg, REST_Controller::HTTP_OK);
    }
    

public function getOpBalDatabyid()
{
	extract($_POST);
	$data_arr=get_defined_vars();
	$compid=$data_arr['company_id'];
	$ldg_id=$data_arr['ldger_id'];
	$finyear=$data_arr['finyear'];
$data= array([]);
	$getopdata = $this->data_model->getopdatabyid($compid,$ldg_id,$finyear);
if($getopdata)
{
	foreach ($getopdata as $opvalue) {
		$data[] = $opvalue;
	}
}
echo json_encode($data);
		

}

public function delete_OpBal()
{
	$input = $this->input->post();
	//var_dump($input);
 extract($_POST);
 $data_arr=get_defined_vars();
 //var_dump($data_arr);
 $compid=$data_arr['company_id'];
 $id=$data_arr['ldger_id'];
 $finyear=$data_arr['finyear'];
 
 $this->db->where('company_id',$compid);
 $this->db->where('finyear',$finyear);
 $this->db->where('ldger_id',$id);
 $status =  $this->db->update('openingbalance_tbl',$input);
 $msg= array("status"=>$status, "success"=>true,"messages"=>"Opening Balance updated successfully");     
echo json_encode($msg);

}


public function insertLedger($id,$cid)
{
        $input = $this->input->post();
// var_dump($input);
//extract($_POST);
//$data_arr=get_defined_vars();
//$compid=$data_arr['company_id'];
//$ldg_id=$data_arr['ldger_id'];
//$finyear=$data_arr['finyear'];

$this->db->where('company_id',$cid);
$this->db->where('id',$id);

//$this->db->where('user_id',$id);
   $q = $this->db->get('ledgermaster_tbl');

   if ( $q->num_rows() > 0 ) 
   {
    $this->db->where('company_id',$cid);
//    $this->db->where('finyear',$finyear);
    $this->db->where('id',$id);
    $status =  $this->db->update('ledgermaster_tbl',$input);
   } else {
   //   $this->db->set('id', $id);
    $status =  $this->db->insert('ledgermaster_tbl',$input);
   }


if($status)
{
  $msg= array("status"=>$status, "success"=>true,"messages"=>"Record updated successfully");     

}
else
{
  echo $status;
}

echo json_encode($msg);
}






public function insertLedgerAc()
{
$msg=array();
  $input = $this->input->post();
// var_dump($input);
//extract($_POST);
//$data_arr=get_defined_vars();
//$compid=$data_arr['company_id'];
//$ldg_id=$data_arr['ldger_id'];
//$finyear=$data_arr['finyear'];

   //   $this->db->set('id', $id);
    $status =  $this->db->insert('ledgermaster_tbl',$input);

  $msg= array("status"=>$status, "success"=>true,"messages"=>"Record updated successfully");     


echo json_encode($msg);
}


public function deleteLedger($id)
{
$msg=array();
  $input = $this->input->post();
// var_dump($input);
//extract($_POST);
//$data_arr=get_defined_vars();
//$compid=$data_arr['company_id'];
//$ldg_id=$data_arr['ldger_id'];
//$finyear=$data_arr['finyear'];

   //   $this->db->set('id', $id);
  $this->db->where("id",$id);
   $status =  $this->db->update('ledgermaster_tbl',$input);

  $msg= array("status"=>$status, "success"=>true,"messages"=>"Record updated successfully");     


echo json_encode($msg);
}




public function insertOpBal()
{
        $input = $this->input->post();
 //var_dump($input);
extract($_POST);
$data_arr=get_defined_vars();
$compid=$data_arr['company_id'];
$ldg_id=$data_arr['ldger_id'];
$finyear=$data_arr['finyear'];

$this->db->where('company_id',$compid);
$this->db->where('finyear',$finyear);
$this->db->where('ldger_id',$ldg_id);

//$this->db->where('user_id',$id);
   $q = $this->db->get('openingbalance_tbl');

   if ( $q->num_rows() > 0 ) 
   {
    $this->db->where('company_id',$compid);
    $this->db->where('finyear',$finyear);
    $this->db->where('ldger_id',$ldg_id);
    $status =  $this->db->update('openingbalance_tbl',$input);
   } else {
      $this->db->set('ldger_id', $ldg_id);
    $status =  $this->db->insert('openingbalance_tbl',$input);
   }


if($status)
{
  $msg= array("status"=>$status, "success"=>true,"messages"=>"Opening Balance updated successfully");     

}
else
{
  echo $status;
}

echo json_encode($msg);
}



public function updateOpBalDel()
{

   $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
 //  var_dump($data_arr);
   $compid=$data_arr['compId'];
   //$finyear=$data_arr['finyear'];
   $finyear=$data_arr['finyear'];

$delqry= $this->data_model->setdelflagopbal($compid,$finyear);


}


public function getsettings()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
//var_dump($data_arr);
  $settdata= $this->data_model->getSettings($cid,$finyear);
  if($settdata)
  {
    foreach($settdata as $settings)
    {
      $data[]=$settings;		

    }
  }
  echo json_encode($data);
}




public function finyearsettings()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  //var_dump($data_arr);
  $cid=$data_arr['compId'];
  $fyeardata= $this->data_model->getFYData($cid);
  if($fyeardata)
  {
    foreach($fyeardata as $fy)
    {
      $data[]=$fy;		

    }
    echo json_encode($data);
  }
}



public function salespersonbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $stfdata= $this->data_model->getStaffbycid($cid);
  if($stfdata)
  {
    foreach($stfdata as $stf)
    {
      $data[]=$stf;		

    }
  }
  echo json_encode($data);

}



public function accountstransaction()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
 // var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $trans_type=$data_arr['trans_type'];

//var_dump($data_arr);
//$compid=$this->input->get('cid');
//$finyear=$data_arr['finyear'];
//$finyear=$this->input->get('finyear');
//$trans_type=$this->input->get('trans_type');
//var_dump($finyear);
$transdata = $this->data_model->getTransData($cid,$finyear,$trans_type);
if($transdata)
{
  foreach($transdata as $td)
  {
    $data[]=$td;		

  }

}
echo json_encode($data);

}



public function statelist()
{
  $ldgdata= $this->data_model->getGstStatebycid();
  if($ldgdata)
  {
    foreach($ldgdata as $ldg)
    {
      $data[]=$ldg;		

    }
  }
  echo json_encode($data);


}




public function ledgerbyidbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $id=$data_arr['id'];
  $ldgdata= $this->data_model->getLedgerbyidbycid($cid,$id);
  if($ldgdata)
  {
    foreach($ldgdata as $ldg)
    {
      $data[]=$ldg;		

    }
  }
  echo json_encode($data);

}




public function ledgerbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $ldgdata= $this->data_model->getLedgerbycid($cid);
  if($ldgdata)
  {
    foreach($ldgdata as $ldg)
    {
      $data[]=$ldg;		

    }
  }
  echo json_encode($data);

}

public function productbykeyword($qry=null,$cid=null)
{
  $data=array();
  $prodcatdatabyqry= $this->data_model->getProductbyqry($qry,$cid);
  if($prodcatdatabyqry)
  {
    foreach($prodcatdatabyqry as $prod)
    {
      $data[]=$prod;		

    }
  }
  echo json_encode($data);


}

public function productbyname($qry=null,$cid=null)
{
  $data=array();
  $prodcatdatabyqry= $this->data_model->getProductbyqryname($qry,$cid);
  if($prodcatdatabyqry)
  {
    foreach($prodcatdatabyqry as $prod)
    {
      $data[]=$prod;		

    }
  }
  echo json_encode($data);


}

public function prodcatbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $prodcatdata= $this->data_model->getProductcatbycid($cid);
  if($prodcatdata)
  {
    foreach($prodcatdata as $prodcat)
    {
      $data[]=$prodcat;		

    }
  }
  echo json_encode($data);


}


public function unitsbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $unitdata= $this->data_model->getUnitsbycid($cid);
  if($unitdata)
  {
    foreach($unitdata as $unit)
    {
      $data[]=$unit;		

    }
  }
  echo json_encode($data);

}


public function productbyid($id=null,$cid=null)
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
//  $cid=$data_arr['compId'];
  $proddata= $this->data_model->getProductsbyidcid($id,$cid);
  if($proddata)
  {
    foreach($proddata as $prod)
    {
      $data[]=$prod;		

    }
  }
  echo json_encode($data);

}

public function productsbycid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  $cid=$data_arr['compId'];
  $proddata= $this->data_model->getProductsbycid($cid);
  if($proddata)
  {
    foreach($proddata as $prod)
    {
      $data[]=$prod;		

    }
  }
  echo json_encode($data);

}

public function getmonthwisedata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

$monwiseData=$this->data_model->getmonwiseData($cid,$finyear,$trans_type);
if($monwiseData)
{
	foreach ($monwiseData as $key => $value) {
		# code...
    $data[]=$value;		
	}
}
echo json_encode($data);
}


public function getcurmonthtransaction()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];
   $start_date=$data_arr['start_date'];
   $end_date=$data_arr['end_date'];


$cmtrans= $this->data_model->getcmtData($cid,$finyear,$trans_type,$start_date,$end_date);

if($cmtrans)
{
	foreach ($cmtrans as $key => $value) {
		# code...
            $data[]=array("taxable_tot"=>$value['taxable_tot'],"netamount_tot"=>$value['netamount_tot'],"gst_tot"=>$value['gst_tot']);
 

	}

            echo json_encode($data);

}
else {
            $data[]=array("taxable_tot"=>"0.00","netamount_tot"=>"0.00","gst_tot"=>"0.00");
            echo json_encode($data);


}



}

    public function chartData()
    {
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

   $schartdata= $this->data_model->getChartData($finyear,$cid,"SALE");
   $pchartdata= $this->data_model->getChartData($finyear,$cid,"PURC");
   $pichartdata=$this->data_model->getpiChartData($finyear,$cid);
$lable['labels'] = array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar");
if($pichartdata)
{
 foreach ($pichartdata as $key => $pivalue) {
 		# code...
$pilabel['pilabels'][]=$pivalue['sales_person'];
$pidata['pidata'][]=$pivalue['tot_rev'];


 	}	
}  
else
{
$pilabel['pilabels'][]="";// $pivalue['sales_person'];
$pidata['pidata'][]="0";

}
  
if($schartdata)
{
foreach ($schartdata as  $value) {
	# code...
// var_dump($value);
                        
                       
 $sdata['sales']=array(intval($value['APR']),intval($value['MAY']),intval($value['JUN']),intval($value['JUL']),intval($value['AUG']),intval($value['SEP']),intval($value['OCT']),intval($value['NOV']),intval($value['DEC']),intval($value['JAN']),intval($value['FEB']),intval($value['MAR']));



}


}


  
if($pchartdata)
{
foreach ($pchartdata as  $value) {
	# code...
// var_dump($value);
//$lable['labels'] = array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar");                        
                       
 $pdata['purchase']=array(intval($value['APR']),intval($value['MAY']),intval($value['JUN']),intval($value['JUL']),intval($value['AUG']),intval($value['SEP']),intval($value['OCT']),intval($value['NOV']),intval($value['DEC']),intval($value['JAN']),intval($value['FEB']),intval($value['MAR']));



}


}

$mdata['data']= array_merge($sdata,$pdata,$pidata);

$data=array_merge($lable,$pilabel,$mdata);
//$data = array_merge($data,$pdata);
echo json_encode($data);







}


public function getmonthwisegstdata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

$cmgsttrans= $this->data_model->getmonwisegstData($cid,$finyear,$trans_type);
//var_dump($cmgsttrans);
if($cmgsttrans)
{
	foreach ($cmgsttrans as $key => $value) {
		# code...
$data[]=$value;

	}

echo json_encode($data);

}


}



public function getmonthwiseitcdata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
//   $trans_type=$data_arr['trans_type'];

   $mitcData=$this->data_model->getmonwiseITCData($finyear,$cid);
if($mitcData)
{
	foreach ($mitcData as $key => $value) {
		# code...
		$data[]=$value;
	}
echo json_encode($data);
}


}




        public function byname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
//   var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
//   var_dump($cid . $qry);
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("prod_name",$qry);
        $data=$this->db->get('products_tbl')->result();
        
     echo json_encode($data[0]);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }

    public function ldggroup()
    {
 //     $this->db->where("company_id",$cid);
      $data=$this->db->get('group_tbl')->result();
 echo json_encode($data);

}




        public function keyword()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->like("prod_name",$qry);
        $data=$this->db->get('products_tbl')->result();
        }else{
            $data = $this->db->get("products_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }

public function updsettings()
{
extract($_POST);
$data_arr=get_defined_vars();
//$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];
$next_no=$data_arr['next_no'];
$trans_type=$data_arr['trans_type'];

   $updSett=$this->data_model->updSettings($cid,$finyear,$next_no,$trans_type);
//var_dump($updSett);
//return json_encode(array("status"==$updSett));

echo json_encode($updSett);

}


public function getcashledgerbyname()
{
extract($_POST);  
   $data_arr=get_defined_vars();
  // var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   $flag=$data_arr['flag'];
$data=array();
 if($flag=="csh")
 {
  $gpid=1;
     $this->db->where("company_id",$cid);
     $this->db->where("account_groupid",$gpid);
     $this->db->like("account_name",$qry);
     $data=$this->db->get('ledgermaster_tbl')->result();
 
     
     echo json_encode($data);





  }
  
//        $data=$this->db->get('ledgermaster_tbl')->result();
 
 else
 {
 //     $gid=array("1");
        $this->db->where("company_id",$cid);
        $this->db->like("account_name",$qry);

        $data=$this->db->get('ledgermaster_tbl')->result();
    echo json_encode($data);


 }

}


        public function lbyid()
    {
  extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['actid'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("id",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }else{
            $data = $this->db->get("ledgermaster_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }


        public function lbyname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("account_name",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }else{
            $data = $this->db->get("ledgermaster_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }


    public function getCashBankGroupid()
    {
      $this->db->where("id",1);
      $data=$this->db->get('group_tbl')->result();
      echo json_encode($data);
    }


        public function ldgbyname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
 $flag=$data_arr['flag'];


    //var_dump($cid . $qry);
      if($flag=="gen") {
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("account_name",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }



}