var disp_yr;
$(document).ready(function() {
	var current_year = new Date().getFullYear()
	var amount_of_years = 0
	var n = amount_of_years+1;
   var nx_yr;
   var year;
   console.log('cyr' + current_year);
   nx_yr=current_year;
	 for (var i = 0; i < amount_of_years+1; i++) {
	   year = (current_year-i);
	   console.log('yr' + (year));
	   nx_yr=(current_year+n);
	   console.log('nx_yr' + nx_yr);
	   var nyear=nx_yr.toString();
	   console.log('nyr' + nyear);
	    disp_yr = year + '-' + nyear.substring(4,nyear.length-2) ;
	   var element = '<option value="' + disp_yr + '">' + disp_yr + '</option>';
	   $('select[name="financial_year"]').append(element)
	   --n;
	 }

	 getsettingslist();

	 $("#fyear").val(disp_yr);
	 console.log(disp_yr);
   
	
	 financial_year.addEventListener("change", e => {
		fyear.innerHTML = e.target.value;
	 })

	
	})

	


   $("#financial_year").on('change',function(){
	console.log($(this).val());
	$(".modal-title").find("#fyear").val($(this).val());
	var myBookId = $(this).val();
	$(".modal-title #fyear").val(myBookId);



   });

   function addSerial()
   {
	console.log("AddSerial");
	$("#fy").val(disp_yr);
   }

   function getsettingslist()
   {
	   //Sales list
   
   
	urlstr = 'getallSettingslistbycid';
	url = urlstr.replace("undefined","");
   //managepurchaselistTable = $("#purchaselistTable").dataTable().fnDestroy();
	managerfinyearTbl =  $('#finyearTbl').DataTable( 
	   {
		   "ajax"    : url, //+ 'fetchReceiptSearch',
		   "destroy":true,
			
   "columns": [
						   { "data": "action" },
						   { "data": "inv_prefix" },
						   { "data": "inv_no" },
						   { "data": "inv_suffix" },
						   { "data": "cn_prefix" },
						   { "data": "cn_no" },
						   { "data": "cn_suffix" },
						   { "data": "dn_prefix" },
						   { "data": "dn_no" },
						   { "data": "dn_suffix" },
						   { "data": "rct_prefix" },
						   { "data": "rct_no" },
						   { "data": "rct_suffix" },
						   { "data": "pyt_prefix" },
						   { "data": "pyt_no" },
						   { "data": "pyt_suffix" },
						   { "data": "cnt_prefix" },
						   { "data": "cnt_no" },
						   { "data": "cnt_suffix" },
						   { "data": "jrn_prefix" },
						   { "data": "jrn_no" },
						   { "data": "jrn_suffix" }
				   ],
   
   'columnDefs': [
	   {
			   "targets": 0, // your case first column
			   "className": "text-center",
			   "width": "4%"
	},
	{
			   "targets": 5,
			   "className": "text-center"
	},
	{
			   "targets": [6,7,8],
			   "className": "text-right"
	},
   
	]
   
   
   }); 
		   
		
   
   
   
   }
   





$('#fromDate').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm-yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });



$(document).on('click','#mn', function() { 

console.log('Month ' + $(this).val());
console.log('Quarter ' + $("qr").val());
document.getElementById("gstr3b_quater").disabled = true;
document.getElementById("fromDate").disabled = false;
document.getElementById("search_btn").disabled = false;

flag='M';
});


$(document).on('click','#qr', function() { 

console.log('Quarter ' + $(this).val());
console.log('Month ' + $("mn").val());
document.getElementById("fromDate").disabled = true;
document.getElementById("gstr3b_quater").disabled = false;
document.getElementById("search_btn").disabled = false;

flag='Q';
});









// 3.1
$('#search_btn').on('click',function(){
 
 if(flag=='M')
 {
   let url ='fetch_gstr3b';

 let fmDate= $('#fromDate').val();
   
        console.log('Ledger Account'+fmDate);

// var fmDate= $('#fromDate').val();
 
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr3bdata").html(data);

});

// 3.2
 url ='fetch_gstr32b';
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr32bdata").html(data);
console.log("gstr32bdata" + data);
});

//ITC
 url ='fetch_gstr34b';
   
        console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr34bdata").html(data);
//console.log("gstr34bdata " + data);

});

//Zero Rated Purchases
 url ='fetch_gstr3b5';
   
       // console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){
console.log("zero rated " + data);
$("#gstr3b5data").html(data);

});

} // Monthly


 if(flag=='Q')
 {
 let url ='fetch_gstr3b';

 let fmDate= $('#gstr3b_quater').val();
   
        console.log('Ledger Account'+fmDate);

// var fmDate= $('#fromDate').val();
 
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr3bdata").html(data);

});

// 3.2
 url ='fetch_gstr32b';
   
        console.log('Ledger Account'+fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr32bdata").html(data);
console.log("gstr32bdata" + data);
});

//ITC
 url ='fetch_gstr34b';
   
        console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){

$("#gstr34bdata").html(data);
//console.log("gstr34bdata " + data);

});

//Zero Rated Purchases
 url ='fetch_gstr3b5';
   
       // console.log('Ledger Account' +fmDate);
  $.get(url+'?fdate='+fmDate+'&flag='+flag,function(data,status){
console.log("zero rated " + data);
$("#gstr3b5data").html(data);

});

} // Quarterly





 
});

