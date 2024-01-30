<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;
//require_once "dompdf/vendor/dompdf/dompdf/dompdf_config.inc.php";
class Reports extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
        $this->load->helper('file');
$this->load->helper('form');
    //   $this->load->model('common_model');
    //   $this->load->model('login_model');
$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    }

    public function cashbank(){
        $data = array();
        $data['page'] = 'Cash / Bank Book';
        $this->load->view('allcashbank', $data);
    }

    public function payments(){
        $data = array();
        $data['page'] = 'daybook';
        $this->load->view('alldaybook', $data);
    }
    public function purchasereg(){
        $data = array();
        $data['page'] = 'Purchase Register';
        $this->load->view('allpurchases', $data);
    }

    public function gledger(){
        $data = array();
        $data['page'] = 'General Ledger Report';
        $this->load->view('ledgerreport', $data);
    }

    public function cashbankdaybook()
    {
        $data = array();
        $data['page'] = 'Cash & Bank Daybook';
        $this->load->view('cashbank_daybook', $data);
    }

		
    public function gstreturnstatus()
    {
        $data = array();
        $data['page'] = 'GST Return Status';
        $this->load->view('gstreturn_status', $data);
    }
    public function gstr3b()
    {
        $data = array();
        $data['page'] = 'GSTR3B Return';
        $this->load->view('gstr3b', $data);
    }
    public function gstr9return()
    {
        $data = array();
        $data['page'] = 'GSTR9 Annual Return';
        $this->load->view('gstr9_annualreturn', $data);
    }

    public function gstr3bsum()
    {
        $data = array();
        $data['page'] = 'GSTR3B Summary';
        $this->load->view('gstsummary', $data);
    }

public function getSalesbyStaff()
{
  $data= array();
  $data['page'] = 'The Staffwise Sales Report';
  $this->load->view('staffsalesreport',$data);

}

public function getOutstandbyStaff()
{
  $data= array();
  $data['page'] = 'The Staffwise Outstanding Report';
  $this->load->view('staffoutstandingreport',$data);

}
public function getCategorySales()
{
  $data= array();
  $data['page'] = 'The Categorywise Sales Report';
  $this->load->view('categorysalesreport',$data);

}

public function getInventoryStocks()
{
  $data= array();
  $data['page'] = 'The Inventory Stock List';
  $this->load->view('inventorystockreport',$data);

}

public function getCatStocksSummary()
{
  $data= array();
  $data['page'] = 'The Inventory Stock List';
  $this->load->view('catstockreport',$data);

}

public function gst_returns_status()
{
	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');
	$gstin = $this->session->userdata('gstin');
	$url= $this->config->item("api_url") . "/api/reports/getGstFieldStatus";
	$data_post = array("finyear"=>$finyear,"compId"=>$compId,"gstin"=>$gstin);
	//$post = ['batch_id'=> "2"];
	//var_dump($data_post);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$response = curl_exec($ch);
	var_dump($response);
		$op_stockitems = json_decode($response,true);
	 //echo $ledgerresponse;
	//var_dump($response);
	//echo $stf_salesitems;
	curl_close($ch); // Close the connection
	


$tbl='<div class="card-header">GST Returns Filed Status</div>
<table id="gstreturns_status_tbl" class="table">
	<thead>
		<tr>
		<th>MODE</th>
		<th>DATE ON FILED</th>
		<th>RETURN PERIOD</th>
		<th>RETURN TYPE</th>
		<th>ARN#</th>
		<th>STATUS</th>
		<th>VALID?</th>
	
		</tr>
	</thead>
	<tbody>';

		
$tbl .=	'</tbody>
</table>
';

echo $tbl;
}

public function getSalesPerson()
{
	$compId = $this->session->userdata('id');
	$url=$this->config->item("api_url") . "/api/productlist/salespersonbycid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();

	$data = array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));


	$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['sales_person'].'</option>';

}
$option .= '<option selected  value="0">All Salesperson</option>';
echo $option;

}

public function getCategoryList()
{
	$compId = $this->session->userdata('id');
	$url=$this->config->item("api_url") . "/api/productlist/categorybycid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();

	$data = array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));


	$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['category_name'].'</option>';

}
$option .= '<option selected  value="0">All Category</option>';
echo $option;

}


public function getCategoryListbycid()
{
	$compId = $this->session->userdata('id');
	$url=$this->config->item("api_url") . "/api/productlist/categorybycid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();

	$data = array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));


	$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
echo $response;
}


public function getCatStockItems()
{
$data=array();
$finyear = $this->session->userdata('finyear');
$fdate = $this->input->post('fdate');
$tdate = $this->input->post('tdate');
$compId = $this->session->userdata('id');
$catid=$this->input->post('catid');
$fr_date = substr($finyear,0,4) . "-04-01";


//StockTransOP
//Opening Stock from Apr to current start date
$url= $this->config->item("api_url") . "/api/reports/getTransopStock";
$data_post = array("catid"=>$catid,"finyear"=>$finyear,"compId"=>$compId,"f_date"=>$fr_date,"t_date"=>$fdate);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
//var_dump($response);
	$op_stockitems = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
//echo $stf_salesitems;
curl_close($ch); // Close the connection

//Stock Transaction

$url= $this->config->item("api_url") . "/api/reports/getTransStock";
$data_post = array("catid"=>$catid,"finyear"=>$finyear,"compId"=>$compId,"f_date"=>$fdate,"t_date"=>$tdate);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
//var_dump($response);
	$stockitems = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
//echo $stf_salesitems;
curl_close($ch); // Close the connection




//Category List
$compId = $this->session->userdata('id');
$url=$this->config->item("api_url") . "/api/productlist/categorybyid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
$ch = curl_init();

$data_post = array("compId"=>$compId,"cat_id"=>$catid);
//var_dump($data_post);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));


$response = curl_exec($ch);
//var_dump($response);
//$result = json_decode($response);
curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
//var_dump($groupArray);



// Product List
$url=$this->config->item("api_url") . "/api/productlist/prodbycatid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
$ch = curl_init();

$data_post = array("compId"=>$compId,"cat_id"=>$catid);
//var_dump($data_post);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));


$response = curl_exec($ch);
//var_dump($response);
//$result = json_decode($response);
curl_close($ch); // Close the connection
$prodArray = json_decode($response, true);
//var_dump($prodArray);
// all product Opening_stock 
$url= $this->config->item("api_url") . "/api/reports/getOpStockbycid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
//var_dump($response);
	$op_stock = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
//echo $stf_salesitems;
curl_close($ch); // Close the connection
$op_stk=0.000;
$prev_opstock=0.000;
$open_stk=0.000;
$inward=0.000;
$outward=0.000;
$cl_stk =0.000;
//var_dump($groupArray);
if($groupArray)
{
foreach ($groupArray as $key => $cvalue) {
	# code...
$cat_id=$cvalue['id'];
$cat_name=$cvalue['category_name'];

//var_dump($prodArray);
if($prodArray)
{
	foreach ($prodArray as $key => $pvalue) {
		# code...
//		var_dump($pvalue['prod_cat']);
if($pvalue['prod_cat']==$cat_id)
{
	$prod_id=$pvalue['id'];
	$prod_name=$pvalue['prod_name'];
	$prod_mrp=$pvalue['prod_mrp'];
	
//var_dump($prod_name);
if($op_stock)
{
	foreach ($op_stock as $key => $opsvalue) {
		# code...
if($opsvalue['prod_id']==$prod_id)
{
$op_stk=$opsvalue['prod_qty'];


}
}
}

if($op_stockitems)
{
//	var_dump($op_stockitems);
	foreach ($op_stockitems as $key => $prv_op) {
	if($prv_op['item_id']==$prod_id)	
		$prev_opstock = $prv_op['opstock'];


	}
}
$open_stk = number_format($op_stk+$prev_opstock,3);
//var_dump($open_stk);

if($stockitems)
{
foreach ($stockitems as $key => $stk) {
	if($stk['item_id']==$prod_id)
	{
		$inward = number_format($stk['inward'],3);
	  $outward = number_format($stk['outward'],3);

	}
}

}

$cl_stk = number_format($open_stk + $inward - $outward,3);
$cl_stkval =$prod_mrp*$cl_stk;
$data[] = array("category"=>$cat_name,"prod_name"=>$prod_name,"prod_mrp"=>$prod_mrp,"opstock"=>$open_stk,"inward"=>$inward,"outward"=>$outward,"cl_stock"=>$cl_stk,"cl_stkvalue"=>$cl_stkval);
$op_stk=0.000;
$prev_opstock=0.000;
$open_stk=0.000;
$inward=0.000;
$outward=0.000;
$cl_stk =0.000;

}
}
}






}


}




/*
if($stockitems)
{
foreach ($stockitems as $key => $s) {
if($s['item_id']==$prod_id)
{
$cat_name = $s['category_name'];
$item_id = $s['item_id'];
$item_name=$s['item_name'];
$inward = $s['inward'];
$outward = $s['outward'];
$prev_opstock =0;
$op_stk=0;
//	var_dump($op_stockitems);
if($op_stockitems)
{
	foreach ($op_stockitems as $key => $op) {
		if($prod_id==$op['item_id'])
		{
			$prev_opstock = $op['opstock'];
		}
	}

}
else
{
$prev_opstock=0;
}
if($op_stock)
{
foreach ($op_stock as $key => $osvalue) {
	if($prod_id==$osvalue['prod_id'])
	{
		$op_stk = $osvalue['prod_qty'];
	//	var_dump($op_stk . $item_id);
}	
}
}
else
{
$op_stk=0;
}
//var_dump($prev_opstock . $op_stk);

$opening_stock = $op_stk + $prev_opstock;
$cl_stock = $opening_stock + $inward - $outward;
$data[] = array("category"=>$cat_name,"prod_id"=>$item_id,"prod_name"=>$item_name,"opstock"=>$opening_stock, "inward"=>$inward,"outward"=>$outward,"cl_stock"=>$cl_stock);

}




} //forloop stockitems

} //if stockitems


*/
echo json_encode($data);
}



