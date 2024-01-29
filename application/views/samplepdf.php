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
                margin: 100px 25px;
            }

            header {
                position: fixed;
                top: 10px;
                left: 0px;
                right: 0px;
                height: 150px;

                /** Extra personal styles **/
             /*   background-color: #03a9f4; 
                color: white; */
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
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
            Copyright &copy; <?php echo date("Y");?> 
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
<!--            <p style="page-break-after: always;">
                Content Page 1
            </p>
            <p style="page-break-after: never;">
                Content Page 2
            </p> -->

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="ledgerTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
					<th>DATE</th>
                      <th>TRANS#</th>
                      <th>PARTICULARS</th>
                      <th>DEBIT</th>
                      <th>CREDIT</th>
                      <th>BALANCE</th>
                    </tr>
                  <tbody>


			<tr>
				<td>01-04-2023</td>
				<td>12344</td>
				<td>Cash</td>
				<td>4500.00</td>
				<td></td>
				<td>4500.00</td>

			</tr>
			<tr>
				<td>02-04-2023</td>
				<td>12344</td>
				<td>Bank</td>
				<td>8500.00</td>
				<td></td>
				<td>13000.00</td>
				
			</tr>
			<tr>
				<td>01-04-2023</td>
				<td>12344</td>
				<td>Cash</td>
				<td>1500.00</td>
				<td></td>
				<td>14500.00</td>
				
			</tr>
			<tr>
				<td>01-04-2023</td>
				<td>12344</td>
				<td>Purchase</td>
				<td></td>
				<td>14500.00</td>
				<td>0.00</td>
				
			</tr>
			<tr>
				<td>01-04-2023</td>
				<td>12344</td>
				<td>Purchase</td>
				<td></td>
				<td>4500</td>
				<td>4500.00</td>
				
			</tr>
			<tr>
				<td>01-04-2023</td>
				<td>12344</td>
				<td>Cash</td>
				<td>4500.00</td>
				<td></td>
				<td>4500.00</td>
				
			</tr>
			</tbody>
                </table>
              </div>
            </div>
        </main>
    </body>
</html>
