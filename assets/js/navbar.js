var base_url = window.location.origin + '/';
console.log(base_url);
var finurl ="dashboard/fetchFinyearSettings";
//getProfile();

//getCompany();


$("#finyear").load(base_url + finurl);


function getSettings()
{
//var base_url = "<?php echo base_url();?>";
var url = "get_settings";


            $.ajax({
                url:base_url + url,
                dataType:   "jsonp", // <== JSON-P request
                success:    function(data){
                   // alert(weblink); // this statement doesn't show up
                    $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
            $("#invoice_number").val(entry.inv_no);
        $("#invoice_prefix").val(entry.inv_prefix);
        $("#invoice_suffix").val(entry.inv_suffix);

        $("#receipt_number").val(entry.receipt_no);
        $("#receipt_prefix").val(entry.receipt_prefix);
        $("#receipt_suffix").val(entry.receipt_suffix);

        $("#payment_number").val(entry.payment_no);
        $("#payment_prefix").val(entry.payment_prefix);
        $("#payment_suffix").val(entry.payment_suffix);

        $("#contra_number").val(entry.contra_no);
        $("#contra_prefix").val(entry.contra_prefix);
        $("#contra_suffix").val(entry.contra_suffix);

        $("#leadzero").val(entry.leading_zero);        

                    });
//                    alert(userList); // <== Note I've moved this (see #2 above)
                }
            });






  /*     $.getJSON(base_url + url, function(data) {
//        console.log(data);
//        console.log(data.inv_no);
        $("#invoice_number").val(data.inv_no);
        $("#invoice_prefix").val(data.inv_prefix);
        $("#invoice_suffix").val(data.inv_suffix);

        $("#receipt_number").val(data.receipt_no);
        $("#receipt_prefix").val(data.receipt_prefix);
        $("#receipt_suffix").val(data.receipt_suffix);

        $("#payment_number").val(data.payment_no);
        $("#payment_prefix").val(data.payment_prefix);
        $("#payment_suffix").val(data.payment_suffix);

        $("#contra_number").val(data.contra_no);
        $("#contra_prefix").val(data.contra_prefix);
        $("#contra_suffix").val(data.contra_suffix);

        $("#leadzero").val(data.leading_zero);        

        });
*/

}




function showCompany(userid)
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
url: 'login/getcompany?user_id='+userid,
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

function getCompany()
{

  var url ="accounts/get_company";

$.ajax({url:base_url + url,
 dataType:   "jsonp", // <== JSON-P request
 success:function(data){
                   // alert(weblink); // this statement doesn't show up
 $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
        $("#companyname").val(entry.companyname);
        $("#companygstin").val(entry.companygstin);
        $("#companyaddress").val(entry.companyaddress);
$("#companycontact").val(entry.companycontact);
        $("#companycity").val(entry.companycity);
        $("#companypincode").val(entry.companypincode);
        $("#companyemail").val(entry.companyemail);

        $("#companystatecode").val(entry.companystatecode);
        $("#companybank").val(entry.companybank);

});
}
})
}
/*
       $.getJSON(base_url + url, function(data) {
//        console.log(data);
        //console.log(data.inv_no);
        $("#companyname").val(data.companyname);
        $("#companygstin").val(data.companygstin);
        $("#companyaddress").val(data.companyaddress);
$("#companycontact").val(data.companycontact);
        $("#companycity").val(data.companycity);
        $("#companypincode").val(data.companypincode);
        $("#companyemail").val(data.companyemail);

        $("#companystatecode").val(data.companystatecode);
        $("#companybank").val(data.companybank);
        });

       */

function getProfile()
{
var user_url = "accounts/fetchUserProfile";
/*
$.getJSON(base_url + user_url, function(data) {
  //      console.log(data);
$("#firstname").val(data.firstname);
$("#lastname").val(data.lastname);
$("#email").val(data.email);


});

*/


$.ajax({
 url:base_url + user_url,
 dataType:   "jsonp", // <== JSON-P request
 success:    function(data){
                   // alert(weblink); // this statement doesn't show up
 $.each(data.result, function(entryIndex, entry){ // <=== Note, `data.results`, not just `data`
                     //   userList.push(entry['from_user']); // <=== Or `entry.from_user` would also work (although `entry['from_user']` is just fine)
$("#firstname").val(entry.firstname);
$("#lastname").val(entry.lastname);
$("#email").val(entry.email);

});
//                    alert(userList); // <== Note I've moved this (see #2 above)
}
});

}



$(document).on('change','#finyear', function(){
var newfinyear = $("#finyear").val();

console.log(newfinyear);
$.ajax({ url: base_url + "dashboard/changeFinyear?newfinyear=" + newfinyear ,success: function(result){
window.location.reload(false); 
  }
  //  headers: {'X-Requested-With': 'XMLHttpRequest'}
});


});


$(document).on('keyup','#confirmpass',function(){
let cnpass = $(this).val();
let nwpass = $("#newpass").val();
if(nwpass==cnpass)
{
          //border-color: #ff80ff;
 $("#confirmpass").css("border-color","green");  
}
else
{
 $("#confirmpass").css("border-color","red");  
  //$("#confirmpass").focus();
}

});


var surl = "inventory/getStates";

$("#companystatecode").load(base_url + surl);


//$("#finyear").load(base_url + finurl);
$(document).on('click','#changecomp', function(){
	console.log('btn clicked for change company ' + base_url);
	var url =base_url +'dashboard/getcompany';
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
	url: base_url + 'dashboard/getcompany',
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
//			var email=response.email;
			var finyear=selectRowItem.finyear;
//			var userid = response.userid;
//			var authkey=response.authkey;
//			var compid = selectRowItem.company_id;
		  var curr_url = 	window.location.href;

			// console.log(id);
	//                              var furl = 'login/log?id='+id+'&email='+email+'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
			//var furl = 'login/log?id='+id+'&email='+email+'&compid='+compid +'&finyear='+finyear+'&userid='+userid+'&authkey='+authkey;
		 // console.log(furl);
			//window.location.href = furl;                  
	/*var furl = base_url + 'dashboard/set_session?id='+id+'&finyear='+finyear+'&curr_url='+curr_url;
	
			window.location.replace(furl);
				$('.form-group').removeClass('has-error').removeClass('has-success');
				$('.text-danger').remove(); 
*
				$.post(base_url + 'dashboard/set_session', {id:id, finyear:finyear,curr_url:curr_url}, function(response){ 
					//  alert("success");
					 // $("#mypar").html(response.amount);
					 console.log(response);
			});
			*/
			
			},
	}) ;
	
	
	
	});
	