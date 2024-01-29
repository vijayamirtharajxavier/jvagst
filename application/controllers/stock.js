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

var url="getCategoryList";
$('#catacc').load(url);
var catid = $("#catacc").val();
$("#catid").val(catid);

$("#catacc").on('change',function(){
	var catid = $("#catacc").val();
	$("#catid").val(catid);
	
});




//Categorywise Sales report	categorySalesForm


$("#stockdetailsForm").unbind('submit').bind('submit', function() {
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
		   tablecategory = new Tabulator("#stockdetails-table", {
			data:response, //set initial table data
			groupBy:["category"],
			groupClosedShowCalcs:true,
			columns:[
				{title:"CATEGORY NAME", field:"category",visible:false},
				{title:"PROECT NAME #", field:"prod_name",width:510},
				{title:"OP-STOCK", field:"opstock",hozAlign:"right"},
				{title:"INWARD", field:"inward",hozAlign:"right"},
				{title:"OUTWARD", field:"outward",hozAlign:"right"},
				{title:"CLOSING STOCK", field:"cl_stock",hozAlign:"right",precision:3},
				
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




/*
//trigger download of data.pdf file
document.getElementById("downloadstock-pdf").addEventListener("click", function(){
    tablecategory.download("pdf", "data.pdf", {
        orientation:"portrait", //set page orientation to portrait
        title:"Stock Summary Report", //add title to report
    });
});

*/




$("#opadd_btn").on('click',function(){
	console.log('add btn clicked');
	var acct_name = $("#item_name").val();
	var acct_id= $("#item_id").val();
	var opbal_amt= $("#open_stock").val();
	console.log('Record ' + acct_name + acct_id + ' amt : ' + opbal_amt);
	var tbl="";
	//array("ldger_id"=>$ldg_id,"open_bal"=>$opbal_amt,"finyear"=>$finyear,"company_id"=>$compId);
	
	$.ajax({
		url: 'post_OpBal',
		data: {'acct_id':acct_id, 'opbal_amt':opbal_amt}, 
		success: function(result) {
		//	  alert('SUCCESS');
	
	
	
	
		}
	  });
	managestockopTable.ajax.reload(null, false);
	
	$("#item_name").val("");
	$("#open_stock").val("");
	$("#item_name").focus();
	
	});
	
	
	
	
$('.itemname').autocomplete({
    source: function (request, response) {
        $.getJSON("getproductdatabysearch?itemkeyword=" + request.term, function (data) {
            response($.map(data, function (value, key) {
             var nm=value['prod_name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },
      select: function(e,ui) {
console.log(ui);
$.getJSON("getproductbyname?itemkeyword=" + ui.item.value, function (data, status) {
console.log(data);
          $.map(data, function (value, key) {


//curr_row = $(".trrow").data("row");
//var gst_pc = $('#'+curr_row).find('.item_gstpc').val();
console.log(curr_row);
//$('#'+curr_row).find('.itemrate').val(data.rate);
var url ="getProductUnit";
$('#'+curr_row).find(".itemunit").load(url);
$('#'+curr_row).find(".itemrate").val(value['prod_rate']);
$('#'+curr_row).find(".itemdesc").val(value['prod_desc']);
$('#'+curr_row).find(".itemhsnsac").val(value['prod_hsnsac']);
$('#'+curr_row).find(".itemgstpc").val(value['prod_gstpc']);
$('#'+curr_row).find(".itemmrp").val(value['prod_mrp']);
$('#'+curr_row).find(".stock").val(value['prod_stock']);
$('#'+curr_row).find(".itemid").val(value['id']);
$('#'+curr_row).find(".itemqty").focus();
//console.log(value);
if(value['stock']>0)
{
$('#'+curr_row).find(".stock").css("border-color","green"); 
}
else
{
$('#'+curr_row).find(".stock").css("border-color","red");   
}
if(flag=="SALE")
{
var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0){

 document.getElementById("save_btn").disabled = false; 
$('#save_btn').removeClass('btn-default').addClass('btn-success');
}
else {
   document.getElementById("save_btn").disabled = true; 
   $('#save_btn').removeClass('btn-success').addClass('btn-default');
}
}
else
{
	document.getElementById("save_btn").disabled = false; 
	$('#save_btn').removeClass('btn-default').addClass('btn-success');
	
}

});

});              
//        console.log(data);
        //output selected dataItem
        },
//    minLength: 2,
    autoFocus: true,
    delay: 100
});


	
	
	



}); //Document Ready




