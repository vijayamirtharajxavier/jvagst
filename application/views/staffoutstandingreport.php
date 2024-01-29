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
--

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"> --
<link href="<?php base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.24/datatables.min.css"/>
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-ui.min.css"> 


<link href="https://unpkg.com/tabulator-tables/dist/css/tabulator.min.css" rel="stylesheet">

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
            
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo $page; ?>
							<form class="text-center" style="color: #757575;" action="getStaffOutstand" method="POST" id="staffOutstandForm">
							<div style="float:right;">Select a Staff <select id="stfacc" name="stfacc" style="width: 15em;height: 2em"></select>&nbsp;&nbsp;<button type="submit" class="btn btn-primary">Search</button></div> 
<!--              <button style="float: right;" class="pull-right btn btn-primary" href="#"  data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalAddStaff"><i class="fa fa-plus"></i> New Staff</button>-->
<input type="text" id="stfid" name="stfid" hidden>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
</form>
</h6> 
            </div>
            
<div id="delete-Staff-message"></div>
            <div class="card-body">
              <div class="table-responsive">
							<div>
</div>
<button id="downloadstfout-xls" class="btn"><i class="fas fa-file-excel"></i></i></button>
<button style="float:left" id="downloadstfout-pdf" class="btn"><i style="color:red" class="fas fa-file-pdf"></i></button>
<input type="text" id="compname" name="compname" hidden>

<!--				<button class="btn btn-primary" onclick="extractTable();" >Extract JSONDATA</button> -->
<div id="stfoutstand-table"></div>
<!--			  <div id="myGrid" style="height: 200px; width:500px;" class="ag-theme-alpine"></div> -->
                <!--<div id="Staff_list"></div>-->


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



<!--Add Modal for New Staff-->
<div id="modalAddStaff" class="modal fade"  role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Staff</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="add-staff-message" class="pull-right"></div>
<div id="add-error-staff-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="createStaff" method="POST" id="addStaffForm">
<div id="eloader" class="eloader"></div>
<div id="rloader" class="rloader"></div>

<div class="modal-body">

<table id="newStaff" class="table table-bordered">
<tr><td>Staff Name<input type="text" class="form-control" autocomplete="off"  id="staffname" name="staffname" ></td>
</tr>
</table>
<input type="text" id="flag" name="flag" value="STAFF" hidden>


<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="submit" id="save_stfbtn" class="btn btn-success">Save</button>
                </div>
                </form>
            </div>
        </div>
</div>




<!--Edit Modal -->
<div id="modalEditStaff" style="width: 1200px; margin-left: 50px;" class="modal fade"  role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Staff Invoice</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
<div id="edit-staff-message" class="pull-right"></div>
<div id="edit-error-staff-message" class="pull-right"></div>


<!-- Form -->
<form class="text-center" style="color: #757575;" action="editStaff" method="POST" id="editStaffForm">

<div class="modal-body">
<div class="show-edit-Staff-result"></div>
<input type="text" id="flag" name="flag" value="SALE" hidden>

<!-- Material form register -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                </div>

                <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
  <button type="button" id="addRow" class="btn btn-info">Add Row</button>
  <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
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
<!--<script src="<?php base_url();?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<!-<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>-->
<script type="text/javascript" src="https://unpkg.com/tabulator-tables/dist/js/tabulator.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.24/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/staffs.js"></script>

  

  <!-- Page level custom scripts -->
<!--  <script src="<?php echo base_url();?>assets/js/demo/chart-area-demo.js"></script>
  <script src="<?php echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>
<script src="<?php echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script> -->
<script>
		var sessionValue = '<?php echo $this->session->userdata("cname");?>';
	console.log(sessionValue);
$("#compname").val(sessionValue);
</script>


</body>

</html>