public function getStockitems()
{
	$fdate = $this->input->post('fdate');
	$tdate = $this->input->post('tdate');
	$compId = $this->session->userdata('id');
  $finyear = $this->session->userdata('finyear');
	$catid=$this->input->post('catid');
	$fr_date = substr($finyear,0,4) . "-04-01";
	//var_dump($fr_date);    
$data=array();


$cl_stock=0;
$opstk=0;
$opstock=0;
$prev_opstock=0;
$op_stk=0;

$url= $this->config->item("api_url") . "/api/reports/getOpStockbycid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
//var_dump($response);
	$op_stock = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
//echo $stf_salesitems;
curl_close($ch); // Close the connection




	$url= $this->config->item("api_url") . "/api/reports/getTransopStock";
	$data_post = array("catid"=>$catid,"finyear"=>$finyear,"compId"=>$compId,"f_date"=>$fr_date,"t_date"=>$fdate);
	//$post = ['batch_id'=> "2"];
	//var_dump($data_post);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$response = curl_exec($ch);
	//var_dump($response);
		$op_stockitems = json_decode($response,true);
	 //echo $ledgerresponse;
	//var_dump($response);
	//echo $stf_salesitems;
	curl_close($ch); // Close the connection





	$url= $this->config->item("api_url") . "/api/reports/getTransStock";
	$data_post = array("catid"=>$catid,"finyear"=>$finyear,"compId"=>$compId,"f_date"=>$fdate,"t_date"=>$tdate);
	//$post = ['batch_id'=> "2"];
	//var_dump($data_post);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$response = curl_exec($ch);
	//var_dump($response);
		$stockitems = json_decode($response,true);
	 //echo $ledgerresponse;
	//var_dump($response);
	//echo $stf_salesitems;
	curl_close($ch); // Close the connection
	
if($stockitems)
{
	foreach ($stockitems as $key => $s) {

	$cat_name = $s['category_name'];
	$item_id = $s['item_id'];
	$item_name=$s['item_name'];
	$inward = $s['inward'];
	$outward = $s['outward'];
	$prev_opstock =0;
	$op_stk=0;
//	var_dump($op_stockitems);
  if($op_stockitems)
	{
		foreach ($op_stockitems as $key => $op) {
			if($item_id==$op['item_id'])
			{
				$prev_opstock = $op['opstock'];
			}
		}
	
}
else
{
	$prev_opstock=0;
}
if($op_stock)
{
	foreach ($op_stock as $key => $osvalue) {
	  if($item_id==$osvalue['prod_id'])
		{
			$op_stk = $osvalue['prod_qty'];
		//	var_dump($op_stk . $item_id);
}	
}
}
else
{
	$op_stk=0;
}
//var_dump($prev_opstock . $op_stk);

$opening_stock = $op_stk + $prev_opstock;
	$cl_stock = $opening_stock + $inward - $outward;

	$data[] = array("category"=>$cat_name,"prod_id"=>$item_id,"prod_name"=>$item_name,"opstock"=>$opening_stock, "inward"=>$inward,"outward"=>$outward,"cl_stock"=>$cl_stock);

		
	}
}


echo json_encode($data);

}


public function getCatSales()
{
	$fdate = $this->input->post('fdate');
	$tdate = $this->input->post('tdate');
	$compId = $this->session->userdata('id');
  $finyear = $this->session->userdata('finyear');
	$catid=$this->input->post('catid');
	$trans_type="SALE";
//var_dump($fdate);
$data=array();

// Get Sales by Staff ID 
$url= $this->config->item("api_url") . "/api/reports/getSalesby_transtype";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "trans_type"=>$trans_type,"f_date"=>$fdate,"t_date"=>$tdate);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	//var_dump($response);
	$cat_sales = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
curl_close($ch); // Close the connection

if($cat_sales)
{
	foreach ($cat_sales as $key => $ms) {
		
$link_id = $ms['id'];
$cust_name=$ms['account_name'];

$url= $this->config->item("api_url") . "/api/reports/getSalesItemsbycatid";
$data_post = array("catid"=>$catid,"finyear"=>$finyear,"compId"=>$compId, "link_id"=>$link_id,"f_date"=>$fdate,"t_date"=>$tdate);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	$cat_salesitems = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($response);
//echo $stf_salesitems;
curl_close($ch); // Close the connection


if($cat_salesitems)
{

	foreach ($cat_salesitems as $key => $svalue) {
		# code...
		$date=date_create($svalue['trans_date']);
		$discpc=number_format($svalue['item_dispc'],2);
		$vdiscpc=number_format($svalue['v_disc_pc'],2);
		$diffpc= number_format(($vdiscpc-$discpc),2);
		//c.category_name, i.trans_id,i.trans_date,i.item_name,i.item_desc,i.item_hsnsac,i.item_unit,i.item_qty,i.item_mrp,i.item_rate,i.item_amount,(i.taxable_amount)`txb_amt`,(i.nett_amount)`net_amt`,((i.igst_amount)+(i.cgst_amount)+(i.igst_amount))`gst_amt`
$data[]=array("category"=>$svalue['category_name'],"invoiceno"=>$svalue['trans_id'],"trans_date"=>date_format($date,"d/m/Y"), "cust_name"=>$cust_name,"item_name"=>$svalue['item_name'],"item_hsnsac"=>$svalue['item_hsnsac'],"item_unit"=>$svalue['item_unit'],"item_mrp"=>$svalue['item_mrp'],"item_qty"=>$svalue['item_qty'],"item_rate"=>$svalue['item_rate'],"item_amount"=>$svalue['item_amount'], "txb_amt"=>$svalue['txb_amt'],"gst_amt"=>$svalue['gst_amt'],"net_amt"=>$svalue['net_amt'],"discpc"=>$discpc,"vdiscpc"=>$vdiscpc,"diffpc"=>$diffpc);

	}
}




	}
}




echo json_encode($data);

}



function gettransItemsbyid()
{
	$compId = $this->session->userdata('id');
	$itemid = $this->input->get('itemid');
	
	$data=array();
		$data_array= array("itemid"=>$itemid,"compId"=>$compId);
		
		//var_dump($data_array);
		$url = $this->config->item("login_url") . "/api/productlist/accountsitemtransaction";
		
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
			$response = curl_exec($ch);
				curl_close($ch);
		
		echo $response;
}

public function getStaffOutstand()
{
	$compId = $this->session->userdata('id');
  $finyear = $this->session->userdata('finyear');
	$stfid=$this->input->post('stfid');
	$data=array();
	$op_bal=0;
	$url= $this->config->item("api_url") . "/api/reports/getStaffList";
	$data_post = array("finyear"=>$finyear,"compId"=>$compId,"stfid"=>$stfid);
	//$post = ['batch_id'=> "2"];
	//var_dump($data);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$response = curl_exec($ch);
		//var_dump($response);
		$result = json_decode($response,true);
	 //echo $ledgerresponse;
	//var_dump($result);
	curl_close($ch); // Close the connection




	$stf_data=array();	

if($result)
{
	foreach ($result as $key => $sl) {

$stf_id = $sl['id'];
$stf_name=$sl['sales_person'];

// Get Sales by Staff ID 
$url= $this->config->item("api_url") . "/api/reports/getSalesbyStaffcustid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "stf_id"=>$stf_id);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	//var_dump($response);

	$stf_sales = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($stf_sales);
curl_close($ch); // Close the connection

if($stf_sales)
{
	foreach ($stf_sales as $key => $ms) {
		
$db_account = $ms['db_account'];
$cust_name=$ms['account_name'];

$url= $this->config->item("api_url") . "/api/reports/getOpbyCustid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "cust_id"=>$db_account);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	$ldg_op = json_decode($response,true);
// var_dump($response);
	//echo $ledgerresponse;
//var_dump($stf_salesitems);
//echo $stf_salesitems;
curl_close($ch); // Close the connection

if($ldg_op)
{
	foreach ($ldg_op as $key => $opvalue) {
		# code...
		$op_bal = $opvalue['open_bal'];
	}
}
else
{
	$op_bal=0;
}


$url= $this->config->item("api_url") . "/api/reports/getSalesCustid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "cust_id"=>$db_account);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	$stf_salesdata = json_decode($response,true);
// var_dump($response);
	//echo $ledgerresponse;
//var_dump($stf_salesitems);
//echo $stf_salesitems;
curl_close($ch); // Close the connection


if($stf_salesdata)
{

	foreach ($stf_salesdata as  $svalue) {
		# code...
	//	$date=date_create($svalue['trans_date']);
$outstand_amt = $op_bal + $svalue['tot_sales'] - $svalue['tot_rcpt'];
		$data[]=array("staffname"=>$stf_name,"cust_name"=>$cust_name, "outstand_amt"=>$outstand_amt);

	}
}




	}
}





	}

}

echo json_encode($data);

}

