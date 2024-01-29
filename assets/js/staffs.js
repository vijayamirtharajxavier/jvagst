var count;
var cnt;
count=1;
cnt=1;
var netvalue=0;
var net_value=0;
var netval=0;  
var gst_value=0.00;
var gstvalue=0;
var amtval=0;
var txbval=0;
var qty=0;
var gst_pc=0;
var dispc=0;
var rate=0;
var disval=0;
var gst_amt=0;
var gsttot=0;
var tablestaff;
var tablecategory;
var managestaffslistTable;
$(document).ready(function(){
	getStaff();
//$('#StafflistTable').DataTable();
var url="getSalesPerson";
$('#stfacc').load(url);
var stfid = $("#stfacc").val();
$("#stfid").val(stfid);

$("#stfacc").on('change',function(){
	var stfid = $("#stfacc").val();
	$("#stfid").val(stfid);
	
});


var url="getCategoryList";
$('#catacc').load(url);
var catid = $("#catacc").val();
$("#catid").val(catid);

$("#catacc").on('change',function(){
	var catid = $("#catacc").val();
	$("#catid").val(catid);
	
});


var url="getStaffPerson";
//Add Staff Message

    $("#addStaffForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
//rloader = document.querySelector(".rloader");        
//rloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) { 
                rloader.style.display = "none";                     
                        $("#add-staff-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');
$("#add-staff-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});

$("#addStaffForm").trigger("reset");
managestaffslistTable.ajax.reload(null, false);
$("#InvoiceItems tbody tr").remove(); 
$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-staff-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-staff-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

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
        }); // /.ajax funciton
        return false;
    });




//Edit Staff Messge


    $("#editStaffForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
        
eloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) {                      
                  eloader.style.display = "none";
                        $("#edit-staff-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


						managestaffslistTable.ajax.reload(null, false);  
$("#edit-staff-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-Staff-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-Staff-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

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
        }); // /.ajax funciton
        return false;
    });




//Categorywise Sales report	categorySalesForm


