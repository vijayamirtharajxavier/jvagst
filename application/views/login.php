<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.0/jquery.contextMenu.min.css">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form method="POST" class="user" action="<?php echo base_url();?>login/validate_user" id="validate_userForm">
                    <div id="login-message"></div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="InputEmail"  name="InputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="InputPassword"  name="InputPassword" placeholder="Password" required>
                    </div>
                   <!--<div class="form-group">
                      <select id="finyear" name="finyear" class="form-control" > </select>
                    </div>-->                  
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                     <!--   <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>-->
                      </div>
                    </div>
                    <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                    <!--<a href="<?php echo base_url();?>login/validate_user" class="btn btn-primary btn-user btn-block"> -->
                      
                    </a>
                    <hr>
<!--                    <a href="<?php echo base_url();?>dashboard" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="<?php echo base_url();?>dashboard" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />


                  </form>
                  <hr>
                  <!--<div class="text-center">
                    <a class="small" href="<?php echo base_url();?>assets/forgot-password.html">Forgot Password?</a>
                  </div> -->
                  <!--<div class="text-center">
                    <a class="small" href="<?php echo base_url();?>assets/register.html">Create an Account!</a>
                  </div>-->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>



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






  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.0/jquery.contextMenu.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.0/jquery.ui.position.js"></script>
  
	<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>


<script>
$(document).ready(function(){

var url ="fetchFinyear";

$("#finyear").load(url);

console.log('Submited Form');

{
  /*SUBMIT FORM*/
                
                $("#validate_userForm").unbind('submit').bind('submit', function() { 
                  console.log('submited validate_user');
                    var form = $(this);
                    //var data = {'id' : id};
                //  console.log(data);
                    var data = form.serialize()+'&'+ $.param(data);
                    var url = form.attr('action');
                    var type = form.attr('method');
                //  console.log('url-'+ url+"/"+id);
                    //var invNo= "&id=" + id ;
                    $.ajax({
                        url: url,
                        type: type,
                        data: data,
                        dataType: 'json',
                        success:function(response) {
                           // console.log(response);
                            if(response.success == true) {    
                              console.log('success');
															
													//		loadCompdata(response.userid);
													//	loadjsgrid(response.userid);	
	showCompany(response);
	/*
													$('#companyselectModal').modal({backdrop: 'static', keyboard: false}, 'show');

													$("#grid").jsGrid({
			width: "100%",
			height: "400px",
//			filtering: false,
	//		editing: false,
	//		sorting: true,
	//		paging: true,
		//	data: friends,
		//filtering: true,
        editing: false,
        sorting: true,
        paging: true,
        autoload: true,
        pageSize: 15,
        pageButtonCount: 5,
        //deleteConfirm: "Do you really want to delete the client?",
				controller: {
                loadData: function (filter) {
                    var d1 = $.Deferred();                 
                    $.ajax({
                       type: "GET",
                       url: 'login/getcompany?user_id='+response.userid,
                       data: '{}',
                       contentType: "application/json; charset=utf-8",
                       dataType: "json",
                    }).done(function (response) {
										//	console.log(response);
                        d1.resolve(response);
                    });

                    return d1.promise();
                },
            },
			fields: [
				{ name: "company_name", type: "text", width: 100, title: "Company Name" },
				{ name: "finyear", type: "text", width: 10, title: "Fin.Year" }
			//	countries
//				{ name: "Cool", type: "checkbox", width: 40, title: "Is Cool", sorting: false },
			//	{ type: "control" }
			],
					rowClick: function (args) {
									$(".jsgrid-row, .jsgrid-alt-row").removeClass("highlight");
									gRow = this.rowByItem(args.item);
									gRow.addClass("highlight");
									selectRowItem = args.item;
									console.log((selectRowItem));
														//	$("#companyselectModal").modal('show');
                              var id=selectRowItem.company_id;
                              var email=response.email;
                              var finyear=selectRowItem.finyear;
                              var userid = response.userid;
                              var authkey=response.authkey;
															var compid = selectRowItem.company_id;
                             // console.log(id);
//                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
                              var furl = 'login/log?id='+id+'&email='+email+'&compid='+compid +'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
                             // console.log(furl);
                              //window.location.href = furl;                  
                            window.location.replace(furl);
                                $('.form-group').removeClass('has-error').removeClass('has-success');
                                $('.text-danger').remove(); 
															},
		}) ;
*/
                                                                
                            }   
                            else {                                  
                            //  console.response;
                                $("#login-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                                  response.message + 
                                '</div>');      
$("#login-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#danger-alert").slideUp(500);
});             

                                $.each(response.messages, function(index, value) {
                                    var key = $("#" + index);

                                    key.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                                    .find('.text-danger').remove();                         

                                    key.after(value);
                                });
                                                        
                            } // /else
                            
                        } // /.success
                    }); // /.ajax
                    return false;
                }); // /.submit edit expenses form
}  


    
function createTable(data) {
var table = "<table id='cTbl' border='1' class='table'>";
// add a row for name and marks
table += `<tr>
            <th>Company Name</th>
            <th style='width:5%'>Fin.Year</th>
          </tr>`;
// now loop through students
// show their name and marks
var tr = "";
var obj = JSON.parse(data);
console.log(obj);
//console.log(obj[0].company_name);

for(let i = 0; i < obj.length; i++) {
	tr += "<tbody id='ctbody'>";
  tr += "<tr>";
  tr +=  "<td>" + obj[i].company_name + "</td>";
  tr +=  "<td style='text-align:right'>" + obj[i].finyear + "</td>";
  tr += "</tr></tbody>";
}
table += tr + "</table>";

  // append table to body
 // document.body.innerHTML += table;
//$("#compTbl").innerHTML +=table;
//console.log(table);
//$("#compTbl").html(table);
//$("#companyselectModal #compTbl").val(table);

}