public function getStaffSales()
{
	$fdate = $this->input->post('fdate');
	$tdate = $this->input->post('tdate');
	$compId = $this->session->userdata('id');
  $finyear = $this->session->userdata('finyear');
	$stfid=$this->input->post('stfid');
//var_dump($fdate);
$data=array();
	$url= $this->config->item("api_url") . "/api/reports/getStaffList";
	$data_post = array("finyear"=>$finyear,"compId"=>$compId,"stfid"=>$stfid);
	//$post = ['batch_id'=> "2"];
	//var_dump($data);  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$response = curl_exec($ch);
		$result = json_decode($response,true);
	 //echo $ledgerresponse;
	//var_dump($result);
	curl_close($ch); // Close the connection

	$stf_data=array();	

if($result)
{
	foreach ($result as $key => $sl) {

$stf_id = $sl['id'];
$stf_name=$sl['sales_person'];

// Get Sales by Staff ID 
$url= $this->config->item("api_url") . "/api/reports/getSalesbyStaffid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "stf_id"=>$stf_id,"f_date"=>$fdate,"t_date"=>$tdate);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	$stf_sales = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($stf_sales);
curl_close($ch); // Close the connection

if($stf_sales)
{
	foreach ($stf_sales as $key => $ms) {
		
$link_id = $ms['id'];
$cust_name=$ms['account_name'];

$url= $this->config->item("api_url") . "/api/reports/getSalesItemsid";
$data_post = array("finyear"=>$finyear,"compId"=>$compId, "link_id"=>$link_id,"f_date"=>$fdate,"t_date"=>$tdate);
//$post = ['batch_id'=> "2"];
//var_dump($data_post);  
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

	$response = curl_exec($ch);
	$stf_salesitems = json_decode($response,true);
 //echo $ledgerresponse;
//var_dump($stf_salesitems);
//echo $stf_salesitems;
curl_close($ch); // Close the connection


if($stf_salesitems)
{

	foreach ($stf_salesitems as $key => $svalue) {
		# code...
		$date=date_create($svalue['trans_date']);
$data[]=array("staffname"=>$stf_name,"category"=>$svalue['category_name'],"invoiceno"=>$svalue['trans_id'],"trans_date"=>date_format($date,"d/m/Y"), "cust_name"=>$cust_name, "txb_amt"=>$svalue['txb_amt'],"gst_amt"=>$svalue['gst_amt'],"net_amt"=>$svalue['net_amt']);

	}
}




	}
}





	}

}

echo json_encode($data);

}


public function trialbal()
{
  $data= array();
  $data['page'] = 'Trial Balance Report';
  $this->load->view('tb_list',$data);
}

    public function gstr2b()
    {
        $data = array();
        $data['page'] = 'GSTR2B Purchase Return';
        $this->load->view('gstr2b', $data);
    }


    public function gstr1()
    {
        $data = array();
        $data['page'] = 'GSTR1 Return';
        $this->load->view('gstr1', $data);
    }

    public function cwms()
    {
        $data = array();
        $data['page'] = 'Clientwise Monthly Sales Summary';
        $this->load->view('clientwisemsales', $data);
    }



public function gettrialbal()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$url= $this->config->item("api_url") . "/api/reports/getTBData";
$data_post = array("finyear"=>$finyear,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $tbdatares = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($tbdatares);
curl_close($ch); // Close the connection


//$group_data =


 // $data['data'][]=array("group"=>"ABC","name"=>"Vijay Amirtharaj","debitamt"=>123.00,"creditamt"=>245.00);
  echo $tbdatares;
}


public function getclbalbyacctid()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$acct_id = $this->input->get('acct_id');

$url= $this->config->item("api_url") . "/api/reports/getBalancebyAcctId";
$data_post = array("finyear"=>$finyear,"compId"=>$compId,"acct_id"=>$acct_id);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $tbdatares = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($tbdatares);
curl_close($ch); // Close the connection


//$group_data =


 // $data['data'][]=array("group"=>"ABC","name"=>"Vijay Amirtharaj","debitamt"=>123.00,"creditamt"=>245.00);
  echo $tbdatares;
}



public function cwms_report()
{
$tbl='';
$compId = $this->session->userdata('id');
  $yr=$this->input->get('fy');
  $nxt_yr=($yr+1);
  $fy=$yr . "-" . substr($nxt_yr, 2,2);
  //var_dump($fy);
$cwdata=array();
/*$url= $this->config->item("api_url") . "/api/reports/getmonthwiseclientcode";
$data = array("trans_type"=>"SALE","finyear"=>$fy,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cwsresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($cwsresponse);
curl_close($ch); // Close the connection
$cwsmaindata = json_decode($cwsresponse,true);
//if($cwsmaindata)
//{

//foreach ($cwsmaindata as $key => $value) {
*/
$compId = $this->session->userdata('id');
  $yr=$this->input->get('fy');
  $nxt_yr=($yr+1);
  $fy=$yr . "-" . substr($nxt_yr, 2,2);
  //$acctid=$value['db_account'];
  //var_dump($fy);
$url= $this->config->item("api_url") . "/api/reports/getmonthwiseclientdata";
$data_post = array("trans_type"=>"SALE","finyear"=>$fy,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
//var_dump($data);  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $cwsdatares = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($cwsdatares);
curl_close($ch); // Close the connection


$cwdata=json_decode($cwsdatares,true);
//var_dump($cwdata);
  # code...


//}

//}
 $tot=0;
  $apr=0;
  $may=0;
  $jun=0;
  $jul=0;
  $aug=0;
  $sep=0;
  $oct=0;
  $nov=0;
  $dec=0;
  $jan=0;
  $feb=0;
  $mar=0;
  $gst=0;
  $apr_tot=0;
  $may_tot=0;
  $jun_tot=0;
  $jul_tot=0;
  $aug_tot=0;
  $sep_tot=0;
  $oct_tot=0;
  $nov_tot=0;
  $dec_tot=0;
  $jan_tot=0;
  $feb_tot=0;
  $mar_tot=0;
  $gst_tot=0;
  $os_amt=0;
  $os_tot=0;

// var_dump($cwdata);
foreach ($cwdata as $key => $value) {
  # code...
  //var_dump($value);
    $apr=$value['apr'];
    $may=$value['may'];
    $jun=$value['jun'];
    $jul=$value['jul'];
    $aug=$value['aug'];
    $sep=$value['sep'];
    $oct=$value['oct'];
    $nov=$value['nov'];
    $dec=$value['dec'];
    $jan=$value['jan'];
    $feb=$value['feb'];
    $mar=$value['mar'];
    $gst=$value['gst'];
    $os_amt=$value['outstand'];

    $tot= $tot+$apr+$may+$jun+$jul+$aug+$sep+$oct+$nov+$dec+$jan+$feb+$mar+$gst;
$apr_tot=$apr_tot+$apr;
$may_tot=$may_tot+$may;
$jun_tot=$jun_tot+$jun;
$jul_tot=$jul_tot+$jul;
$aug_tot=$aug_tot+$aug;
$sep_tot=$sep_tot+$sep;
$oct_tot=$oct_tot+$oct;
$nov_tot=$nov_tot+$nov;
$dec_tot=$dec_tot+$dec;
$jan_tot=$jan_tot+$jan;
$feb_tot=$feb_tot+$feb;
$mar_tot=$mar_tot+$mar;
$gst_tot=$gst_tot+$gst;
$os_tot=$os_tot+$os_amt;

//var_dump($nov);
if($apr>0)
{
    $apr=number_format($value['apr'], 2, '.', '');
}
else
{
  $apr="";
}
if($may>0)
{

    $may=number_format($value['may'], 2, '.', '');
  }
  else{
    $may ="";
  }
if($jun>0)
{

    $jun=number_format($value['jun'], 2, '.', '');
  }
else{
  $jun="";
}
if($jul>0)
{

    $jul=number_format($value['jul'], 2, '.', '');
  }
  else
  {
    $jul="";
  }
  if($aug>0)
{

    $aug=number_format($value['aug'], 2, '.', '');
  }
  else {
   $aug="";
  }
if($sep>0)
{

    $sep=number_format($value['sep'], 2, '.', '');
  }
  else {
    $sep="";
  }
if($oct>0)
{

    $oct=number_format($value['oct'], 2, '.', '');
  }
  else {
    $oct="";
  }
if($nov>0)
{

    $nov=number_format($value['nov'], 2, '.', '');
  }
  else
  {
    $nov="";
  }
  if($dec>0)
{

    $dec=number_format($value['dec'], 2, '.', '');
  } 
  else {
    $dec="";
  }
  if($apr>0)
{

    $jan=number_format($value['jan'], 2, '.', '');
}
else {
  $jan="";
}
if($feb>0)
{

    $feb=number_format($value['feb'], 2, '.', '');
  }
  else {
    $feb="";
  }
  if($apr>0)
{

    $mar=number_format($value['mar'], 2, '.', '');
  }
  else {
    $mar="";
  }

  if($gst>0)
{

    $gst=number_format($value['gst'], 2, '.', '');
  }
  else {
    $gst="";
  }


$tbl .='<tr><td class="extcol" width="400px">'. $value["account_name"] .'</td><td style="text-align:right;">'. $apr .'</td><td style="text-align:right;">'. $may .'</td><td style="text-align:right;">'. $jun .'</td><td style="text-align:right;">'. $jul .'</td><td style="text-align:right;">'. $aug .'</td><td style="text-align:right;">'. $sep .'</td><td style="text-align:right;">'. $oct .'</td><td style="text-align:right;">'. $nov .'</td><td style="text-align:right;">'. $dec .'</td><td style="text-align:right;">'. $jan .'</td><td style="text-align:right;">'. $feb .'</td><td style="text-align:right;">'. $mar .'</td><td style="text-align:right;">'. $gst .'</td><td style="text-align:right;font-weight:bold;">'. number_format($tot, 2, '.', '') .'</td><td style="text-align:right;font-weight:bold;">'. number_format($os_amt,2,'.','') .'</td></tr>';
$tot=0;
}

$nettot= $apr_tot+$may_tot+$jun_tot+$jul_tot+$aug_tot+$sep_tot+$oct_tot+$nov_tot+$dec_tot+$jan_tot+$feb_tot+$mar_tot+$gst_tot;

if($apr_tot>0)
{
    $apr_tot=number_format($apr_tot, 2, '.', '');
}
else
{
  $apr_tot="";
}
if($may_tot>0)
{

    $may_tot=number_format($may_tot, 2, '.', '');
  }
  else{
    $may_tot="";
  }
if($jun_tot>0)
{

    $jun_tot=number_format($jun_tot, 2, '.', '');
  }
else{
  $jun_tot="";
}
if($jul_tot>0)
{

    $jul_tot=number_format($jul_tot, 2, '.', '');
  }
  else
  {
    $jul_tot="";
  }
  if($aug_tot>0)
{

    $aug_tot=number_format($aug_tot, 2, '.', '');
  }
  else {
   $aug_tot="";
  }
if($sep_tot>0)
{

    $sep_tot=number_format($sep_tot, 2, '.', '');
  }
  else {
    $sep_tot="";
  }
if($oct_tot>0)
{

    $oct_tot=number_format($oct_tot, 2, '.', '');
  }
  else {
    $oct_tot="";
  }
if($nov_tot>0)
{

    $nov_tot=number_format($nov_tot, 2, '.', '');
  }
  else
  {
    $nov_tot="";
  }
  if($dec_tot>0)
{

    $dec_tot=number_format($dec_tot, 2, '.', '');
  } 
  else {
    $dec_tot="";
  }
  if($apr_tot>0)
{

    $jan_tot=number_format($jan_tot, 2, '.', '');
}
else {
  $jan_tot="";
}
if($feb_tot>0)
{

    $feb_tot=number_format($feb_tot, 2, '.', '');
  }
  else {
    $feb_tot="";
  }
  if($mar_tot>0)
{

    $mar_tot=number_format($mar_tot, 2, '.', '');
  }
  else {
    $mar_tot="";
  }

  if($gst_tot>0)
{

    $gst_tot=number_format($gst_tot, 2, '.', '');
  }
  else {
    $gst_tot="";
  }


  if($os_tot>0)
{

    $os_tot=number_format($os_tot, 2, '.', '');
  }
  else {
    $os_tot=0;
  }

$tbl .='<tr><td style="font-weight:bold;">TOTAL</td><td style="text-align:right;font-weight:bold;">'. $apr_tot .'</td><td style="text-align:right;font-weight:bold;">'. $may_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jun_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jul_tot .'</td><td style="text-align:right;font-weight:bold;">'. $aug_tot .'</td><td style="text-align:right;font-weight:bold;">'. $sep_tot .'</td><td style="text-align:right;font-weight:bold;">'. $oct_tot .'</td><td style="text-align:right;font-weight:bold;">'. $nov_tot .'</td><td style="text-align:right;font-weight:bold;">'. $dec_tot .'</td><td style="text-align:right;font-weight:bold;">'. $jan_tot .'</td><td style="text-align:right;font-weight:bold;">'. $feb_tot .'</td><td style="text-align:right;font-weight:bold;">'. $mar_tot .'</td><td style="text-align:right;font-weight:bold;">'. $gst_tot .'</td><td style="text-align:right;font-weight:bold;">'. number_format($nettot,2,'.','') .'</td><td style="text-align:right;font-weight:bold;">'. number_format($os_tot,2,'.','') .'</td></tr>';

echo $tbl;

}


public function gstr1b2bJson()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));

}


