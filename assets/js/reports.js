$(document).ready(function(){
console.log('report js');
	$("#gstreturnstatusForm").unbind('submit').bind('submit', function() {
		var form = $(this);
		var url = form.attr('action');
		var type = form.attr('method');
//	aloader.style.display = "block";
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
	

	$('#gstreturn_referesh').on('click',function(){
		console.log('refresh btn clicked');
		let url ='cwms_report';
		$.ajax({
			url: 'gst_returns_status',
	//		data: {'acct_id':id}, 
			success: function(result) {
	console.log(result);
//	$("#gstreturndata").val(result);
	$("#gstreturndata").html(result);

			//	  alert('Record Deleted Successfully....!!!');
		
				//  manageproductopTable.ajax.reload(null, false);
	
		
		
			}
		  });
		   
});



	}); //Document 
	
	


$('#fy').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, 1));
        }
    });

// 3.1
$('#search_btn').on('click',function(){
 let url ='cwms_report';
 
 var fyear= $('#fy').val();
 
   
    
  $.get(url+'?fy='+fyear,function(data,status){

$("#monthcwmsTbl tbody").html(data);

});


 
});

