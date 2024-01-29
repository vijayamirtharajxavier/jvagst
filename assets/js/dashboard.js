let url ='dashboard/getmsalespurhcase';
   
        console.log('Sales & Purchase Data');
  $.get(url,function(data,status){

$("#monthtransTbl tbody").html(data);

});



 url ='dashboard/getmgstsalespurhcase';
   
        console.log('Sales & Purchase GST Data');
  $.get(url,function(data,status){

$("#monthgstTbl tbody").html(data);

});

//$("#finyear").load(base_url + finurl);
$(document).on('click','#changecomp', function(){
	console.log('btn clicked for change company');
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
	url: 'dashboard/getcompany',
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
/*			var furl = base_url + 'dashboard/set_session?id='+id+'&finyear='+finyear+'&curr_url='+curr_url;
			
			//window.location.href = furl;                  
		window.location.replace(furl);
				$('.form-group').removeClass('has-error').removeClass('has-success');
				$('.text-danger').remove(); 



$.ajax({
	type: "POST",
	url: base_url + 'dashboard/set_session',
	data: '{"id":id,"finyear":finyear,"curr_url":curr_url}',
	contentType: "application/json; charset=utf-8",
	dataType: "json",
	}).done(function (response) {
	//	console.log(response);
	d1.resolve(response);
	});


$.post(base_url + 'dashboard/set_session', {id:id, finyear:finyear,curr_url:curr_url}, function(response){ 
    //  alert("success");
     // $("#mypar").html(response.amount);
		 console.log("res" + response);
});

*/
			},
	}) ;
	
	
	
	});
	