$item_cess="0";
$item_igst="0";
$item_cgst="0";
$item_sgst="0";
$rcm="N";
$arrmerge1=array();
$retmon= date("mY",strtotime($tdate));
$compId = $this->session->userdata('id');
$compGstin = $this->session->userdata('gstin');
$compStatecode = $this->session->userdata('cstatecode');
$isecomm = $this->session->userdata('ecomm');
    //$isecomm = $comvalue['ecomm'];
if($isecomm==0) {
  $ec="OE";
}

$data = array();
$itms = array();
$inv = array();
$finalmerge=array();
$gst = array();

//$url= $this->config->item("api_url") . "/api/getgstindata.php";
$url=$this->config->item("api_url") . "/api/reports/getGstJson";

$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"compStatecode"=>$compStatecode,"compGstin"=>$compGstin,"retmon"=>$retmon,"rcm"=>$rcm,"ec"=>$ec);
//var_dump($data_post);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinresponse);
curl_close($ch); // Close the connection
$b2bgstinData = json_decode($gstinresponse,true);
//echo json_encode($gstinresponse);
echo $gstinresponse;



}




public function Old_gstr1b2bJson()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}




/*
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
*/
$item_cess="0";
$item_igst="0";
$item_cgst="0";
$item_sgst="0";
$rcm="N";
$arrmerge1=array();
$retmon= date("mY",strtotime($tdate));
/*
$comdetails= $this->session->userdata('compdetails');

foreach ($comdetails as $key => $comvalue) {
    # code...
  //  print_r($comvalue);
    $compId = $comvalue['cid'];
    $compGstin = $comvalue['cgstin'];
    $compStatecode = $comvalue['compstatecode'];
    $isecomm = $comvalue['ecomm'];
 //   print_r($comid);
}
if($isecomm==0) {
  $ec="OE";
}

*/
$compId = $this->session->userdata('id');
$compGstin = $this->session->userdata('gstin');
$compStatecode = $this->session->userdata('cstatecode');
    //$isecomm = $comvalue['ecomm'];

$data = array();
$itms = array();
$inv = array();
$finalmerge=array();
$gst = array();

$url= $this->config->item("api_url") . "/api/getgstindata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$b2bgstinData = json_decode($gstinresponse,true);
//echo $gstr1response;


///$b2bInvoiceData = $this->common_model->getInvData($fdate,$tdate,$compId);
//print_r($b2bInvoiceData);
foreach ($b2bgstinData as $key => $invvalue) 
{

$gstno = $invvalue['gstin'];  
//$invno = $invvalue['invoice_no'];
$rw=1;





$url= $this->config->item("api_url") . "/api/getgstinvdata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gstin"=>$gstno);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinvresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinvresponse);
curl_close($ch); // Close the connection
$b2bgstinvData = json_decode($gstinvresponse,true);
//echo $gstr1response;



//$b2bInvoicegstinData=$this->common_model->getInvgstdatajson($gstno,$fdate,$tdate,$compId);

//$inv=array();
//print_r($b2bInvoicegstinData);
//print_r('qry' . $rw);
//var_dump($b2bInvoicegstinData);
foreach ($b2bgstinvData as $key => $gstvalue) {
$invNo=$gstvalue['trans_id'];
//print_r($invNo);

$inv_amt=$gstvalue['inv_amt'];


$url= $this->config->item("api_url") . "/api/getinvjsondata.php";
$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gstin"=>$gstno,"trans_id"=>$invNo);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstinv_response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstinv_response);
curl_close($ch); // Close the connection
$b2bData = json_decode($gstinv_response,true);


//$b2bData=$this->common_model->getB2BJson($fdate,$tdate,$compId,$gstno,$invNo);
//print_r($b2bData);
$itms=array();
foreach ($b2bData as $key => $b2bvalue)
{
if($invNo==$b2bvalue['trans_id'])
{
  
if($compStatecode==$b2bvalue['pos'])
{
$itms[]=array('num'=>$b2bvalue['gst_pc'].'01',
    'itm_det' => array('txval'=>$b2bvalue['taxable_amt'],
      'rt' =>$b2bvalue['gst_pc'],
      'camt'=>number_format((float)$b2bvalue['item_cgst'],2,'.',''),
      'samt'=>number_format((float)$b2bvalue['item_sgst'],2,'.',''),
      'csamt'=>number_format((float)$b2bvalue['item_cess'],2,'.','')
  ),);

}

else {

$itms[]=array('num'=>$b2bvalue['gst_pc'].'01',
    'itm_det' => array('txval'=>$b2bvalue['taxable_amt'],
      'rt' =>$b2bvalue['gst_pc'],
      'iamt'=>number_format((float)$b2bvalue['item_igst'],2,'.',''),
      'csamt'=>number_format((float)$b2bvalue['item_cess'],2,'.','')
  ),);

}
}
  
} //b2bvalue


$invdate =date("d-m-Y", strtotime($gstvalue['trans_date']));

    $inv['inv'][]= array('inum' => $gstvalue['trans_id'],
    'idt'=>$invdate,
    
    'val'=>number_format((float)$b2bvalue['inv_amt'],2,'.',''),
    'pos' =>"'" . substr($invvalue['gstin'],0,2) ."'", // $gstvalue['placeofsupply'] ."'",
    'rchrg' => $rcm,
    'inv_typ' => 'R','itms'=>$itms
 
);
  
//print_r($inv);


} //gstvalue

$arrmerge1[]= array_merge(array('ctin' => $invvalue['gstin']),$inv);

$inv = array();
$itms = array();

} //invvalue


$data['b2b']=$arrmerge1;
$arrmerge1=array();
$finalmerge = array_merge(array('gstin'=>$compGstin,'fp'=>"'". $retmon,'version'=>"GST2.4.0",'hash'=>"hash"),$data);

echo json_encode($finalmerge,JSON_PRETTY_PRINT);
/*
$output = json_encode($finalmerge,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
  $outp = str_replace("'", "", $output);
  echo $outp;

*/

}

public function fetch_gstr9hsnsac()
{
  $compId = $this->session->userdata('id');
  $stype = $this->input->get('stype');
  $yr=$this->input->get('yr');
  $finyear = explode("-", $this->session->userdata('finyear'));
  $url= $this->config->item("api_url") . "/api/reports/getgstr9data";
  $data_post = array("type"=>$stype,"yr"=>$yr,"compId"=>$compId,"gtype"=>"HSNSAC");
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  
    $gstr9response = curl_exec($ch);
    //$result = json_decode($response);
   //echo $ledgerresponse;
  //var_dump($gstr1response);
  curl_close($ch); // Close the connection
  $gst1maindata = json_decode($gstr9response,true);
  echo $gstr9response;
  

}
public function gstr9b2bJson()
{

//  $flag = $this->input->get('flag');
  $stype = $this->input->get('stype');
  $compId = $this->session->userdata('id');
  $yr=$this->input->get('yr');
  $finyear = explode("-", $this->session->userdata('finyear'));
  $url= $this->config->item("api_url") . "/api/reports/getgstr9jsondata";
  $data_post = array("type"=>$stype,"yr"=>$yr,"compId"=>$compId,"gtype"=>$stype);
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  
    $gstr9jsonresponse = curl_exec($ch);
    //$result = json_decode($response);
   //echo $ledgerresponse;
  //var_dump($gstr1response);
  curl_close($ch); // Close the connection
  $gst1maindata = json_decode($gstr9jsonresponse,true);
  echo $gstr9jsonresponse;
  
 
  
}

