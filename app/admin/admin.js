
var alldata=[];
$(document).ready(function(){
	$("#doctors").hide();
	$("#doc").on('click',function(e){
	$("#home").hide();
	$("#doctors").show();
	$.ajax({
		url: "https://webtechs.xyz/app/doctor/get.php",
		type: "POST",
		data: {"doctordetails": "1"},
		dataType: "JSON",
		success:function(data){
			alldata=data[1];
			for(var i=0;i<data[0].length;i++)
			{
				var html="<tr><td><input type='checkbox' value="+ data[0][i]['id'] +"></td>"+"<td><input type='number' id='d_id'  value='"
                         + data[0][i]['id'] +
                         "' disabled></td>"
                         +
                        "<td><input type='text' name='doctor_full_name' id='doctor_full_name"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][0])+","+data[0][i]['id']+")' value='"
                         + data[0][i]['doctor_full_name'] +
                         "'  disabled></td>"
                         +
                         "<td><input type='text' name='d_mobile' id='d_mobile"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][5])+","+data[0][i]['id']+")' value='"
                         + data[0][i]['d_mobile']+
                         "' disabled></td>"
                         +
                         "<td><input type='text' name='email' id='email"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][1])+","+data[0][i]['id']+")' value='"
                         + data[0][i]['email'] +
                         "'  disabled></td>"
                         +
                         "<td><input type='text' name='username' id='username"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][2])+","+data[0][i]['id']+")' class='form-group' value='"
                         + data[0][i]['username'] +
                         "' disabled></td>"
                         +
                         "<td><input type='text' name='speciality' id='speciality"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][3])+","+data[0][i]['id']+")' value='"
                         + data[0][i]['speciality'] +
                         "'  disabled></td>"
                         +
                         "<td><input type='text' name='profession' id='profession"+data[0][i]['id']+"' onchange='ch("+JSON.stringify(data[1][4])+","+data[0][i]['id']+")' value='"
                         + data[0][i]['profession'] +
                         "' disabled></td></tr>";
                         $("#doctordet").append(html);
                         
			}
		}
	});
	});
});
$("#dedit").on('click',function(e){
	$('input[type="text"]').prop( "disabled", false );
});
$("#dadd").on('click',function(e){

		var htm="<tr><td></td><td disabled>auto generated</td>"+
						"<td><input type='text' id='adddoctor_full_name' onchange='adddoc("+JSON.stringify(alldata[0])+")'></td>"+
						"<td><input type='text' id='addd_mobile' onchange='adddoc("+JSON.stringify(alldata[5])+")'></td>"+
						"<td><input type='text' id='addemail' onchange='adddoc("+JSON.stringify(alldata[1])+")'></td>"+
						"<td><input type='text' id='addusername' onchange='adddoc("+JSON.stringify(alldata[2])+")'></td>"+
						"<td><input type='text' id='addspeciality' onchange='adddoc("+JSON.stringify(alldata[3])+")'></td>"+
						"<td><input type='text' id='addprofession' onchange='adddoc("+JSON.stringify(alldata[4])+")'></td></tr>";
	$("#add").show();
	$("#add1").append(htm);
});
function ch(type,id)
	{
		var sel=type+id;

	    var change=$("#"+sel).val();

	  
	    send_ajax(type,change,id);

	}
	function adddoc(type)
	{
		var change=$("#add"+type).val();
		alert(change);
	}
function send_ajax(type,change,id)
{
    $.ajax({
        url: "https://webtechs.xyz/app/doctor/get.php",
        type: "POST",
        data: {"type": type, "change": change, "id": id,"edit": "edit"},
        dataType: "JSON",
        success: function(data)
        {
            
        }
    });
}