$("#categorySalesForm").unbind('submit').bind('submit', function() {
	var form = $(this);
	var url = form.attr('action');
	var type = form.attr('method');
	
eloader.style.display = "block";
	$.ajax({
		url: url,
		type: type,
		data: form.serialize(),
		dataType: 'json',
		success:function(response) {
		  console.log(response);
		   tablecategory = new Tabulator("#categorysales-table", {
			data:response, //set initial table data
			groupBy:["category"],
			groupClosedShowCalcs:true,
			columns:[
				{title:"Category Name", field:"category",visible:false},
				{title:"Invoice Number", field:"invoiceno"},
				{title:"Invoice Date", field:"trans_date"},
				{title:"Customer Name", field:"cust_name", editor:"input", headerFilter:true},
//				{title:"Product Category", field:"category",visible:false},
				{title:"Taxable Amount", field:"txb_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				{title:"GST Amount", field:"gst_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				{title:"Invoice Value", field:"net_amt",hozAlign:"right",columnCalcs:"both",bottomCalc:"sum", bottomCalcParams:{precision:2}},

				/*					{title:"Height", field:"height"},
				{title:"Favourite Color", field:"col"},
				{title:"Date Of Birth", field:"dob"},
				{title:"Cheese Preference", field:"cheese"},*/
				
			],
		});
		
		  if(response.success == true) {                      

			}   
				else {                                  

					$("#error-staff-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');


$("#error-staff-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

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
	}); // /.ajax funciton
	return false;
});



$("#downloadstf-pdf").on('click',function(){
	var fdate = $("#fdate").val();
	var tdate =$("#tdate").val();
	var splt_fdate = fdate.split("-");
	var splt_tdate = tdate.split("-");
	var f_date = splt_fdate[2] + "-" + splt_fdate[1] + "-" + splt_fdate[0];
	var t_date = splt_tdate[2] + "-" + splt_tdate[1] + "-" + splt_tdate[0];

	var compname = $("#compname").val();
    tablestaff.download("pdf", "sttdata.pdf", {
        orientation:"l", //set page orientation to portrait or landscape
		unit: 'pt', // points, pixels won't work properly
     //   format: [canvas.width, canvas.height],
	 format: [612, 792],
	 		title:compname + " - Staff Sales Report for ( " + f_date + " to " + t_date + " )", //add title to report
	});



    });




$("#downloadstf-xls").on('click',function(){
	tablestaff.download("xlsx", "stfwisesales.xlsx", {sheetName:"StfwiseSales"});
});



$("#downloadstfout-pdf").on('click',function(){
var stfname = $("#stfacc :selected").text();
var stfnameid=$("#stfacc").val();
if(stfnameid=="" || stfnameid=="0")
{
	var stf_name = "All Staff`s";
}
else
{
	var stf_name = stfname;
}
	var compname = $("#compname").val();
	tablestaff.download("pdf", "data.pdf", {
		orientation:"portrait", //set page orientation to portrait
		format: [612, 792],
		title:compname + " - Staff Outstanding Report for " +stf_name, //add title to report

		autoTable:function(doc){
			//doc - the jsPDF document object
	
			//add some text to the top left corner of the PDF
		//	doc.text(compname, 1, 1);
	
			//return the autoTable config options object
			return {
				styles: {
					//fillColor: [200, 0o0, 0o0]
				},
			};
		},
	});



/*

    tablestaff.download("pdf", "stfoutdata.pdf", {
        orientation:"l", //set page orientation to portrait or landscape
		unit: 'pt', // points, pixels won't work properly
     //   format: [canvas.width, canvas.height],
	 format: [612, 792],
	 		title:compname + " - Staff Outstanding Report for " +stf_name, //add title to report
	});

*/

    });




$("#downloadstfout-xls").on('click',function(){
	tablestaff.download("xlsx", "stfwiseoutstanding.xlsx", {sheetName:"StfOutstandings"});
});

//Staffwise Sales report

    $("#staffSalesForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
        
eloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
			   tablestaff = new Tabulator("#staffsales-table", {
				data:response, //set initial table data
				groupBy:["staffname","category"],
				groupClosedShowCalcs:true,
				columns:[
					{title:"Staff Name", field:"staffname",visible:false},
					{title:"Invoice Number", field:"invoiceno", editor:"input", headerFilter:true},
					{title:"Invoice Date", field:"trans_date"},
					{title:"Customer Name", field:"cust_name", editor:"input", headerFilter:true},
					{title:"Product Category", field:"category",visible:false},
					{title:"Taxable Amount", field:"txb_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
					{title:"GST Amount", field:"gst_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
					{title:"Invoice Value", field:"net_amt",hozAlign:"right",columnCalcs:"both",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				/*	{title:"Cheese Preference", field:"cheese"},*/
					
				],
			});
			
			  if(response.success == true) {                      

				}   
                    else {                                  

                        $("#error-staff-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-staff-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

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
        }); // /.ajax funciton
        return false;
    });





//Load Staff persons dropdown

$("#salebyperson").load('getStaffPerson');



$("#salebyperson").on('change',function(){


var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".customer_name").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0){

 document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');
}


});






//trigger download of data.csv file

/*document.getElementById("download-csv").addEventListener("click", function(){
    tablestaff.download("csv", "data.csv");
});

//trigger download of data.json file
document.getElementById("download-json").addEventListener("click", function(){
    tablestaff.download("json", "data.json");
});

//trigger download of data.xlsx file
document.getElementById("download-xlsx").addEventListener("click", function(){
    tablestaff.download("xlsx", "data.xlsx", {sheetName:"My Data"});
});
*/
//trigger download of data.pdf file
$("#download-pdf").on('click',function(){
    tablestaff.download("pdf", "data.pdf", {
        orientation:"portrait", //set page orientation to portrait
        title:"Staffwise Sales Report", //add title to report
    });

});
$("#downloadcat-pdf").on('click',function(){
    tablestaff.download("pdf", "data.pdf", {
        orientation:"portrait", //set page orientation to portrait
        title:"Categorywise Sales Report", //add title to report
    });

});


//Staffwise outstanding

//Staffwise Sales report

$("#staffOutstandForm").unbind('submit').bind('submit', function() {
	var form = $(this);
	var url = form.attr('action');
	var type = form.attr('method');
	
eloader.style.display = "block";
	$.ajax({
		url: url,
		type: type,
		data: form.serialize(),
		dataType: 'json',
		success:function(response) {
		  console.log(response);
		   tablestaff = new Tabulator("#stfoutstand-table", {
			data:response, //set initial table data
			groupBy:["staffname"],
			groupClosedShowCalcs:true,
			columns:[
				{title:"Staff Name", field:"staffname",visible:false},
				{title:"Customer Name", field:"cust_name",width:800, editor:"input", headerFilter:true,precision:2},
				{title:"Outstanding Amount", field:"outstand_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
/*					{title:"Height", field:"height"},
				{title:"Favourite Color", field:"col"},
				{title:"Date Of Birth", field:"dob"},
				{title:"Cheese Preference", field:"cheese"},*/
				
			],
		});
		
		  if(response.success == true) {                      

			}   
				else {                                  

					$("#error-staff-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');


$("#error-staff-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

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
	}); // /.ajax funciton
	return false;
});









}); //Document Ready



function getStaff()
{
	var trans_type='SALE';
 url = 'getallStafflist?trans_type='+trans_type;

 managestaffslistTable =  $('#staffslistTable').DataTable( 
	{
	  "ajax"    : url, //+ 'fetchReceiptSearch',
	  "destroy":true,
	  "sort":false,
	  "columns": [
			  { "data": "action" },
			  { "data": "sales_person" }
			],
			'columnDefs': [
				{
					"targets": 0, // your case first column
					"className": "text-center",
					"width": "4%"
			   },
			]				  
   
  
  }); 
 
  
}

function updateStaffbyid(id)
{
	var url='getStaffbyid?id='+id;
	$.ajax({
 
		// Our sample url to make request
		url: url,
		type: "GET",
		success: function (data) {
			var x = JSON.stringify(data);
			eloader.style.display = "none";
			$(".show-edit-staff-result").html(data);
			
		//	managestaffslistTable.ajax.reload(null, false);  
		},

		// Error handling
		error: function (error) {
			console.log(`Error ${error}`);
		}
	});	

}

function deleteStaffUpdate(id)
{
	var url ='deleteStaffbyid?id='+id;
	$.ajax({
 
		// Our sample url to make request
		url: url,
		type: "GET",
		success: function (data) {
			var x = JSON.stringify(data);
			managestaffslistTable.ajax.reload(null, false);  
		},

		// Error handling
		error: function (error) {
			console.log(`Error ${error}`);
		}
	});	
}


function extractTable()
{
	var array = tablestaff.getData(true);
	var json = JSON.stringify(array);
	console.log(json);
}