public function fetch_gstr9b2b()
{
  $stype = $this->input->get('stype');
  $compId = $this->session->userdata('id');
  $yr=$this->input->get('yr');
  $finyear = explode("-", $this->session->userdata('finyear'));
  $url= $this->config->item("api_url") . "/api/reports/getgstr9data";
  $data_post = array("type"=>$stype,"yr"=>$yr,"compId"=>$compId,"gtype"=>$stype);
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  
    $gstr9response = curl_exec($ch);
    //$result = json_decode($response);
   //echo $ledgerresponse;
  //var_dump($gstr1response);
  curl_close($ch); // Close the connection
  $gst1maindata = json_decode($gstr9response,true);
  echo $gstr9response;
  
    
}


public function fetch_gstr1b2b()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}
if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0], 0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0], 0,2) .$finyear[1];
}

//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$url= $this->config->item("api_url") . "/api/reports/getgstr1data";
$data_post = array("type"=>"B2B","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gtype"=>"b2b");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;

}



public function fetch_gstr1cdnr()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}
if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0], 0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0], 0,2) .$finyear[1];
}

//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$url= $this->config->item("api_url") . "/api/reports/getgstr1data";
$data_post = array("type"=>"CDNR","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gtype"=>"cdnr");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;
}





public function fetch_gstr12hsnsac()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

$url= $this->config->item("api_url") . "/api/reports/getgstr1hsndata";
//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$data_post = array("type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;

}



public function fetch_gstr1b2c()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
$compId = $this->session->userdata('id');

}

//var_dump($fdate . $tdate . $compId);
$url= $this->config->item("api_url") . "/api/reports/getgstr1data";
//$url= $this->config->item("api_url") . "/api/getgstr1data.php";
$data_post = array("type"=>"B2C","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"gtype"=>"B2C");

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $gstr1response = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr1response);
curl_close($ch); // Close the connection
$gst1maindata = json_decode($gstr1response,true);
echo $gstr1response;

}


public function fetch_gstr3b5()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


  
/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3b5data";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3b5itcresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3b5itcresponse);
curl_close($ch); // Close the connection
$gsitcmaindata = json_decode($gstr3b5itcresponse,true);



if($gsitcmaindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3bitclistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Inter-state supplies</th>
                      <th>Intra-state supplies</th>
                  </tr>
                  </thead>
                  <tbody>';


$tbl .= '<tr><td style="text-align:right;">'.  $gsitcmaindata['intra_zero']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['inter_zero']  .'</td></tr>';


echo $tbl;
}  
}



public function fetch_gstr34b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;


//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3bdata";
//$data = array("trans_type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);

//$url= $this->config->item("api_url") . "/api/reports/getgstr34bdata.php";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3bitcresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3bitcresponse);
curl_close($ch); // Close the connection
$gsitcmaindata = json_decode($gstr3bitcresponse,true);



if($gsitcmaindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3bitclistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Details</th>
                      <th>Integrated Tax</th>
                      <th>Central Tax</th>
                      <th>State/UT Tax</th>
                      <th>Cess</th>
                  </tr>
                  </thead>
                  <tbody>';

$tbl .= '<tr><td style="font-weight:bold;">(A) ITC Available (whether in full or part)</td><td colspan="4"></td></tr>';

$tbl .= '<tr><td>(1) Import of goods</td><td></td><td></td><td></td><td></td></tr>';

$tbl .= '<tr><td>(2) Import of services</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(3) Inward supplies liable to reverse charge(other than1 & 2 above)</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(4) Inward supplies from ISD</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(5) All other ITC</td><td style="text-align:right;">'.  $gsitcmaindata['igst_amt']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['cgst_amt']  .'</td><td style="text-align:right;">'.  $gsitcmaindata['sgst_amt']  .'</td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(B) ITC Reversed</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(1) As per Rule 42 & 43 of CGST/SGST rules</td><td></td><td></td><td></td><td></td></tr>';

$tbl .= '<tr><td>(2) Others</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(C) Net ITC Available (A)-(B)</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['igst_amt']  .'</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['cgst_amt']  .'</td><td style="font-weight:bold;text-align:right;">'.  $gsitcmaindata['sgst_amt']  .'</td><td></td></tr>';


$tbl .= '<tr><td style="font-weight:bold;">(D) Ineligible ITC</td><td></td><td></td><td></td><td></td></tr>';



$tbl .= '<tr><td>(1) As per Rule 17(5)</td><td></td><td></td><td></td><td></td></tr>';


$tbl .= '<tr><td>(2) Others</td><td></td><td></td><td></td><td></td></tr>';

echo $tbl;
}
}



public function fetch_gstr32b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}



/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');
$cstatecode = $this->session->userdata('cstatecode');
$url= $this->config->item("api_url") . "/api/reports/getgstr32bdata";
//$url= $this->config->item("api_url") . "/api/getgstr32bdata.php";
$data = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"cstatecode"=>$cstatecode);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr32bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr32bresponse);
curl_close($ch); // Close the connection
$gs32maindata = json_decode($gstr32bresponse,true);
if($gs32maindata)
{


  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr32blistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Plase of Supply(State/UT)</th>
                      <th>Total Taxable value</th>
                      <th>Amount Integrated Tax</th>
                  </tr>
                  </thead>
                  <tbody>';
foreach ($gs32maindata as $key => $gvalue) {
  # code...
$tbl .='<tr><td style="text-align:left;">'. $gvalue["statecode"] .'</td><td style="text-align:right;">'. $gvalue['txbamt'] .'</td><td style="text-align:right;">'. $gvalue['igstamt'] .'</td></tr>';
}

echo $tbl;
}
}

public function fetch_gstr2b()
{
$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}
if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));*/
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getGstr2B";
$data = array("trans_type"=>"PURC","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr2bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr2bresponse);
curl_close($ch); // Close the connection
$main2bdata = json_decode($gstr2bresponse,true);
echo json_encode($main2bdata);
}


public function fetch_gstr3b()
{

$flag = $this->input->get('flag');
$fdate=$this->input->get('fdate');

if($flag=="M")
{
$fdt="01-" . $this->input->get('fdate');

$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt));
$compId = $this->session->userdata('id');
//var_dump($fdate . $tdate);
}

if($flag=="Q")
{
$dt=$this->input->get('fdate');
$finyear = explode("-", $this->session->userdata('finyear'));
$exp_mn=explode("-", $this->input->get('fdate')); 

if($dt=="04-06")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="07-09")
{
$fdt ="01-" . $exp_mn[0] . "-". $finyear[0];
$edt = "01-" . $exp_mn[1] . "-". $finyear[0];
}
if($dt=="10-12")
{
$fdt ="01-" . $exp_mn[0] . "-" . $finyear[0];
$edt = "01-" . $exp_mn[1] . "-" . $finyear[0];
}

if($dt=="01-03")
{
$nyear = intval($finyear[0] + 1); 
$fdt ="01-" . $exp_mn[0] . "-". $nyear;
$edt = "01-" . $exp_mn[1] . "-". $nyear;

//$fdt ="01-" . $exp_mn[0] . "-". substr($finyear[0],0,2) . $finyear[1];
//$edt = "01-" . $exp_mn[1] . "-". substr($finyear[0],0,2) . $finyear[1];
}
//var_dump($fdt . $edt);
//$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($edt));
//var_dump($fdt);
}


/*
$fdt="01-" . $this->input->get('fdate');
$fdate = date("Y-m-d",strtotime($fdt));
$tdate = date("Y-m-t",strtotime($fdt)); */
$compId = $this->session->userdata('id');

$url= $this->config->item("api_url") . "/api/reports/getgstr3bdata";
$data = array("trans_type"=>"SALE","fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $gstr3bresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($gstr3bresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($gstr3bresponse,true);




  $tbl='';
  $tbl ='<table class="table table-bordered" id="gstr3blistTable" width="100%" cellspacing="0">

                  <thead>
                    <tr>
                      
                      <th>Nature of Supplies</th>
                      <th>Total Taxable value</th>
                      <th>Integrated Tax</th>
                      <th>Central Tax</th>
                      <th>State/UT Tax</th>
                      <th>Cess</th>
                      

                    </tr>
                  </thead>
                  <tbody>';
  $tbl .='<tr><td>(a) Outward taxable supplies (other than zero rated, nil rated and exempted)</td><td style="text-align:right;">'. $maindata['txbgst'] .'</td><td style="text-align:right;">'. $maindata['igst_amt'] .'</td><td style="text-align:right;">'. $maindata['cgst_amt'] .'</td><td style="text-align:right;">'. $maindata['sgst_amt'] .'</td><td style="text-align:right;"></td></tr>';
$tbl .='<tr><td>(b) Outward taxable supplies (zero rated)</td><td style="text-align:right;">'. $maindata['zerorate'] .'</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';

$tbl .='<tr><td>(c) Other outward supplies (Nil rated, exempted)</td><td style="text-align:right;">'. $maindata['zerogst'] .'<t/d><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';


$tbl .='<tr><td>(d) Inward supplies (liable to reverse charge)</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';


$tbl .='<tr><td>(d) Non-GST outward supplies</td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td><td style="text-align:right;"></td></tr>';

$tbl .='</tbody></table>';
echo $tbl;

}


// Ledger Report Print

