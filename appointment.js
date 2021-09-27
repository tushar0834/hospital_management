$(document).ready(function(){
	$.ajax({
		url: "/app/doctor/get.php",
		type: "POST",
		data:{"appointement_page": "1"},
		dataType: "JSON",
		beforeSend:function(){

		},
		success:function(data)
		{
			for(var i=0;i<data[1].length;i++)
			{
				var html='<div class="card card-1" style="margin-top: 5%;margin-bottom: 5%; width: 123vh;">'+
			
			  '<img src="images/'+data[1][i]['image']+'" class="card-img-top img-thumbnail"  alt="..." style="height: auto;">'+
			  '<div class="card-body mx-auto" style="    width: 100vh;">'+
			    '<h1 class="card-title" style="font-size: -webkit-xxx-large;">Dr. '+data[1][i]['doctor_full_name']+'</h1>'+
			    '<p class="card-title">Speciality: '+data[1][i]['speciality']+'</p>'+
			    '<p class="card-title">Profession: '+data[1][i]['profession']+'</p>'+
			    '<input type="hidden" id="val'+data[1][i]['doctor_id']+'" value="'+data[1][i]['startslot']+'">'+
			    '<input type="hidden" id="val'+data[1][i]['doctor_id']+'" value="'+data[1][i]['endslot']+'">'+
			    '<p class="card-title">Description:<br><h4>'+data[1][i]['description']+'</h4></p>'+
			      '<button  type="button" class="btn btn-primary apnt" data-bs-toggle="modal" data-bs-target="#exampleModal" id="ap" onclick="dida('+data[1][i]['doctor_id']+')" value="'+data[1][i]['doctor_id']+'">Get Appointement</button>'+
			    '<p class="card-title"></p>'+
			
				  '</div>'+
				'</div>';
				$("#alldoctors").append(html);

			console.log(data);
		}
	}

	});
});
var did="";
function dida(id)
{
	$("#book").show();
	$("#book1").show();
	$("#book3").hide();
	did=id;
}

$("#date").on('change',function(e){
	var date=$("#date").val();
	
	console.log(did);
	if(date)
	{
		var slot=$("#val"+did).attr('value');
		console.log($("#val"+did));
		$.ajax({
			url: "/app/doctor/get.php",
			type:"POST",
			data: {"apnt_time": "1" ,"date": date, "slot": slot,"diid": did},
			success:function(data){

				if(data=="error")
				{
					$("#avliablity").html("<h3 style='color: green'>No slots availbale please select another date");
					$("#book").val(data);
				}
				else
				{
					$("#book").show();
					$("#avliablity").html("<h3 style='color: green'>Slot are available from.<br>You can proceed to book the slot</h3>");
					$("#book").val(data);
				}
			}
		});}
		else
		{

			$("#dateerr").show();
			$("#dateerr").html("<h5>Please select date</h5>");
			$("#dateerr").css({"color" : "red"});
		}
});
$("#book").click(function(e){
	var apntslot=$("#book").val();
	var date1=$("#date").val();
	$.ajax({
		url: "/app/doctor/get.php",
		type: "POST",
		data: {"appoint": "1","apntslot": apntslot,"date1": date1,"did": did},
		success:function(data)
		{
			$("#book").hide();
			$("#book1").hide();
			$("#book3").html("<h1 style='green'>Your appointment time is"+data+"</h1>");
            $("#book3").show();
		}
	});
})