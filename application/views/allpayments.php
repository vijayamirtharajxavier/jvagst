<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $this->session->userdata('cname'); ?> | <?php echo $this->session->userdata('city'); ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!--<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
-->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> 

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/invstyle.css"> 


</head>

<body id="page-top">

 <!-- Page Wrapper -->
  <div id="wrapper">
<?php  include 'layouts/sidebar.php';  ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
<?php  include 'layouts/navbar.php';  ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
 <h1 class="h3 mb-2 text-gray-800"><?php echo $page; ?></h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div id="delete-payment-message" class="pull-right"></div>
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $page; ?>
              <button style="float: right;" class="pull-right btn btn-primary" href="#"  data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalAddpayment"><i class="fa fa-plus"></i> New Payment</button> </h6>
            </div>
            
<div id="delete-payment-message"></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="paymentlistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>PAYMENT#</th>
                      <th>PAYMENT DATE</th>
                      <th>DEBIT ACCOUNT</th>
                      <th>CREDIT ACCOUNT</th>
                      <th>AMOUNT</th>
                      <th>REFERENCE</th>
                      <th>NARRATION</th>

                    </tr>
                  </thead>
                  <tbody id="paymentlist"></tbody>
                </table>

                <!--<div id="payment_list"></div>-->
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


      <!-- Footer -->
<?php  include 'layouts/footer.php';  ?>      
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>






<!--Add Modal -->
<div id="modalAddpayment" style="width: 1200px;" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="add-payment-message" class="pull-right"></div>
<div id="add-error-payment-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="createpayment" method="POST" id="addpaymentForm">

<div class="modal-body">
<div id="loader" class="aloader"></div>

<table id="payment" class="table table-bordered">
<tr><td>payment#<input type="text" class="form-control" autocomplete="off"  id="paymentno" name="paymentno" readonly></td><td>payment Date<input type="date" class="form-control" autocomplete="off"  id="paymentdate" name="paymentdate" required></td><td>Debit Account<input type="text" class="form-control dbaccount" autocomplete="off" id="dbaccount" name="dbaccount" required></td><td>Credit Account<input type="text" class="form-control craccount" autocomplete="off"  id="craccount" name="craccount" required></td></tr><tr><td>Amount <input type="text" class="form-control" style="text-align: right;" autocomplete="off"  id="trans_amount" name="trans_amount"></td><td>Trans Ref#<input type="text" class="form-control" autocomplete="off"  id="transref" name="transref"></td><td colspan="2">Narration<input type="text" class="form-control" autocomplete="off"  id="narration" name="narration"></td></tr>
</table>

<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="submit" id="save_rbtn" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>


<!--Edit Modal -->
<div id="modalEditpayment" style="width: 1200px;" class="modal fade"  role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-payment-message" class="pull-right"></div>
<div id="edit-error-payment-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="editpayment" method="POST" id="editpaymentForm">

<div class="modal-body">
  <div id="loader" class="eloader"></div>
<div class="show-edit-payment-result"></div>
<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>
        

<!-- Modal HTML -->
<div id="deleteModal" class="modal fade">
  <div class="modal-dialog modal-confirm">
    <div class="modal-content">
      <div class="modal-header flex-column">
        <div class="icon-box">
          <i class="fa fa-times"></i>
        </div>            
        <h4 class="modal-title w-100">Are you sure?</h4>  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      
      <div class="modal-body">
        <p>Do you really want to delete these records? This process cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="delete_btn" class="btn btn-danger">Delete</button>
      </div>

    </div>
  </div>
</div>     



  
<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url();?>assets/js/navbar.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url();?>assets/js/bootstrap3-typeahead.min.js"></script>
<script src="<?php base_url(); ?>../assets/js/jquery-ui.min.js"></script>
  
<script src="<?php base_url(); ?>../assets/js/select2.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/payments.js"></script>


  <!-- Page level custom scripts -->
<!--  <script src="<?php echo base_url();?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script> -->

<script>






</script>


<style type="text/css">

/*thead th {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
  z-index: 2;
}
*/
#editInvoiceItems thead th {
  background:grey;
  color: white;
  position: sticky;
  top: 0;
}

#InvoiceItems thead th {
  background:grey;
  width: auto;
  color: white;
  position: sticky;
  top: 0;
}


input{
  font-size: 16px;
}


.sturdy th:nth-child(2)
 {
  width: 35%;
}

.sturdy td:nth-child(2),
.sturdy td:nth-child(2) {
  width: 35%;
}
/*.sturdy td:nth-child(2) {
  width: 50%;
} */

.nobreak {
  white-space: nowrap;
}

.wider td {
  width: 300px;
}


.ignoreyou td:nth-child(1) {
  width: 10px;
}
.ignoreyou td:nth-child(2) {
  width: 28px;
}

.cut-off th:nth-child(1) {
  width: 75%;
}
.cut-off td:nth-child(1) {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.cut-off th:nth-child(2) {
  width: 25%;
}
.cut-off td:nth-child(2) span {
  display: block;
  
}


.hide td {
  overflow: hidden;
}

.scroll-code td {
  overflow: auto;
}



.typeahead input{
  position: absolute;
  bottom: : 70px;
}


    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}

.ui-autocomplete { height: auto; overflow-y: scroll; overflow-x: hidden;
z-index: 215000000 !important;
}

/*
.ui-autocomplete {
  z-index: 215000000 !important;
}
*/



</style>
<style>
body {
  font-family: 'Varela Round', sans-serif;
}
.modal-confirm {    
  color: #636363;
  width: 400px;
}
.modal-confirm .modal-content {
  padding: 20px;
  border-radius: 5px;
  border: none;
  text-align: center;
  font-size: 14px;
}
.modal-confirm .modal-header {
  border-bottom: none;   
  position: relative;
}
.modal-confirm h4 {
  text-align: center;
  font-size: 26px;
  margin: 30px 0 -10px;
}
.modal-confirm .close {
  position: absolute;
  top: -5px;
  right: -2px;
}
.modal-confirm .modal-body {
  color: #999;
}
.modal-confirm .modal-footer {
  border: none;
  text-align: center;   
  border-radius: 5px;
  font-size: 13px;
  padding: 10px 15px 25px;
}
.modal-confirm .modal-footer a {
  color: #999;
}   
.modal-confirm .icon-box {
  width: 80px;
  height: 80px;
  margin: 0 auto;
  border-radius: 50%;
  z-index: 9;
  text-align: center;
  border: 3px solid #f15e5e;
}
.modal-confirm .icon-box i {
  color: #f15e5e;
  font-size: 46px;
  display: inline-block;
  margin-top: 13px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
  color: #fff;
  border-radius: 4px;
  background: #60c7c1;
  text-decoration: none;
  transition: all 0.4s;
  line-height: normal;
  min-width: 120px;
  border: none;
  min-height: 40px;
  border-radius: 3px;
  margin: 0 5px;
}
.modal-confirm .btn-secondary {
  background: #c1c1c1;
}
.modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
  background: #a8a8a8;
}
.modal-confirm .btn-danger {
  background: #f15e5e;
}
.modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
  background: #ee3535;
}
.trigger-btn {
  display: inline-block;
  margin: 100px auto;
}
</style>



</body>

</html>