public function print_ledgerlist()
{
// Incluimos la librerias necesarias
//require_once "dompdf/autoload.inc.php";
//require_once "dompdf/lib/html5lib/Parser.php";
//require_once "dompdf/lib/php-font-lib/src/FontLib/Autoloader.php";
//require_once "dompdf/lib/php-svg-lib/src/autoload.php";
//require_once "dompdf/src/Autoloader.php";
//require_once "dompdf/src/FontMetrics.php";
//Dompdf\Autoloader::register();

// Reference the Dompdf namespace

//$options = new Options();
//$options->set('defaultFont', 'Calibri');	
	$c_balance=0.00;
	$data=array();    
	$actid = $this->input->get('ldgacc');
	$fdate = $this->input->get('fdate');
	$tdate = $this->input->get('tdate');
	$ldg_name=$this->input->get('ldgname');
	$compId = $this->session->userdata('id');
	$s_date = $this->session->userdata('startdate');
	$e_date = $this->session->userdata('enddate');
	$finyear = $this->session->userdata('finyear');
	$trans_type="CNTR";
	$f_date=date_create($fdate);
	$fr_date= date_format($f_date,"d-m-Y");
	
	$t_date=date_create($tdate);
	$to_date= date_format($t_date,"d-m-Y");
	//printf("date : " . $fdate . $tdate);
	//var_dump($compId . $finyear); 
	//$your_admin_variable =$this->config->item("admin_url");
	//$url=$this->config->item("api_url") . "/api/getalltransaction.php";
	
	
	
	$url= $this->config->item("api_url") . "/api/reports/glreportop";
	$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
	//var_dump($data);
	//$post = ['batch_id'=> "2"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	
		$ledgeropresponse = curl_exec($ch);
		//$result = json_decode($response);
	 //echo $ledgerresponse;
	//var_dump($ledgeropresponse);
	curl_close($ch); // Close the connection
	$maindataop = json_decode($ledgeropresponse,true);
	//var_dump($maindata);
	$data=array();
	$db_amount=0.00;
	$cr_amount=0.00;
	$cl_balance=0.00;
	$name="";
	if($maindataop)
	{
		$c_balance = $maindataop[0]['opbal'];
	//	var_dump($c_balance);
	$opbal = "<div><b><h5>Opening Balance :" . number_format($maindataop[0]['opbal'],'2') ."</h5></b></div>";
	//$data['data'][]=array("trans_id"=>"No Data","trans_date"=>"","trans_ref"=>"","trans_type"=>"", "particulars"=>"","db_amount"=>"","cr_amount"=>"","cl_balance"=>"","op_balance"=>$opbal);
	}
	else
	{
		$c_balance=0;
	//	$opbal=0;
	$op=0;
		$opbal = "<div><b><h5>Opening Balance :" . number_format($op,'2') ."</h5></b></div>";
	
	//  $data['data'][]=array("op_balance"=>$opbal);
	}
	//var_dump($opbal);
	
	$url= $this->config->item("api_url") . "/api/reports/glTrans";
	$data_post = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
	//var_dump($data);
	//$post = ['batch_id'=> "2"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
	
		$ledgerresponse = curl_exec($ch);
		//var_dump($ledgerresponse);
		curl_close($ch); // Close the connection
		$maindata = json_decode($ledgerresponse,true);
		
	
		if($maindata)
		{
		
	//var_dump($opbal);
	foreach ($maindata as $key => $d) 
	{
	
	//var_dump($d);
	
	
	$date=date_create($d['trans_date']);
	$trans_date= date_format($date,"d-m-Y");
	
	if($d['trans_type']=="RCPT")
	{
	
	$db_amount=0;
	$cr_amount=$d['trans_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;    
	$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	}
	if($d['trans_type']=="PYMT")
	{
	
	$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
	$cr_amount=0;
	$db_amount=$d['trans_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;    
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$d['trans_amount'],"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
	}
	
	
	
	if($d['trans_type']=="PURC")
	{
	//var_dump($d['cr_account']);
	//$cr_amount=0;
	$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
	$db_amount=0;
	$cr_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
	}
	
	if($d['trans_type']=="SRTN")
	{
	//var_dump($d['cr_account']);
	//$cr_amount=0;
	$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
	$db_amount=0;
	$cr_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
	}
	
	
	
	if($d['trans_type']=="JRNL")
	{
		
	//var_dump($d['cr_account']);
	//$cr_amount=0;
	if($actid==$d['cr_account'])
	{
	$name=$this->getledgerdatasearchbyid($d['db_account']) ;//. "<br>" . $d['trans_narration'];
	$db_amount=0;
	$cr_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	}
	else
	{
	$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
	$cr_amount=0;
	$db_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
	}
	}
	
	if($d['trans_type']=="SALE")
	{
	$cr_amount=0;
	$db_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$name=$this->getledgerdatasearchbyid($d['cr_account']);// . "<br>" . $d['trans_narration'];
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	}
	
	if($d['trans_type']=="PRTN")
	{
	$cr_amount=0;
	$db_amount=$d['net_amount'];
	$c_balance =$c_balance+$db_amount-$cr_amount;
	$name=$this->getledgerdatasearchbyid($d['cr_account']);// . "<br>" . $d['trans_narration'];
	$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	}
	
	
	$db_amount=0;
	$cr_amount=0;
	
	
	
	}
		}
	else
	{
		$data['data'][]=array("trans_id"=>"Balance C/f","trans_date"=>"","trans_ref"=>"","trans_type"=>"", "particulars"=>"","db_amount"=>"","cr_amount"=>"","cl_balance"=>$c_balance,"op_balance"=>$opbal);
		
	}
	//var_dump($data);
	//var_dump($opbal);
	//$tbl .='</tbody></table>';
	//$result = array_merge($opbal,$data);
//	echo json_encode($data);
$this->load->library('pdf');
//	$html = $this->load->view('samplepdf', [], true);
//	$this->pdf->createPDF($html, 'mypdf', false);
$data['page'] = 'Ledger Account';
$data['ldgname'] = $ldg_name;
$data['fdate'] = $fr_date;
$data['tdate'] = $to_date;
$this->load->view('pdf_ledger',$data);

$html = $this->output->get_output();
$this->load->library('pdf');
$this->dompdf->loadHtml($html);
$this->dompdf->setPaper('A4', 'portrait');
$this->dompdf->render();
$canvas = $this->dompdf->get_canvas();
//$font = $fontMetrics->getFont("helvetica", "bold");
//$font = Font_Metrics::get_font("helvetica", "bold");
$canvas->page_text(510, 108, "Page: {PAGE_NUM} of {PAGE_COUNT}", '', 10, array(0,0,0));

$this->dompdf->stream("ledger_" . strtolower($ldg_name) . ".pdf", array("Attachment"=>1));





}




// Ledger Report
public function getledgerlist()
{
$c_balance=0.00;
$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$s_date = $this->session->userdata('startdate');
$e_date = $this->session->userdata('enddate');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
//$your_admin_variable =$this->config->item("admin_url");
//$url=$this->config->item("api_url") . "/api/getalltransaction.php";



$url= $this->config->item("api_url") . "/api/reports/glreportop";
$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
//var_dump($data);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $ledgeropresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($ledgeropresponse);
curl_close($ch); // Close the connection
$maindataop = json_decode($ledgeropresponse,true);
//var_dump($maindata);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;
$cl_balance=0.00;
$name="";
if($maindataop)
{
	$c_balance = $maindataop[0]['opbal'];
//	var_dump($c_balance);
$opbal = "<div><b><h5>Opening Balance :" . number_format($maindataop[0]['opbal'],'2') ."</h5></b></div>";
//$data['data'][]=array("trans_id"=>"No Data","trans_date"=>"","trans_ref"=>"","trans_type"=>"", "particulars"=>"","db_amount"=>"","cr_amount"=>"","cl_balance"=>"","op_balance"=>$opbal);
}
else
{
	$c_balance=0;
//	$opbal=0;
$op=0;
	$opbal = "<div><b><h5>Opening Balance :" . number_format($op,'2') ."</h5></b></div>";

//  $data['data'][]=array("op_balance"=>$opbal);
}
//var_dump($opbal);

$url= $this->config->item("api_url") . "/api/reports/glTrans";
$data_post = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
//var_dump($data);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));

  $ledgerresponse = curl_exec($ch);
	//var_dump($ledgerresponse);
	curl_close($ch); // Close the connection
	$maindata = json_decode($ledgerresponse,true);
	

	if($maindata)
	{
	
//var_dump($opbal);
foreach ($maindata as $key => $d) 
{

//var_dump($d);


$date=date_create($d['trans_date']);
$trans_date= date_format($date,"d-m-Y");

if($d['trans_type']=="RCPT")
{

$db_amount=0;
$cr_amount=$d['trans_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;    
$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}
if($d['trans_type']=="PYMT")
{

$name=$this->getledgerdatasearchbyid($d['db_account']);// . "<br>" . $d['trans_narration'];
$cr_amount=0;
$db_amount=$d['trans_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;    
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$d['trans_amount'],"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}



if($d['trans_type']=="PURC")
{
//var_dump($d['cr_account']);
//$cr_amount=0;
$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
$db_amount=0;
$cr_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}

if($d['trans_type']=="SRTN")
{
//var_dump($d['cr_account']);
//$cr_amount=0;
$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
$db_amount=0;
$cr_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}



if($d['trans_type']=="JRNL")
{
  
//var_dump($d['cr_account']);
//$cr_amount=0;
if($actid==$d['cr_account'])
{
$name=$this->getledgerdatasearchbyid($d['db_account']) ;//. "<br>" . $d['trans_narration'];
$db_amount=0;
$cr_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}
else
{
$name=$this->getledgerdatasearchbyid($d['cr_account']) ;//. "<br>" . $d['trans_narration'];
$cr_amount=0;
$db_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);

}
}

if($d['trans_type']=="SALE")
{
$cr_amount=0;
$db_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$name=$this->getledgerdatasearchbyid($d['cr_account']);// . "<br>" . $d['trans_narration'];
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}

if($d['trans_type']=="PRTN")
{
$cr_amount=0;
$db_amount=$d['net_amount'];
$c_balance =$c_balance+$db_amount-$cr_amount;
$name=$this->getledgerdatasearchbyid($d['cr_account']);// . "<br>" . $d['trans_narration'];
$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
}


$db_amount=0;
$cr_amount=0;



}
	}
else
{
	$data['data'][]=array("trans_id"=>"Balance C/f","trans_date"=>"","trans_ref"=>"","trans_type"=>"", "particulars"=>"","db_amount"=>"","cr_amount"=>"","cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
}

//var_dump($opbal);
//$tbl .='</tbody></table>';
//$result = array_merge($opbal,$data);
echo json_encode($data);

}


//Cash/Bank Book Printing
public function printCashBank()
{
$db_tot=0.00;
$cr_tot=0.00;
$cl_tot=0.00;
$cl_balance=0.00;  

$rw=1;
$pg=1;
$pglines=22;

$compId = $this->session->userdata('id'); 
$tbl="";

//$url = $this->config->item("api_url") . "/api/companydetails.php?id=" . $compId;
$url = $this->config->item("api_url") . "/api/company/" . $compId;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
$cresult = curl_exec($ch);
curl_close($ch);

            //-- if valid
//var_dump($cresult);
//var w = window.open(url+'?acctid='+actid+'&fdate='+fdate+'&tdate='+tdate

$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$acname = $this->input->get('acname');

if($cresult){

$data = array();

$phpArray = json_decode($cresult, true);

                   $heading_data = array(
                        'cname' =>  $phpArray['company_name'],
                        'cadd' =>  $phpArray['company_address'],
                        'email' =>  $phpArray['company_email'],
                        'cstatecode' =>  $phpArray['company_statecode'],
                        'city' =>  $phpArray['company_city'],
                        'pincode' =>  $phpArray['company_pincode'],
                        'gstin' =>  $phpArray['company_gstin'],
                        'contact' =>  $phpArray['company_contact'],
                        'cbankdetails' =>  $phpArray['company_bankdetails'],
                        'acname' => $acname,'fdate'=>$fdate,'tdate'=>$tdate); 

}


$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/reports/cashbankreport";

//$url=$this->config->item("api_url") . "/api/getcashbankbook.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cashbankresponse = curl_exec($ch);
  //$result = json_decode($response);
// echo $cashbankresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($cashbankresponse,true);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;


$cl_balance=0.00;
$name="";
$c_balance = $maindata[0]['opbal'];
$cl_balance = $maindata[0]['opbal'];
$opbal = "<div><b><h5>Opening Balance :" . number_format($maindata[0]['opbal'],'2') ."</h5></b></div>";






foreach ($maindata as $key => $d) 
{
    
//$db_name=$this->getledgerdatasearchbyid($d['db_account']);
//$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);


if($d['trans_type']=="RCPT")
{

$cr_amount=0;
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_account=0;
$db_amount=$d['trans_amount'];
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$cl_balance = $cl_balance+$db_amount-$cr_amount;
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$cr_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);

}


if($d['trans_type']=="PYMT")
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);
}




if($d['trans_type']=="CNTR" && $d['cr_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['db_account']) . "<br>" . $d['trans_narration'];
$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);
}


else if($d['trans_type']=="CNTR" && $d['db_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_amount=0;
$db_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}
$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];

$data[]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance);

}
$db_amount=0;
$cr_amount=0;

}


 $this->cb_head($heading_data);

//for ($i=1; $i <=count($data) ; $i++) { 
  # code...

//$tbl .= $i;
//$tbl .='<tr>';
ECHO '<tr><td colspan="6" style="margin-top:10px; font-weight:bold;font-size:18;">Opening Balance</td><td style="font-weight:bold;font-size:18;text-align:right;">'. number_format( floatval($c_balance),'2') .'</td></tr>';

foreach ($data as $key => $value) {
  # code...
if($value["db_amount"]>0)
{
  $dbamt=$value["db_amount"];
}
else
{
  $dbamt="";
}

if($value["cr_amount"]>0)
{
  $cramt=$value["cr_amount"];
}
else
{
  $cramt="";
}

ECHO '<tr><td>'. date('d-m-yy',strtotime($value["trans_date"])).'</td><td>'. $value["trans_id"].'</td><td>'. $value["trans_ref"].'</td><td>'. $value["particulars"] .'</td><td style="text-align:right">'. $dbamt .'</td><td style="text-align:right">'. $cramt .'</td><td style="text-align:right">'. number_format( floatval($value["cl_balance"]),'2').'</td></tr>' ;


$db_tot=$db_tot+floatval($value["db_amount"]);
$cr_tot=$cr_tot+floatval($value["cr_amount"]);
$cl_tot=floatval($value["cl_balance"]);
/*

if($i==48)
{

$tbl.='<div style="text-align:center"><h5>'. $heading_data["cadd"] .'</h5></div>';

}


if($i<=48)
{
  $remain_rw = 48-$i;
  for ($rw=0; $rw <$remain_rw ; $rw++) { 
    # code...
    $tbl .= '<br/>';
  }
$tbl.='<div class="footer" style="text-align:center"><h5>'. $heading_data["cadd"] .'</h5></div>';

}
*/

if($rw==$pglines) 
{
$rw=1;
    $r=1;
    $pg=$pg+1;
ECHO '<div class="pagebreak"></div>';
    ECHO  '</table>';
    ECHO  '<br>';
    ECHO  '<div class="pull-right" align="right"> Contd./-</div>';
ECHO  '<div class="breakAfter"></div>';

ECHO '<div style="text-align:center"><h3>'. $heading_data["cname"] .'</h3></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["cadd"] .'</h6></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["contact"] .' | ' . $heading_data["email"] . '</h6></div>';

ECHO '<div style="text-align:center;margin-top:-15px;"><h5>'. $heading_data["acname"].'  BOOK FOR THE PERIOD ( '. date("d-m-yy", strtotime($heading_data["fdate"])) .' to '. date("d-m-yy", strtotime($heading_data["tdate"])) .' )</h5></div>';
ECHO '<div style="float:right;" class="pull-right">Page No : '. $pg . '</div>';


ECHO '<table class="table" width="100%"><tr>
<th style="text-align:left;border-left:none;">DATE</th>
<th style="text-align:left;border-left:none;">TRANS #</th>
<th style="text-align:left;border-left:none;">REFERENCE</th>
<th style="text-align:left;border-left:none;">PARTICULARS</th>
<th style="text-align:right;border-left:none;">DEBIT</th>
<th style="text-align:right;border-left:none;">CREDIT</th>
<th style="text-align:right;border-left:none;">BALANCE</th></tr>';


}
$rw++;


}

//ECHO '</table><br><table class="table" width="100%">';

ECHO '<tr height=50px;><td></td><td></td><td></td><td><strong>CLOSING BALANCE</strong></td><td style="text-align:right;"><strong>'. number_format($db_tot,'2') .'</strong></td><td style="text-align:right;"><strong>'.  number_format($cr_tot,'2') .'</strong></td><td style="text-align:right;"><strong>'.  number_format($cl_tot,'2') .'</strong></td></tr>';

//$tbl .='</table>';  
ECHO '</table>';

echo $tbl;







}


