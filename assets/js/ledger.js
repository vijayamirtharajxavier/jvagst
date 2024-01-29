var manageLedgerTable;
var manageLedgerOpBal;
$(document).ready(function(){
$('#gst_spinner').hide();
document.getElementById("tick").classList.remove("fa-check-circle");
document.getElementById("tick").classList.remove("fa-spinner");
document.getElementById("tick").classList.remove("fa-spin");

var opbalurl = 'ledgers/getopenbal';
url = opbalurl.replace("undefined","");
manageLedgerOpBal = $('#ledgeropTable').DataTable({
"destroy":true,
"ajax": url,

"columns": [
            { "data": "name" },
            { "data": "openbal" }
],

"columnDefs": [
  {
      "targets": 0, // your case first column
      "className": "text-left",
      "width": "150px"
 },
  {
      "targets": 1, // your case first column
      "className": "text-right"
      
 }
 ]
});



var grpurl = 'ledgers/getLedgerGroup';

$("#ledgergroup").load(grpurl);
$("#ledgergroup").select2();



var stateurl = 'ledgers/getStates';

$("#ledgerstate").load(stateurl);
$("#ledgerstate").select2();


    console.log('Search Clicked');
 urlstr = 'ledgers/getLedger';
 url = urlstr.replace("undefined","");
 //  date("d-m-Y", strtotime($originalDate));
//console.log('fmDate ' + fmDate + ' toDate ' + toDate);
//manageProductTable = $("#productTable").dataTable().fnDestroy();
 manageLedgerTable =  $('#ledgerTable').DataTable( 
  {
    "destroy": true,
    "ajax"    : url, //+ 'fetchReceiptSearch',

"columns": [
            { "data": "action" },
            { "data": "name" },
            { "data": "gstin" },
            { "data": "contact" },
            { "data": "email" },
            { "data": "statecode" },
            { "data": "bustype" },
            { "data": "groupname" },
            { "data": "address" }
        ],

'columnDefs': [
  {
      "targets": 0, // your case first column
      "className": "text-center",
      "width": "4%"
 },
  {
      "targets": 1, // your case first column
      "className": "text-left",
      "width": "150px"
 },
 {
      "targets": [5, 6, 7],
      "className": "text-right"
 },

 ],

        dom: 'Bfrtip',
       
        buttons: [
            'copy', 'csv', 'excel',{
            extend: 'pdf',


title: function() {
      return $('#monthYear').val();
    },

 //title: system_name + '\n' + 'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
  customize: function(doc) {
    doc.styles.title = {
      color: 'red',
      fontSize: '40',
      background: 'blue',
      alignment: 'center'

    }   


  },

               exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },   
          
            orientation: 'portrait', // 'landscape',


            customize: function (doc) {
                  var rowCount = doc.content[1].table.body.length;
/*for (i = 1; i < rowCount; i++) {
//doc.content[1].table.body[i][5].alignment = 'right';
//doc.content[1].table.body[i][6].alignment = 'right';
doc.content[1].table.body[i][5].alignment = 'right';
doc.content[1].table.body[i][6].alignment = 'right';
doc.content[1].table.body[i][7].alignment = 'right';
doc.content[1].table.body[i][8].alignment = 'right';
doc.content[1].table.body[i][9].alignment = 'right';
};
*/

      doc.pageMargins = [20,10,10,10];
        doc.defaultStyle.fontSize = 7;
        doc.styles.tableHeader.fontSize = 8;
        doc.styles.title.fontSize = 10; 
        // Remove spaces around page title
        doc.content[0].text = doc.content[0].text.trim();

      doc['footer']=(function(page, pages) {
            return {
                columns: [
                    //'Receipts Report for the period from '+ $('#fmDate').val() + ' to '+ $('#toDate').val(),
                    {
                        // This is the right column
                        alignment: 'right',
                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                    }
                ],
                margin: [10, 0]
            }
        });

},
         }, {extend: 'print',

  

                                  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },
      }

        ]




}); 
    