function loadCompdata(userid)
{
	console.log('loadCompdata func');
	$.ajax({
	// Our sample url to make request 
	url: 'login/getcompany?user_id='+userid,
	// Type of Request
	type: "GET",

	// Function to call when to
	// request is ok 
	success: function (data) {
		//	var x = JSON.stringify(data);
	//		console.log(x);
			createTable(data);



	},

	// Error handling 
	error: function (error) {
			console.log(`Error ${error}`);
	}
});
															

}

$(document).on('click', '#compTbl #cTbl tr', function(){
	console.log('clicked compTble Tr')
	//$(this).addClass('selected').siblings().removeClass('selected');    
	//$(this).closest('table').find('td').not(this).removeClass('selected');  
//$(this).removeClass('selected');
$(this).toggleClass('selected').siblings().removeClass('selected');
//$(this).toggleClass('selected');
//$(this).toggleClass('selected').siblings().removeClass('selected');
//$(this).closest('table').find('td').not(this).removeClass('selected');      
//$(this).toggleClass('selected');

	var value=$(this).find('td:first').html();
   console.log(value);    
});



$('.ok').on('click', function(e){
    alert($("#compTbl tr.selected td:first").html());
});


});



		
	 
	var gRow=[];
	var selectRowItem=[];
		
					
		
	 
	
	var friends = [
		{
			company_name: "Ada Lovelace",
			finyear: "2023-24",
			company_id: 3,
			Cool: true,
		},
		{
			company_name: "Grace Hopper",
			finyear: "2022-23",
			company_id: 1,
			Cool: true,
		},
		{
			company_name: "Alan Turing",
			finyear: "2021-22",
			company_id: 3,
			Cool: true,
		},
		{
			company_name: "ATK ENTERPRISES",
			finyear: "2023-24",
			company_id: 5,
			Cool: true,
		}
	];
	
	var countries = {
		name: "company_id",
		type: "select",
		title: "Company Name",
		items: [
			{ Name: "", Id: 0 },
			{ Name: "JVA INFOTECH", Id: 1 },
			{ Name: "ATK ENTERPRISES", Id: 2 },
			{ Name: "JVA INFOTECH", Id: 3 },
			{ Name: "Spain", Id: 4 },
			{ Name: "Mexico", Id: 5 }
		],
		valueField: "Id",
		textField: "Name"
	}
	
	function showCompany(response)
{
	$('#companyselectModal').modal({backdrop: 'static', keyboard: false}, 'show');

$("#grid").jsGrid({
width: "100%",
height: "400px",
//			filtering: false,
//		editing: false,
//		sorting: true,
//		paging: true,
//	data: friends,
//filtering: true,
editing: false,
sorting: true,
paging: true,
autoload: true,
pageSize: 15,
pageButtonCount: 5,
//deleteConfirm: "Do you really want to delete the client?",
controller: {
loadData: function (filter) {
var d1 = $.Deferred();                 
$.ajax({
type: "GET",
url: 'login/getcompany?user_id='+response.userid,
data: '{}',
contentType: "application/json; charset=utf-8",
dataType: "json",
}).done(function (response) {
//	console.log(response);
d1.resolve(response);
});

return d1.promise();
},
},
fields: [
{ name: "company_name", type: "text", width: 100, title: "Company Name" },
{ name: "finyear", type: "text", width: 10, title: "Fin.Year" }
//	countries
//				{ name: "Cool", type: "checkbox", width: 40, title: "Is Cool", sorting: false },
//	{ type: "control" }
],
rowClick: function (args) {
$(".jsgrid-row, .jsgrid-alt-row").removeClass("highlight");
gRow = this.rowByItem(args.item);
gRow.addClass("highlight");
selectRowItem = args.item;
console.log((selectRowItem));
	//	$("#companyselectModal").modal('show');
		var id=selectRowItem.company_id;
		var email=response.email;
		var finyear=selectRowItem.finyear;
		var userid = response.userid;
		var authkey=response.authkey;
		var compid = selectRowItem.company_id;
	 // console.log(id);
//                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
		var furl = 'login/log?id='+id+'&email='+email+'&compid='+compid +'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
	 // console.log(furl);
		//window.location.href = furl;                  
	window.location.replace(furl);
			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove(); 
		},
}) ;

} 
</script>

<style>
td {border: 1px #DDD solid; padding: 5px; cursor: pointer;
}

.selected {
    background-color: blue;
    color: #FFF;
}
/*.selected {
    background-color: rgba(0,0,0,0.4) !important;
    color: #fff;
}
*/
table {
  border-collapse: collapse; 
}
tr.highlight td.jsgrid-cell {
        background-color: #007bff !important;
        color: white;
    }
 


</style>

</body>

</html>