function cb_head($heading_data)
{
$tbl="";
$pg=1;
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/cashbook.css">';

ECHO '<div style="text-align:center"><h3>'. $heading_data["cname"] .'</h3></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["cadd"] .'</h6></div>';
ECHO '<div class="footer" style="text-align:center;margin-top:-15px;"><h6>'. $heading_data["contact"] .' | ' . $heading_data["email"] . '</h6></div>';

ECHO '<div style="text-align:center;margin-top:-10px;"><h5>'. $heading_data["acname"].'  BOOK FOR THE PERIOD ( '. date("d-m-yy", strtotime($heading_data["fdate"])) .' to '. date("d-m-yy", strtotime($heading_data["tdate"])) .' )</h5></div>';

ECHO '<div style="float:right;" class="pull-right">Page No : '. $pg . '</div>';


ECHO '<table class="table" width="100%"><tr>
<th style="text-align:left;border-top;">DATE</th>
<th style="text-align:left">TRANS #</th>
<th style="text-align:left">REFERENCE</th>
<th style="text-align:left">PARTICULARS</th>
<th style="text-align:right">DEBIT</th>
<th style="text-align:right">CREDIT</th>
<th style="text-align:right">BALANCE</th></tr>';
}



//Cash Bank Report

public function getcashbanklist()
{
$cl_balance=0.00;
$data=array();    
$actid = $this->input->get('acctid');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="CNTR";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/reports/cashbankreport";
$data = array("finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $cashbankresponse = curl_exec($ch);
  //$result = json_decode($response);
// echo $cashbankresponse;
//var_dump($cashbankresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($cashbankresponse,true);
//var_dump($maindata);
$data=array();
$db_amount=0.00;
$cr_amount=0.00;
$cl_balance=0.00;
$name="";
if($maindata)
{
$cl_balance = $maindata[0]['opbal'];
if(is_null($cl_balance))
{
  $cl_balance=0;
}




$opbal = "<div><b><h5>Opening Balance :" . number_format($cl_balance,'2') ."</h5></b></div>";


foreach ($maindata as $key => $d) 
{
    
//$db_name=$this->getledgerdatasearchbyid($d['db_account']);
//$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);


if($d['trans_type']=="RCPT")
{

$cr_amount=0;
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_account=0;
$db_amount=$d['trans_amount'];
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$cl_balance = $cl_balance+$db_amount-$cr_amount;
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$cr_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);

}


if($d['trans_type']=="PYMT")
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}




if($d['trans_type']=="CNTR" && $d['cr_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$db_amount=0;
$cr_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['db_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}


else if($d['trans_type']=="CNTR" && $d['db_account']==$actid)
{

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";
$cr_amount=0;
$db_amount=$d['trans_amount'];
$cl_balance = $cl_balance+$db_amount-$cr_amount;
if($db_amount!=0)
{
  $db_amt = $db_amount;
}
else
{
  $db_amt ="";
}

if($cr_amount!=0)
{
  $cr_amt = $cr_amount;
}
else
{
  $cr_amt ="";
}

$db_name=$this->getledgerdatasearchbyid($d['cr_account']) . "<br>" . $d['trans_narration'];
$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"trans_ref"=>$d['trans_reference'],"particulars"=>$db_name,"db_amount"=>$db_amt,"cr_amount"=>$cr_amt,"cl_balance"=>$cl_balance,"op_balance"=>$opbal);
}


$db_amount=0;
$cr_amount=0;

}

}
//$tbl .='</tbody></table>';
//$result = array_merge($data,array("cl_balance"=>$cl_balance));
echo json_encode($data);

}



public function getallreceiptlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptresponse = curl_exec($ch);
  //$result = json_decode($response);
 $receiptresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($receiptresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#deleteModal' onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);

}


public function getallpaymentlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallreceiptspayments.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptresponse = curl_exec($ch);
  //$result = json_decode($response);
 $receiptresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($receiptresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
    
$db_name=$this->getledgerdatasearchbyid($d['db_account']);
$cr_name=$this->getledgerdatasearchbyid($d['cr_account']);
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditReceipt'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block'   href='#' data-toggle='modal' data-target='#deleteModal'  onclick='deleteTransid(". $d["id"]. ")'><i class='fa fa-times'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"db_name"=>$db_name,"cr_name"=>$cr_name,"trans_amount"=>$d['trans_amount'],"trans_ref"=>$d['trans_reference'],"narration"=>$d['trans_narration']);

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
$url=$this->config->item("api_url") . "/api/delete_transactionbyid.php";
$data_array=array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $delresponse = curl_exec($ch);
 curl_close($ch); // Close the connection
 echo $delresponse;
}



