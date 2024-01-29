<html>
    <head>
	<link href="<?php base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 

  <!-- Custom styles for this page -->
  <link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php base_url();?>assets/css/select2.min.css" rel="stylesheet" type="text/css" />


        <style>
            /** Define the margins of your page **/
            @page {
                margin: 20px 25px;
            }
			table{ border-spacing: 0; }
            header {
                position: fixed;
                top: 10px;
                left: 0px;
                right: 0px;
                height: -15px;

                /** Extra personal styles **/
             /*   background-color: #03a9f4; 
                color: white; */
                text-align: center;
                line-height: 33px;
            }

            footer {
                position: fixed; 
                bottom: 20px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **
                background-color: #03a9f4; 
                color: white; */
                text-align: center;
                line-height: 35px;
            }

			main {
				margin-top:110px;
			}

        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
		<div style="float:left"><img width="50px" height="50px" src="<?php echo base_url('assets/images/atk_logo.png'); ?>"></div>
	<div style="float:right"><img width="50px" height="50px" src="<?php echo base_url('assets/images/atk_gpayqr.jpg'); ?>"></div>
		<div><h1 style="text-align:center;font-size:18px;font-weight:bold;margin-top:-10px;margin-bottom:10px;">ATK ENTERPRISES</h1><p  style="text-align:center;font-size:11px;margin-top:-20px;">1/54 GAJAPATHY STREET | SHENOY NAGAR | CHENNAI 600 030</p><p style="text-align:center;font-size:10px;margin-top:-30px;">Phone :+91-9841010067 | E-mail :atkenterprises2019@gmail.com</p><p style="text-align:center;font-size:18px;font-weight:bold;margin-top:-20px;">GSTIN : 33ABQFA4136J1ZD</p></div>

</header>

        <footer>
<!--            Copyright &copy; <?php //echo date("Y");?>  -->
           </footer>
        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
<!--            <p style="page-break-after: always;">
                Content Page 1
            </p>
            <p style="page-break-after: never;">
                Content Page 2
            </p> -->
<p style="text-align:center;font-weight:bold;"><?php echo $page . " for " . $ldgname . " ( " . $fdate . " to " .  $tdate  . " )" ?> </p>
            <div class="card-body">
              <div class="table-responsive">
              <div style="border:1px solid;border-left:none;border-top:none;border-right:none;"></div>

                <table  class="table  dt-responsive nowrap" id="ledgerTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
					<td style="text-align:left;background-color:#f5f6f7;">DATE</td>
                      <td style="text-align:left;background-color:#f5f6f7;">TRANS#</td>
                      <td style="text-align:center;background-color:#f5f6f7;">PARTICULARS</td>
                      <td style="left:69%;text-align:right;background-color:#f5f6f7;">DEBIT</td>
                      <td style="left:78%;text-align:right;background-color:#f5f6f7;">CREDIT</td>
                      <td style="text-align:right;background-color:#f5f6f7;">BALANCE</td>
                    </tr>

                  <tbody>
				  <tr>
           
<td colspan="6"  style="border:1px solid;border-left:none;border-bottom:none;border-right:none;"><?php echo $data[0]['op_balance']; ?></td>
</tr>
<?php 
foreach ($data as $value) {
//	var_dump($value);
//$data['data'][]=array("trans_id"=>$d['trans_id'],"trans_date"=>$trans_date,"trans_ref"=>$d['trans_reference'],"trans_type"=>$d['trans_type'], "particulars"=>$name,"db_amount"=>$db_amount,"cr_amount"=>$cr_amount,"cl_balance"=>$c_balance,"op_balance"=>$opbal);
	
?>	
			<tr>
				<td style="text-align:left";><?php echo $value['trans_date']; ?></td>
				<td style="text-align:left;"><?php echo $value['trans_id']; ?></td>
				<td style="text-align:left;"><?php  echo $value['particulars']; ?></td>
				<td style="text-align:right";><?php if($value['db_amount']!=0) { echo  number_format($value['db_amount'],2); } else { echo ""; } ?></td>
				<td style="text-align:right";><?php if($value['cr_amount']!=0) { echo number_format($value['cr_amount'],2);} else { echo ""; } ?></td>
				<td style="text-align:right";><?php echo number_format($value['cl_balance'],2); ?></td>


			</tr>


<?php
}

?>

			</tbody>
                </table>
                <div style="border:1px solid;border-left:none;border-top:none;border-right:none;"></div>
<div>Closing Balance >>>>>>>
<div style="float:right;text-align:right;font-weight:bold";><?php echo number_format($value['cl_balance'],2); ?></div>
</div>
                <div style="border:1px solid;border-left:none;border-top:none;border-right:none;"></div>
              </div>
            </div>
        </main>
    </body>
</html>
