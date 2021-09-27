$("#log_on").on('click',function(e){
var email=$("#emailusr").val();
var password=$("#password").val();
if(email!='')
{
	if(password != '')
	{
	$.ajax({
		url: "/app/doctor/get.php",
		type: "POST",
		data : {"userlogin": "1", "userEmail": email,"userPassword": password},
		beforeSend:function(){

		},
		success:function(data)
		{
			if(data=="success")
			{
				location.href="appointment.html";
			}
			else
			{
				$("#errr").show();
				$("#errr").html("USER NAME OR PASSWORD INCORRECT");
				$("#errr").css({"color" : "red"});
			}
		}

	});
	}
	else
	{
		$("#perror").show();
	}
}
else
{
	$("#error").show();
}
});
// sign up module
$("#useremail").on('change',function(e){
	var usremail=$("#useremail").val();
	var regexEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if(!regexEmail.test(usremail))
	{
		$("#signemail").html("ENTER VALID EMAIL ADDRESS");
		$("#signemail").show();
		$("#signemail").css({"color" : "red"});
	}
	else
	{
	$.ajax({
		url: "/app/doctor/get.php",
		type: "POST",
		data: {"validate_email": "validate_email", "valemail": usremail},
		success:function(data)
		{
			if(data=="error")
			{
				$("#signemail").html("");
				$("#signemail").show();
				$("#signemail").html("EMAIL ALREADY EXISTS");
				$("#signemail").css({"color" : "red"});
			}
			else if(data=="success")
			{
				$("#signemail").hide();
			}

		}
	});
	}
});
$("#sign_up").click(function(e){
	$("#signemail").hide();
	$("#errname").hide();
	$("#errproblem").hide();
	$("#errmobile").hide();
	$("#errpassword").hide();
var err=0;
var user_email=$("#useremail").val();

var uname= $("#fullname").val();

var problem=$("#problem").val();
var password=$("#user_password").val();
var mobile= $("#number").val();
if(user_email == '')
{
	err=1;
	$("#signemail").show();
	$("#signemail").html("enter email address");
	$("#signemail").css({"color" : "red"});
}
else if(uname == "")
{
	err=1;
	$("#errname").show();
	$("#errname").html("name is required");
	$("#errname").css({"color" : "red"});	
}
else if(problem =='')
{
	err=1;
	$("#errproblem").show();
	$("#errproblem").html("enter problem");
	$("#errproblem").css({"color" : "red"});
}
else if(mobile=='')
{
	err=1;
	$("#errmobile").show();
	$("#errmobile").html("enter mobile number");
	$("#errmobile").css({"color" : "red"});
}
else if(password=='')
{
	err=1;
	$("#errpassword").show();
	$("#errpassword").html("enter password");
	$("#errpassword").css({"color" : "red"});
}
if(user_email != '' && uname != "" && password!= '' && mobile!= '' && problem != '')
{
	
	$.ajax({
		url: "/app/doctor/get.php",
		type: "POST",
		data: {"signup": "1","usereml":user_email, "name":uname, "userpassword":password, "mobile":mobile,"problem":problem},
		success:function(data){
			if(data=="success")
			{
				alert("SIGNUP SUCCESS PLEASE LOGIN");
				$(".signin").show();
	$(".signup").hide();
			}
		}
	});
}

});