public function createContra()
{
$contrano = $this->input->post('contrano');
$contradate=$this->input->post('contradate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $cprefix = $settArr->contra_prefix;
    $csuffix = $settArr->contra_suffix;
    $c_no = $settArr->contra_no;
    $cnv_numtype = $settArr->inv_numtype;
    $cnv_leadingzero = $settArr->leading_zero;

if($cnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_cno = sprintf("%0". $cnv_leadingzero ."d", $c_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$cntr_no = $cprefix . $_cno . $csuffix;
$next_cntrno = $c_no+1;
}
else
{
    $_pno= $p_no;
    $cntr_no = $cprefix . $_cno . $csuffix;
    $next_cntrno = $c_no+1;
}


}

$data_post=array(
"trans_id"=>$cntr_no,
"trans_date"=>$contradate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"CNTR",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);

$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$contratArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($contraArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_cntrno,"trans_type"=>"CNTR");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}





public function createPayment()
{
$paymentno = $this->input->post('paymentno');
$paymentdate=$this->input->post('paymentdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $pprefix = $settArr->payment_prefix;
    $psuffix = $settArr->payment_suffix;
    $p_no = $settArr->payment_no;
    $pnv_numtype = $settArr->inv_numtype;
    $pnv_leadingzero = $settArr->leading_zero;

if($pnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_pno = sprintf("%0". $pnv_leadingzero ."d", $p_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$pyt_no = $pprefix . $_pno . $psuffix;
$next_pytno = $p_no+1;
}
else
{
    $_pno= $p_no;
    $pyt_no = $pprefix . $_pno . $psuffix;
    $next_pytno = $p_no+1;
}


}

$data_post=array(
"trans_id"=>$pyt_no,
"trans_date"=>$paymentdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"PYMT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($paymentArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_pytno,"trans_type"=>"PYMT");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}


public function createReceipt()
{
$receiptno = $this->input->post('receiptno');
$receiptdate=$this->input->post('receiptdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}



$url=$this->config->item("api_url") . "/api/getsettings.php";

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $rprefix = $settArr->receipt_prefix;
    $rsuffix = $settArr->receipt_suffix;
    $r_no = $settArr->receipt_no;
    $rnv_numtype = $settArr->inv_numtype;
    $rnv_leadingzero = $settArr->leading_zero;

if($rnv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_rno = sprintf("%0". $rnv_leadingzero ."d", $r_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$rct_no = $rprefix . $_rno . $rsuffix;
$next_rctno = $r_no+1;
}
else
{
    $_rno= $r_no;
    $rct_no = $rprefix . $_rno . $rsuffix;
    $next_rctno = $r_no+1;
}


}

$data_post=array(
"trans_id"=>$rct_no,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/insert_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;


//$id=$res['last_ins_id'];


if($receiptArray['success']=true)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_rctno,"trans_type"=>"RCPT");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}

}




public function getPaymentbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PYMT";
$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $paymentbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($paymentbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editpayment" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Payment#<input type="text" class="form-control" autocomplete="off"  id="paymentno" name="paymentno" value="'.$value["trans_id"].'" readonly></td><td>Payment Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="paymentdate" name="paymentdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
</table>
';


}



echo $tbl;
}


function editPayment()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$paymentno = $this->input->post('paymentno');
$paymentdate=$this->input->post('paymentdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $cr_account=$lvalue['id'];
}


$data_post=array(
"id" => $id,
"trans_date"=>$paymentdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"PYMT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/update_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}

public function getallsaleslist()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type=$this->input->get('trans_type');
$fdate = $this->input->get('fdate');
$tdate = $this->input->get('tdate');

$url= $this->config->item("api_url") . "/api/reports/spreport";
$data = array("fdate"=>$fdate,"tdate"=>$tdate,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//var_dump($data);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $ledgerresponse = curl_exec($ch);
  //$result = json_decode($response);
 //echo $ledgerresponse;
//var_dump($ledgerresponse);
curl_close($ch); // Close the connection
//$maindata = json_decode($ledgerresponse,true);

echo json_encode($ledgerresponse);

}


public function getallSalesPurchaselist()
{

$trans_type=$this->input->get('trans_type');
$fdate=$this->input->get('fdate');
$tdate=$this->input->get('tdate');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type,"fdate"=>$fdate,"tdate"=>$tdate);
var_dump($data);

$url=$this->config->item("api_url") . "/api/transaction/pursalreg/" . $trans_type . "/" . $finyear . "/" . $compId . "/" . $fdate . "/" . $tdate ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);

$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='printTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button></div>";

$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);


}



public function getReceiptbyid()
{

$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="RCPT";
$url=$this->config->item("api_url") . "/api/getreceiptpaymentbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $receiptbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($receiptbyidresponse,true);
$tbl="";
//var_dump($obj);


foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->name;
//var_dump($value);

$db_name=$this->getledgerdatasearchbyid($value['db_account']);
$cr_name=$this->getledgerdatasearchbyid($value['cr_account']);


$tbl .='<table id="editreceipt" class="table table-bordered">
<tr><td><input type="text" id="recid" name="recid" value="' . $value["id"] . '" hidden >Receipt#<input type="text" class="form-control" autocomplete="off"  id="receiptno" name="receiptno" value="'.$value["trans_id"].'" readonly></td><td>Receipt Date<input type="date" class="form-control" value="'.$value["trans_date"].'"  autocomplete="off"  id="receiptdate" name="receiptdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" value="'. $db_name .'"  name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off" value="'.$cr_name .'"   id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" id="trans_amount" value="'.$value["trans_amount"].'"  name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off" value="'.$value["trans_reference"].'"   id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" value="'.$value["trans_narration"].'"  autocomplete="off"  id="narration" name="narration"></td></tr>
</table>';


}



echo $tbl;
}


function editReceipt()
{
 //Update Payment voucher
$id = $this->input->post('recid');    
$receiptno = $this->input->post('receiptno');
$receiptdate=$this->input->post('receiptdate');
$dbaccount=$this->input->post('dbaccount');
$craccount=$this->input->post('craccount');
$trans_amount=$this->input->post('trans_amount');
$transref = $this->input->post('transref');
$narration=$this->input->post('narration');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');


$ldgarray = $this->getledgerdatasearchbyname($dbaccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $db_account=$lvalue['id'];
}



$ldgarray = $this->getledgerdatasearchbyname($craccount);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $cr_account=$lvalue['id'];
}


$data_post=array(
"id" => $id,
"trans_date"=>$receiptdate,
"db_account"=>$db_account,
"cr_account"=>$cr_account,
"trans_amount"=>$trans_amount,
"trans_type"=>"RCPT",
"transref"=>$transref,
"narration"=>$narration,
"compId"=>$compId,
"finyear"=>$finyear);



$url=$this->config->item("api_url") . "/api/update_receiptpayment.php";


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$receiptArray = json_decode($response, true);

echo $response;



}


function getledgerdata()
{
	$compId = $this->session->userdata('id');

$url=$this->config->item("api_url") . "/api/productlist/ledgerbycid";
//$post = ['batch_id'=> "2"];

$post=array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

//echo $response;


//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
if($ldgerArray)
{
foreach ($ldgerArray as $key => $value) {
if($value['account_groupid']!=1)
{
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';
}

}
$option .= '<option selected  disabled value="0">Select an Account</option>';
echo $option;

}

}



function getcashbankledgerdata()
{

$url=$this->config->item("api_url") . "/api/reports/getcashbankledger";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');

$post=array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
	//var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);
//var_dump($response);
//echo $response;


//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($ldgerArray as $key => $value) {
    
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';

}
$option .= '<option selected  disabled value="0">Select an Account</option>';
echo $option;



}


function getledgerdatabyname()
{
$itemkeyword = $this->input->get('itemkeyword');    
$url=$this->config->item("api_url") . "/api/getledgerbyid.php";
//$post = ['batch_id'=> "2"];
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$post=array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;

}


function getledgerdatasearchbyid($actid)
{
$data_array=array();


//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("id"=>$actid,"compId"=>$compId);
//$id = $this->input->get('id');    

//$url=$this->config->item("api_url") . "/api/reports/lbyid";
$url=$this->config->item("api_url") . "/api/productlist/ledgerbyidbycid";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);
 //var_dump($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
if($ldgerArray)
{
	return $ldgerArray[0]['account_name'];

}
//return $ldgerArray;
//var_dump($ldgerArray);
/*foreach ($ldgerArray as $key => $value) {
    # code...
 
 return $value['name'];
 
} */

}


function __olgetledgerdatasearchbyid($actid)
{
$data_array=array();


//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("actid"=>$actid,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/getledgerbyactid.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($response);
  curl_close($ch); // Close the connection
$lArray = json_decode($response,true);
$item_data=array();
//return $ldgerArray;
//var_dump($ldgerArray);
foreach ($lArray as $value) {
    # code...
 //var_dump($value);
 return $value['name'];
 
}

}



function getledgerdatasearchbyname($name)
{
$data_array=array();

$itemkeyword= $name; 
//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/getledgerbykeyword.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
 //var_dump($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
return $ldgerArray;

}



}


