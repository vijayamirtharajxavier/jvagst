<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  GSTIN# &nbsp;&nbsp;<?php echo $this->session->userdata('gstin'); ?>
                </button>
                <button class="btn btn-info" type="button">
                  POS &nbsp;&nbsp;<?php echo $this->session->userdata('cstatecode'); ?>
                </button>

              </div>
            </div>

          </form>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

<li>
  <div class="input-group mt-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="inputGroupSelect01">Fin. Year </label>
  </div>
  <select class="select"  id="finyear" name="finyear" class="form-control" required> </select>

</div>

</li>

<li>
  <div class="input-group mt-3">
	<form method="POST" class="user" action="#" id="changecomp_userForm">
    <button disabled type="button" class="btn btn-secondary"  id="changecomp" name="changecomp"><i class="fa fa-company"></i> </button>
</form>
</div>

</li>



            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="<?php echo base_url();?>#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('login'); ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url();?>assets/img/jvalogo.png" alt="SKE">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" onclick="getProfile();" href="<?php echo base_url();?>#" data-toggle="modal" data-target="#profileModal">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
<!--                <a class="dropdown-item" onclick="getSettings();" href="<?php echo base_url();?>#" data-toggle="modal" data-target="#settingModal">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" onclick="getCompany();" href="<?php echo base_url();?>#" data-toggle="modal" data-target="#companyModal">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Company Details
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url();?>#" data-toggle="modal" data-target="#companyselectModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Company
                </a> -->
              
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url();?>#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>



<!----Chane Company--Modal -->

  <!-- Company Selection Modal-->
  <div class="modal fade" id="companyselectModal" tabindex="-1" role="dialog" aria-labelledby="companyselectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select a company to prooced</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="compTbl"></div>
					<div id="grid"></div>
						
				</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button id="proceed_btn" class="btn btn-primary" type="button">Proceed ></button>

<!--					<a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Select</a> -->
        </div>
      </div>
    </div>
  </div>



  <!-- Drilldown Stock summary Selection Modal-->
  <div class="modal fade" id="stocksubModal" tabindex="-1" role="dialog" aria-labelledby="stocksubModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"  id="exampleModalLabel"><div style="float:left;font-weight:bold" class="item_name"></div></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
					<div id="stocksublist"></div>
						
				</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

<!--					<a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Select</a> -->
        </div>
      </div>
    </div>
  </div>



<!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo base_url();?>login/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>


<!-- Settings Modal-->
<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div id="update-settings-message"></div>
        <div id="error-settings-message"></div>
        <form action="accounts/save_settings" method="POST" id="save_settingsForm">
        <div class="modal-body">
          <div class="container">
            <br>
            <div class="form-row">
               <div class="col-md-6">
                 
                        <label for="numformat">NUMBERING FORMAT</label>
                        <select id="numformat" name="numformat">
                          <option value="ZEROPAD">001.002.ZERO PAD</option>
                          <option value="NORMAL">1,2..NORMAL</option>
                        </select>
                </div>
               <div class="col-md-6">
                 
                      <label for="numformat">Leading Zero</label>
                      <input type="number" id="leadzero" name="leadzero" class="form-control">
                </div>

              </div>
              <div class="form-row">
                <div class="col-md-4">

                    <!-- First name -->
                        <label for="productname">INV#</label>
                         <input type="text" id="invoice_number" style="text-align: right;"  name="invoice_number" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="productdesc">INV_PREFIX</label>
                        <input type="text" id="invoice_prefix" style="text-align: right;"  name="invoice_prefix" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-4">
                        <label for="productdesc">INV_SUFFIX</label>
                        <input type="text" style="text-align: right;"  id="invoice_suffix" autocomplete="off" name="invoice_suffix" class="form-control">
                </div>
              </div>
      
              <div class="form-row">
                <div class="col-md-4">

                    <!-- First name -->
                        <label for="productname">Receipt Number</label>
                         <input type="text" id="receipt_number" name="receipt_number" style="text-align: right;"  class="form-control" autocomplete="off" required>
                </div>
                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="productdesc">Receipt_Prefix</label>
                        <input type="text" id="receipt_prefix" style="text-align: right;"  name="receipt_prefix" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-4">
                        <label for="productdesc">Receipt_Suffix</label>
                        <input type="text" style="text-align: right;"  id="receipt_suffix" autocomplete="off" name="receipt_suffix" class="form-control">
                </div>


            </div>
              <div class="form-row">
                <div class="col-md-4">

                    <!-- First name -->
                        <label for="productname">Payment_Number</label>
                         <input type="text" id="payment_number" style="text-align: right;"  name="payment_number" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="productdesc">Payment_Prefix</label>
                        <input type="text" id="payment_prefix" style="text-align: right;"  name="payment_prefix" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-4">
                        <label for="productdesc">Payment_Suffix</label>
                        <input type="text" style="text-align: right;"  id="payment_suffix" autocomplete="off" name="payment_suffix" class="form-control">
                </div>


            </div>
              <div class="form-row">
                <div class="col-md-4">

                    <!-- First name -->
                        <label for="contra_number">Contra_Number</label>
                         <input type="text" id="contra_number" name="contra_number" style="text-align: right;"  class="form-control" autocomplete="off" required>
                </div>
                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="productdesc">Contra_Prefix</label>
                        <input type="text" id="contra_prefix" style="text-align: right;"  name="contra_prefix" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-4">
                        <label for="productdesc">Contra_Suffix</label>
                        <input type="text" id="contra_suffix" style="text-align: right;" autocomplete="off" name="contra_suffix" class="form-control">
                </div>


            </div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

         
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-success" type="submit" >Save</button>
          
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
</div>


