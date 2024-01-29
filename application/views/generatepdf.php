<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Invoice</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

</head>
<body>
<div id="page-wrap">
<div align="center">TAX INVOICE</div>
<table width="700px;">
<tr>
<?php echo base_url('assets/img/jvalogo.png'); ?> 
	<td><img width="50px" height="50px" src="<?php echo base_url('assets/images/atk_logo.png'); ?>"></td>
	<td><h1 style="text-align:center;font-size:18px;font-weight:bold;margin-bottom:10px;">ATK ENTERPRISES</h1><p  style="text-align:center;font-size:11px;margin-top:-10px;">1/54 GAJAPATHY STREET | SHENOY NAGAR | CHENNAI 600 030</p><p style="text-align:center;font-size:10px;margin-top:-10px;">Phone :+91-9841010067 | E-mail :atkenterprises2019@gmail.com</p><p style="text-align:center;font-size:18px;font-weight:bold;margin-top:-10px;">GSTIN : 33ABQFA4136J1ZD</p></td>
	<td><img width="50px" height="50px" src="<?php echo base_url('assets/images/atk_gpayqr.jpg'); ?>"></td>
</tr>


</table>

<table style="border-collapse:collapse;font-size:14px;" width="700px">
	<tr>
		<th style="border:1px solid;border-bottom:none;background-color:#f5f6f7;">Details of Buyer</th>
		<th colspan="2" style="border:1px solid;border-bottom:none;background-color:#f5f6f7;">Invoice Details</th>
	</tr>
	<tr>
	<td style="border:1px solid;padding: 15px;font-size:16px;" rowspan="6" valign="top">'. $billto .' </td>
	<td style="border:1px solid;text-align:center;width:50px;padding: 15px;background-color:#f5f6f7;font-size:16px;">Invoice #</td>
	<td  style="width:50px;border:1px solid;text-align:center;padding: 15px;background-color:#f5f6f7;font-size:16px;">Invoice Date</td>
	</tr>
	<tr>
	<td style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;font-weight:bold;">'. $inv_id .'</td>
	<td  style="width:100px;border:1px solid;font-size:16px;text-align:center;padding: 15px;font-weight:bold;">'. $inv_date .'</td>
	</tr>
	<tr>
	<td style="border:1px solid;text-align:center;width:100px;background-color:#f5f6f7;padding: 15px;font-size:16px;">Ref #</td>
	<td align="center" style="border:1px solid;text-align:center;width:100px;background-color:#f5f6f7;padding: 15px;font-size:16px;">Page #</td>
	<tr>
	<td style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;">'. $ref_no .'</td>
	<td align="center" style="border:1px solid;font-size:16px;width:100px;padding: 15px;"> {PAGENO}/{nb} </td>
	</tr>
	<tr>
	<td colspan="2" style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;">CREDIT PERIOD : &nbsp;'. $cpid .'</td>
	</tr>
</table>
<table style="border-collapse:collapse;font-size:14px;" width="700px">
	<tr>
              <th style="width:10px;">SL.NO.</th>
              <th>PRODUCT / SERVICE</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
							<th>GST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="9"></th>
            
            <th>%</th>
            <th>&#8377;</th>
						<th>%</th>

            <th>&nbsp;&#8377;</th>
            
          </tr>

</table>








</div>
</body>
</html>
