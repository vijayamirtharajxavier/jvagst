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
var managecategorylistTable;


$(document).ready(function(){

var url="getCategoryList";
$('#catacc').load(url);
var catid = $("#catacc").val();
$("#catid").val(catid);

$("#catacc").on('change',function(){
	var catid = $("#catacc").val();
	$("#catid").val(catid);
	
});

getallcategorylist();


//Categorywise Sales report	categorySalesForm


$("#categorySalesForm").unbind('submit').bind('submit', function() {
	var form = $(this);
	var url = form.attr('action');
	var type = form.attr('method');
	
	$.ajax({
		url: url,
		type: type,
		data: form.serialize(),
		dataType: 'json',
		success:function(response) {
		  console.log(response);
		   tablecategory = new Tabulator("#categorysales-table", {
			data:response, //set initial table data
			groupBy:["category","invoiceno"],
			groupClosedShowCalcs:true,
			columns:[
				{title:"CATEGORY NAME", field:"category",visible:false},
				{title:"INVOICE #", field:"invoiceno",visible:false},
				{title:"INVOICE DATE", field:"trans_date"},
				{title:"CUSTOMER NAME", field:"cust_name", editor:"input", headerFilter:true},
				{title:"PRODUCT NAME", field:"item_name", editor:"input", headerFilter:true},
				{title:"HSNSAC", field:"item_hsnsac"},
				{title:"UOM", field:"item_unit"},
				{title:"MRP", field:"item_mrp",hozAlign:"right"},
				{title:"QTY", field:"item_qty",hozAlign:"center"},
				{title:"RATE", field:"item_rate",hozAlign:"right"},
				{title:"AMOUNT", field:"item_amount",hozAlign:"right"},
				{title:"TAXABLE AMT", field:"txb_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				{title:"GST AMT", field:"gst_amt",hozAlign:"right",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				{title:"INVOICE AMT", field:"net_amt",hozAlign:"right",columnCalcs:"both",bottomCalc:"sum", bottomCalcParams:{precision:2}},
				{title:"Disc %", field:"discpc",hozAlign:"center"},
				{title:"V-Disc %", field:"vdiscpc",hozAlign:"center"},
				{title:"Difference %", field:"diffpc",hozAlign:"right"},

				/*					{title:"Height", field:"height"},
				{title:"Favourite Color", field:"col"},
				{title:"Date Of Birth", field:"dob"},
				{title:"Cheese Preference", field:"cheese"},*/
				
			],
		});
		
		  if(response.success == true) {                      

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


$("#downloadcat-pdf").on('click',function(){
	var fdate = $("#fdate").val();
	var tdate =$("#tdate").val();
	var splt_fdate = fdate.split("-");
	var splt_tdate = tdate.split("-");
	var f_date = splt_fdate[2] + "-" + splt_fdate[1] + "-" + splt_fdate[0];
	var t_date = splt_tdate[2] + "-" + splt_tdate[1] + "-" + splt_tdate[0];

	var compname = $("#compname").val();
    tablecategory.download("pdf", "data.pdf", {
        orientation:"l", //set page orientation to portrait or landscape
		unit: 'pt', // points, pixels won't work properly
     //   format: [canvas.width, canvas.height],
	 format: [612, 792],
	 		title:compname + " - Categorywise Sales Report for ( " + f_date + " to " + t_date + " )", //add title to report
	});



    });




$("#downloadcat-xls").on('click',function(){
	tablecategory.download("xlsx", "catwisesales.xlsx", {sheetName:"CatewiseSales"});
});

$("#editCategoryForm").unbind('submit').bind('submit', function() {
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
					$("#edit-category-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');


					managecategorylistTable.ajax.reload(null, false);  
$("#edit-category-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

});


				}   
				else {                                  

					$("#error-category-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');


$("#error-category-message").fadeTo(2000, 500).slideUp(500, function(){
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




$("#addCategoryForm").unbind('submit').bind('submit', function() {
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
					$("#add-category-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');
$("#add-category-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

});

$("#addCategoryForm").trigger("reset");
managecategorylistTable.ajax.reload(null, false);
$("#cname").html("");
				}   
				else {                                  

					$("#error-category-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
					  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					  response.messages + 
					'</div>');


$("#error-category-message").fadeTo(2000, 500).slideUp(500, function(){
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




function getallcategorylist()
{
	var url ='getallCategoryList';
	managecategorylistTable =  $('#categorylistTable').DataTable( 
		{
		  "ajax"    : url, //+ 'fetchReceiptSearch',
		  "destroy":true,
		  "sort":false,
		  "columns": [
				  { "data": "action" },
				  { "data": "category_name" }
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



function updateCategorybyid(id)
{
	var url='getCategorybyid?id='+id;
	$.ajax({
 
		// Our sample url to make request
		url: url,
		type: "GET",
		success: function (data) {
			var x = JSON.stringify(data);
			eloader.style.display = "none";
			$(".show-edit-category-result").html(data);
				},

		// Error handling
		error: function (error) {
			console.log(`Error ${error}`);
		}
	});	

}

function deleteCategoryUpdate(id)
{
	var url ='deleteCategorybyid?id='+id;
	$.ajax({
 
		// Our sample url to make request
		url: url,
		type: "GET",
		success: function (data) {
			var x = JSON.stringify(data);
			managecategorylistTable.ajax.reload(null, false);  
		},

		// Error handling
		error: function (error) {
			console.log(`Error ${error}`);
		}
	});	
}