<!-- Company Details -->

<div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div id="update-company-message"></div>
        <div id="error-company-message"></div>
        <form action="accounts/save_company" method="POST" id="save_companyForm">
        <div class="modal-body">
          <div class="container">
            
              <div class="form-row">
                <div class="col-md-6">
                    <!-- Last name -->
                        <label for="companyname">Company Name</label>
                        <input type="text" id="companyname"   name="companyname" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-6">
                        <label for="productdesc">GSTIN#</label>
                        <input type="text"   id="companygstin" autocomplete="off" name="companygstin" class="form-control">
                </div>
              </div>



              <div class="form-row">
                <div class="col-md-12">

                    <!-- First name -->
                        <label for="productname">Company Address</label>
                         <input type="text" id="companyaddress" name="companyaddress" class="form-control" autocomplete="off" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6">
                    <!-- Last name -->
                        <label for="productdesc">City</label>
                        <input type="text" id="companycity"   name="companycity" class="form-control" autocomplete="off">
                </div>
                <div class="col-md-6">

                    <!-- First name -->
                        <label for="productname">State</label>
                         <select type="text" id="companystatecode" name="companystatecode" class="form-control" autocomplete="off" required></select>
                </div>

              </div>
      
              <div class="form-row">

                <div class="col-md-4">
                        <label for="productdesc">Pincode</label>
                        <input type="text"   id="companypincode" autocomplete="off" name="companypincode" class="form-control">
                </div>

                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="productdesc">Email</label>
                        <input type="text" id="companyemail"   name="companyemail" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-4">
                        <label for="productdesc">Contact#</label>
                        <input type="text"   id="companycontact" autocomplete="off" name="companycontact" class="form-control">
                </div>


            </div>
              <div class="form-row">
                <div class="col-md-12">

                    <!-- First name -->
                        <label for="productname">Bank Details</label>
                         <input type="text" id="companybank"   name="companybank" class="form-control" autocomplete="off" required>
                </div>


            </div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

         
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-success" type="submit" >Save</button>
          
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
</div>


<!-- User Profile Details -->

<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div id="update-company-message"></div>
        <div id="error-company-message"></div>
        <form action="accounts/save_company" method="POST" id="save_companyForm">
        <div class="modal-body">
          <div class="container">
            
              <div class="form-row">
                <div class="col-md-6">
                    <!-- Last name -->
                        <label for="companyname">First Name</label>
                        <input type="text" id="firstname"   name="firstname" class="form-control" autocomplete="off">
                </div>

                <div class="col-md-6">
                    <!-- Last name -->
                        <label for="companyname">Last Name</label>
                        <input type="text" id="lastname"   name="lastname" class="form-control" autocomplete="off">
                </div>

              </div>
              <div class="form-row">
                <div class="col-md-12">
                        <label for="productdesc">Email Id</label>
                        <input type="text"   id="email" autocomplete="off" name="email" class="form-control">
                </div>


              </div>
    <div class="form-row">
          <div><h4>Change Password</h4></div>
</div>
              <div class="form-row">
                <div class="col-md-4">
              

                    <!-- First name -->
                        <label for="currpass">Curr. Password</label>
                         <input type="password" id="companyaddress" name="companyaddress" class="form-control" autocomplete="off" required placeholder="******">
                </div>
              
                <div class="col-md-4">
                    <!-- Last name -->
                        <label for="newpass">New Password</label>
                        <input type="password" id="newpass" size="10"  name="newpass" class="form-control" autocomplete="off" required placeholder="4 to 10 alpha numeric">
                </div>
                <div class="col-md-4">

                    <!-- First name -->
                        <label for="confirmpass">Confirm Pass</label>
                        <input type="password" id="confirmpass" size="10"  name="confirmpass" class="form-control" autocomplete="off" required>
                </div>

              </div>
      
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

         
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button><button class="btn btn-success" type="submit" >Save</button>
          
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.0/jquery.contextMenu.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.0/jquery.ui.position.js"></script>
 
<script src="<?php echo base_url();?>assets/js/navbar.js"></script>




<style type="text/css">
  
  label
  {
    font-weight: bold;
  }

</style>
