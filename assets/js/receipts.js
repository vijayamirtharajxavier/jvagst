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
var managereceiptlistTable;

$(document).ready(function(){

getreceiptlist();
aloader = document.querySelector(".aloader");
aloader.style.display = "none";
eloader = document.querySelector(".eloader");
eloader.style.display = "none";




//Transaction : Receipt - Add

$("#addTransactionForm").unbind('submit').bind('submit', function() {
	var form = $(this);
	var url = form.attr('action');
	var type = form.attr('method');
aloader.style.display = "block";
	$.ajax({
			url: url,
			type: type,
			data: form.serialize(),
			dataType: 'json',
			success:function(response) {
				console.log(response);
					if(response.success == true) {                      
						aloader.style.display = "block";
									$("#add-receipt-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.messages + 
									'</div>');



$("#add-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").slideUp(500);

});


$("#addTransactionForm").trigger("reset");
managereceiptlistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
							}   
							else {                                  

									$("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
										'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
										response.messages + 
									'</div>');


$("#error-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
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
																					
							} ///else
			} //success
	}); //ax funciton
	return false;
});




















//Add receipt Message

    $("#addReceiptForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');
aloader.style.display = "block";
        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
              console.log(response);
                if(response.success == true) {                      
                  aloader.style.display = "block";
                        $("#add-receipt-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addReceiptForm").trigger("reset");
managereceiptlistTable.ajax.reload(null, false);
//$("#InvoiceItems tbody tr").remove(); 
//$("#cname").html("");
                    }   
                    else {                                  

                        $("#error-product-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
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
                                                
                    } ///else
            } //success
        }); //ax funciton
        return false;
    });




//Edit receipt Messge


    $("#editReceiptForm").unbind('submit').bind('submit', function() {
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
                        $("#edit-receipt-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


managereceiptlistTable.ajax.reload(null, false);  
$("#edit-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


                    }   
                    else {                                  

                        $("#error-receipt-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


$("#error-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
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
            } ///.success
        }); //ajax funciton
        return false;
    });


//Load receipt persons dropdown




}); //Document Ready


function getreceiptlist()
{
  //receipt list


 urlstr = 'getallreceiptlist';
 url = urlstr.replace("undefined","");
//managereceiptlistTable = $("#receiptlistTable").dataTable().fnDestroy();
 managereceiptlistTable =  $('#receiptlistTable').DataTable( 
  {
    "ajax"    : url, //+ 'fetchReceiptSearch',
    "destroy":true, 
"columns": [
            { "data": "action" },
            { "data": "trans_id" },
            { "data": "trans_date" },
            { "data": "db_name" },
            { "data": "cr_name" },
            { "data": "trans_amount" },
            { "data": "trans_ref" },
            { "data": "narration" }

        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
 {
      "targets": 5,
      "className": "text-right"
 },

 ]


}); 
    
   



}


function getreceipt()
{
  $.get("getallreceiptlist",function(data,status){
    console.log(data);
  });

 
  
}

function printTransid(id)
{
  //Pirint
console.log('invprint ' + id);
  //$.get("getInvoiceprintbyid?id="+id,function(data,status){
 //   console.log(data);
var w = window.open("getInvoiceprintbyid?id="+id);

// If the window opened successfully (e.g: not blocked)
if ( w ) {
    w.onload = function() {
        // Do stuff
        console.log('Loadeed successfully');
//        w.print();
//        w.close();
    };
}

}



function deleteTransid(id)
{
console.log('record id for delete ' + id);  

$("#delete_btn").on('click',function(){
ttype='RCPT';
  $.get("deleteTransactionbyid?id="+id+"&trans_type="+ttype,function(data,status){

//console.log(datasuccess);
var d= JSON.parse(data);
//console.log(d);
console.log(d.success);

                if(d.success == true) {                      
                        $("#delete-receipt-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          d.messages + 
                        '</div>');

managereceiptlistTable.ajax.reload(null, false);
  
$("#delete-receipt-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});

$("#deleteModal").modal('hide');

}

});

});



}



function updateTransid(id)
{
console.log('record id for update ' + id);
  $.get("getreceiptbyid?id="+id,function(data,status){
 //   console.log(data);
//var data = JSON.parse(data);
     /*data.forEach(function(d) {
      $("show-edit-receipt-result").appen();
});*/

$(".show-edit-receipt-result").html(data);

});

$("#modalEditreceipt").modal({

  backdrop: 'static',
    keyboard: true
});




}

function pymtpdfTransid(id)
{
var trans_type='PYMT';
var w = window.open("printreceiptpayment_pdf?id="+id + "&trans_type=" + trans_type);

// If the window opened successfully (e.g: not blocked)
if ( w ) {
    w.onload = function() {
        // Do stuff
        console.log('Loadeed successfully');
//        w.print();
//        w.close();
    };
}



}



function rcptpdfTransid(id)
{
var trans_type='RCPT';
var w = window.open("printreceiptpayment_pdf?id="+id + "&trans_type=" + trans_type);

// If the window opened successfully (e.g: not blocked)
if ( w ) {
    w.onload = function() {
        // Do stuff
        console.log('Loadeed successfully');
//        w.print();
//        w.close();
    };
}



}




 // Single Select


$(document).on('keydown','.dbaccount', function() { 
 
console.log('cust name search');
$('.dbaccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?flag=csh&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['account_name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },

      /*select: function(e,ui) {

$.getJSON("getledgerdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
//console.log(data);
          $.map(data, function (value, key) {

$("#gstin").val(value['gstin']);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0)
{
document.getElementById("save_rbtn").disabled = false; 
$('#save_rbtn').removeClass('btn-default').addClass('btn-success');
}
else {
document.getElementById("save_rbtn").disabled = true; 
$('#save_rbtn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },*/
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});



$(document).on('keydown','.craccount', function() { 
 
console.log('cust name search');
$('.craccount').autocomplete({
    source: function (request, response) {
        $.getJSON("getcashledgerdatabyname?flag=rct&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['account_name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },

      /*select: function(e,ui) {

$.getJSON("getledgerdatabysearch?itemkeyword=" + ui.item.value, function (data, status) {
//console.log(data);
          $.map(data, function (value, key) {

$("#gstin").val(value['gstin']);

var sp = $("#salebyperson").val();
var vn = $("#customer_name").val().length;
var inm = $(".itemname").val().length;
 x = document.getElementById("InvoiceItems").rows.length-1;
if(x>0 && vn>0 && sp>0 && inm>0)
{
document.getElementById("save_rbtn").disabled = false; 
$('#save_rbtn').removeClass('btn-default').addClass('btn-success');
}
else {
document.getElementById("save_rbtn").disabled = true; 
$('#save_rbtn').removeClass('btn-success').addClass('btn-default');
}


});

});              
//        console.log(data);
        //output selected dataItem
        },*/
//    minLength: 2,
    autoFocus: true,
    delay: 100
});



});