/*

$('#ledgerstate').change(function(){
    var value = $(this).val();
console.log('chg val ' + value);
    // Set selected 
    $('#ledgerstate').val(value);
    $('#ledgerstate').select2().trigger('change');

  });
*/

   }); //Document.ready

//Edit Product Message

    $("#editLedgerForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#edit-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#edit-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


//$("#editLedgerForm").trigger("reset");
manageLedgerTable.ajax.reload(null, false);
                    }   
                    else {                                  

                        $("#error-ledger-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#error-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
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



//Add Product Message

    $("#addLedgerForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        var url = form.attr('action');
        var type = form.attr('method');

        $.ajax({
            url: url,
            type: type,
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                if(response.success == true) {                      
                        $("#add-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#add-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);

});


$("#addLedgerForm").trigger("reset");
manageLedgerTable.ajax.reload(null, false);
                    }   
                    else {                                  

                        $("#error-ledger-message").html('<div class="alert alert-danger alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                          response.messages + 
                        '</div>');


  
$("#error-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
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



$(document).on('keyup','#ledgergstin',function(){
var gstpan = $("#ledgergstin").val();
$("#ledgerpan").val(gstpan.substring(2,12));


//console.log('gstnum ' + $(this).val());
if(gstpan.length==15)
{
	var pan=$("#ledgerpan").val();
	$('#gst_spinner').show();

	//console.log('gstleng ' + $("#ledgergstin").val().length);
//	console.log('final pan : ' + pan);
//document.getElementById("tick").classList.add("fa-spinner fa-spin");
document.getElementById("tick").classList.remove("fa-times-circle");
document.getElementById("tick").classList.remove("fa-check-circle");
document.getElementById("tick").classList.add("fa-spinner");
document.getElementById("tick").classList.add("fa-spin");

	$.ajax({
		url: 'ledgers/verifygst?gstnum='+pan.trim(),
		
		success:function(data) {
	//	  console.log(data);
		  var json_data = JSON.parse(data);
	 if(json_data['error']==false)
	 {
		console.log('data len : ' + json_data['data'].length);
if(json_data['data'].length>0)
{
		for (let i = 0; i < json_data['data'].length; i++) {
//			const element = array[i];

//console.log(json_data['data'][i]['gstin']);






		if($("#ledgergstin").val()==json_data['data'][i]['gstin'] && json_data['data'][i]['sts']=="Active")
		{
		  console.log(json_data['data'][i]['tradeNam']);
		  $("#ledgername").val(json_data['data'][i]['tradeNam']);
		  $("#ledgeraddress").val(json_data['data'][i]['pradr']['addr']['st'] +', '+json_data['data'][0]['pradr']['addr']['loc']);
		  $("#ledgercity").val(json_data['data'][i]['pradr']['addr']['dst']);
		  $("#ledgerpincode").val(json_data['data'][i]['pradr']['addr']['pncd']);
//console.log(json_data['data'][i]['gstin'].substr(0,2));
	//	  $("#ledgerstate option:contains(" + json_data['data'][0]['pradr']['addr']['stcd'].trim() + ")").attr('selected', 'selected');
	  $("#ledgerstate").val(parseInt(json_data['data'][i]['gstin'].substr(0,2))).attr('selected', 'selected');
	$("#ledgerstate").select2().trigger('change');

		  $('#gst_spinner').hide();
		  $("#sts").val(json_data['data'][i]['sts']);
		  const gstin = document.getElementById("ledgergstin");
gstin.setAttribute("class", "gstsuccess"); 
//document.getElementById("ledgergstin").classList.add("field");
//document.getElementById("tick").classList.remove("fa-times-circle");
document.getElementById("tick").classList.remove("fa-spinner");
document.getElementById("tick").classList.remove("fa-spin");

//document.getElementById("tick").classList.remove("fa-spinner fa-spin");

document.getElementById("tick").classList.add("fa-check-circle");
document.getElementById("tick").style.color = 'green';
console.log(json_data['data'][i]['gstin'] + ' - ' +json_data['data'][i]['sts']);

//gstin.classList.remove("field");
//		  document.getElementById("ledgergstin").className = document.getElementById("ledgergstin").className + " success";  // this adds the success class
		 
		 // $(".show-result-ledger").html(response);
		 break;
		}
		else if($("#ledgergstin").val()==json_data['data'][i]['gstin'] && json_data['data'][i]['sts']=="Cancelled")
		{
			const gstin = document.getElementById("ledgergstin");
			gstin.setAttribute("class", "gsterror"); 
			//			document.getElementById("ledgergstin").className = document.getElementById("ledgergstin").className + " error";  // this adds the error class
			$('#gst_spinner').hide();
			$("#ledgername").val("");
			$("#ledgeraddress").val("");
			$("#ledgercity").val("");
			$("#ledgerpincode").val("");
  
			$("#sts").val(json_data['data'][i]['sts']);
			console.log(json_data['data'][i]['gstin'] + ' - ' +json_data['data'][i]['sts']);
document.getElementById("tick").classList.remove("fa-spinner");
document.getElementById("tick").classList.remove("fa-spin");
			document.getElementById("tick").classList.remove("fa-check-circle");
			document.getElementById("tick").classList.add("fa-times-circle");
			document.getElementById("tick").style.color = 'red';
			break;
		}

	}

}



		}
		  else
		  {
			const gstin = document.getElementById("ledgergstin");
			gstin.setAttribute("class", "gsterror"); 
			//	document.getElementById("ledgergstin").className = document.getElementById("ledgergstin").className + " error";  // this adds the error class
//			$('#gst_spinner').hide();
//			$('#gst_spinner').hide();
			$("#ledgername").val("");
			$("#ledgeraddress").val("");
			$("#ledgercity").val("");
			$("#ledgerpincode").val("");
document.getElementById("tick").classList.remove("fa-spinner");
document.getElementById("tick").classList.remove("fa-spin");

//			document.getElementById("tick").classList.remove("fa-spinner fa-spin");
			document.getElementById("tick").classList.remove("fa-check-circle");
			document.getElementById("tick").classList.add("fa-times-circle");
			document.getElementById("tick").style.color = 'red';

			}
}
});



}


});








function updateLedgerbyid(id)
{
  console.log('getLedger for Update ' + id);
 var url="ledgers/getLedgerforUpdate";
        $.ajax({
            url: url+'?id='+id,
            
            success:function(response) {
              //console.log(response);
              $(".show-result-ledger").html(response);

}
});


}

function deleteUpdate(id)
{

$('#delRec').on('click',function() {
   // var id = $this.val();
console.log('delete '+ id);
$('#deleteModal').modal('hide');

    var urlstr =  'ledgers/deleteLedger';
var url = urlstr.replace("undefined","");
//console.log(url);
    $.ajax({
        url: url+'?id='+id,
        dataType: 'JSON',
        success:function (response) 
        {

                            manageLedgerTable.ajax.reload(null, false);                  
                            //console.log(response);
                            if(response.success == true) {    
                     manageLedgerTable.ajax.reload(null, false);                  
                                $("#delete-ledger-message").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                  response.messages + 
                                '</div>');

    $('#deleteModal').modal('hide');
                                      
$("#delete-ledger-message").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
});             
                                
                                $('.form-group').removeClass('has-error').removeClass('has-success');
                                $('.text-danger').remove(); 
                               // $("#addSalesInvoiceTable:not(:first)").remove();                                
                                //createTypeahead($td.find('input.edititemSearch'));
                                //manageExpeneseTable.ajax.reload(null, false);
                                
                                                                
                            }   
                            else {                                  
                            //  console.response;
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



$(document).on('keydown','.ledgername', function() { 
 
console.log('ldg name search');
$('.ledgername').autocomplete({
    source: function (request, response) {
        $.getJSON("accounts/getledgerdatabyname?flag=rct&itemkeyword=" + request.term, function (data) {

            response($.map(data, function (value, key) {
          //   console.log(value);
             var nm=value['name'];
                return {
                     label:nm
                     //value:key
                    //value: key
                };
            }));
        });
    },

    autoFocus: true,
    delay: 100
});



});


