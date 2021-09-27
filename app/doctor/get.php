<?php
header("Access-Control-Allow-Origin: *");

session_start();
class login
{
	function __construct()
	{
		$conn=mysqli_connect("sql308.epizy.com","epiz_27176442","4sIHehVpgh9","epiz_27176442_hospital_management");
		$this->conn=$conn;
	}

	function login_doctor($email,$password)
	{
		$data= array();
		 $sql="SELECT username,doctor_full_name,email FROM doctor_login WHERE email='".$email."' AND password='".$password."' ";
		$result=mysqli_query($this->conn,$sql);

		if(mysqli_num_rows($result) >0)
		{
			while ($row=mysqli_fetch_array($result)) 
			{

				array_push($data,$row['username']);
				array_push($data,$row['doctor_full_name']);
				array_push($data,$email);
				
			}
				$session=session_id();
				$_SESSION['session']=$session;
				$query="UPDATE doctor_login SET session='".$session."' where email='".$email."'";
				mysqli_query($this->conn,$query);
				echo json_encode($data);
		}
		else{
			echo "error";
		}

	}


	function profile_doctor()
	{
		$sql="SELECT * FROM doctor_login where email='".$_SESSION['email']."' ";
		$profile=array();
        $result=mysqli_query($this->conn,$sql);
        if(mysqli_num_rows($result)>0)
        {
   			while ($row=mysqli_fetch_array($result)) 
   			{            
	            $profile = [	"id" => $row['doctor_id'], "d_mobile" => $row['d_mobile'], "email" => $row['email'], "username" => $row['username'], "doctor_full_name" => $row['doctor_full_name'], "speciality" => $row['speciality'], "profession" => $row['profession'] 
	        				];
            }

                echo json_encode($profile);
        }
        else{
            echo "error";
        }
	}


	function check_session()
	{
		if(@$_SESSION['session'])
		{
			$data=array();
			$data1=array();
			$cquery="SELECT  doctor_full_name,email,doctor_id FROM doctor_login where session='".$_SESSION['session']."'";
			$result=mysqli_query($this->conn,$cquery);
			while ($row=mysqli_fetch_array($result)) 
   			{ 
			$name=$row['doctor_full_name'];
			$_SESSION['name']=$row['doctor_full_name'];
			$_SESSION['email']=$row['email'];
			$id=$row['doctor_id'];
			}
			$aquery="SELECT * FROM doctor_login LEFT JOIN patients ON(doctor_login.doctor_id=patients.doctor_id) left join user on(patients.patient_id=user.p_id) where doctor_login.doctor_id=$id";
			$aresult=mysqli_query($this->conn,$aquery);
			$rows=mysqli_num_rows($aresult);
			while($arow=mysqli_fetch_assoc($aresult))
			{
				array_push($data,$arow['p_fname']);
				array_push($data,$arow['p_lname']);
				array_push($data,$arow['blood_pressure']);
				array_push($data,$arow['problem']);
				array_push($data,$arow['weight']);
				array_push($data,$arow['apnttime']);
				$data1[$arow['p_id']]=$data;
				$data=array();
			}
			
			echo json_encode(array($name,$data1,$rows));
		}
		else
		{
			echo "error";
		}
	}
    function edit_profile($type,$change,$id)
    {
        // echo $type;
        $query_edit="UPDATE doctor_login set $type='".$change."' where doctor_id='$id' ";
        $result1=mysqli_query($this->conn,$query_edit);
        
        if($result1)
        {
            if($type=='email')
            {
            $_SESSION['$type']=$change;
            }
            echo "success";
        }
        else{
            echo "fail";
        }
    }
    function check_email($emal)
    {
        $emlqry="SELECT p_id FROM user where p_email='".$emal."'";
        $emlresult=mysqli_query($this->conn,$emlqry);

        if(mysqli_num_rows($emlresult) > 0)
        {
            echo "error";
        }
        else
        {
        	echo "success";
        }
    }
    function checkloginuser($uemail,$upassword)
    {
    	$login=array();
    	$checkloginqry="SELECT * from user where p_email='".$uemail."' and password='".md5($upassword)."' ";
    	$loginreult=mysqli_query($this->conn,$checkloginqry);
    	if(mysqli_num_rows($loginreult) > 0)
    	{
    		date_default_timezone_set('Asia/Kolkata');
    		$to_date=date('Y-m-d');
    		$update_login_time="UPDATE user SET date='".$to_date."' where p_email='".$uemail."'";
    		mysqli_query($this->conn,$update_login_time);
    		
    		$session=session_id();
    		$_SESSION['user_session']=$session;
    		while($loginrow=mysqli_fetch_array($loginreult))
    		{
    			$login['p_id']= $loginrow['p_id'];
    			$login['problem']= $loginrow['problem'];
    			
    		}
    		$updatelogin="UPDATE user set session_id='".$session."' where p_email='".$uemail."'";
    		mysqli_query($this->conn,$updatelogin);
    		echo "success";
    	}
    	else
    	{
    		echo "error";
    	}
    }
    function appointment_page()
    {
    	$fetch=array();
    	$fetchsql="SELECT * FROM user where session_id='".$_SESSION['user_session']."'";
    	$ftechresult=mysqli_query($this->conn,$fetchsql);
    	while($fetchrow=mysqli_fetch_array($ftechresult))
    	{
    		$_SESSION['p_id']=$fetchrow['p_id'];
    		$fetch['p_id']=$fetchrow['p_id'];
    		$fetch['p_fname']=$fetchrow['p_fname'];
    		$fetch['p_lname']=$fetchrow['p_lname'];
    		$fetch['p_email']=$fetchrow['p_email'];
    		$fetch['mobile']=$fetchrow['phone'];
    		// $fetch['appointment_time']=$fetchrow['apnt_time'];
    		$fetch['date']=$fetchrow['date'];
    	}
    	$doctor=array();
    	$doctor1=array();
    	$fetchdoctor="SELECT * from doctor_login";
    	$fetchdoctor=mysqli_query($this->conn,$fetchdoctor);
    	while($fetchdoctorrow=mysqli_fetch_array($fetchdoctor))
    	{
    		$doctor['doctor_id']=$fetchdoctorrow['doctor_id'];
    		$doctor['doctor_full_name']=$fetchdoctorrow['doctor_full_name'];
    	    $doctor['speciality']=$fetchdoctorrow['speciality'];
    	    $doctor['profession']=$fetchdoctorrow['profession'];
    	    $doctor['description']=$fetchdoctorrow['Decrription'];
    	    $doctor['image']=$fetchdoctorrow['image'];
    	    $doctor['startslot']=$fetchdoctorrow['d_time'];
    	    $doctor['endslot']=$fetchdoctorrow['end_time'];
    	    array_push($doctor1, $doctor);
    	}

    	echo json_encode(array($fetch,$doctor1));
    }
    function apnt_time($date,$slot,$diid)
    {
    	date_default_timezone_set('Asia/Kolkata');
    	$today_date=date('Y-m-d H:i:s');

    	$count="SELECT COUNT(patient_id) as total from patients where apnt_date like '%$date%' and doctor_id=$diid";
    	$count_result=mysqli_query($this->conn,$count);
    	$total_patients_row=mysqli_fetch_array($count_result);

    		$total_patients=(int)$total_patients_row['total'];

    	    	if($total_patients>0)
    	{
    		if($total_patients<=24)
    	    	{
    	    		$apntime=($total_patients*10)+10;
    	    	    	
    	    	    			$apnt_time=(DateTime::createFromFormat('H:i:s', $slot))->modify("+{$apntime} minutes")->format('H:i:s');
    	    	    			echo $apnt_time;
    	    	    		}
    	    	    	
    	    	    	else
    	    	    	{
    	    	    		echo "error";
    	    	    	}
    	  }

		else
		{
				echo $slot;
		}

    }
    function makeappointmentslot($newslot,$newdate,$pid,$did)
    {
    	date_default_timezone_set('Asia/Kolkata');
    	echo $today_date=date('Y-m-d');
    	$makequery="UPDATE user set  bookedtime='".$today_date."',date='".$newdate."' where p_id=$pid";
    	mysqli_query($this->conn,$makequery);
    	$updatepatient="INSERT INTO patients (patient_id,doctor_id,apnt_date,apnttime)VALUES($pid,$did,'".$newdate."','".$newslot."')";
    	mysqli_query($this->conn,$updatepatient);
    	echo $newslot;
    }
     function signup($name,$pass,$mobile,$userEmail,$problem)
    {
    	
        $names=explode(" ", $name);
        $fname=$names[0];
        @$lname=$names[1];
        if($lname!='')
       {
       	$signupqry="INSERT INTO user(p_fname,p_lname,phone,password,p_email,problem)values('".$fname."','".$lname."',$mobile,'".md5($pass)."','".$userEmail."','".$problem."')";
       }
   else
   {
   		$signupqry="INSERT INTO user(p_fname,phone,password,p_email,problem)values('".$fname."',$mobile,'".md5($pass)."','".$userEmail."','".$problem."')";
   }

        $executqry=mysqli_query($this->conn,$signupqry);
   		if($executqry)
   		{
   			echo "success";
   		}
   }
   
   function getdoctordetails()
   {
   		$docdetails="SELECT * FROM doctor_login";
	$dteails=array();
	$docdetail=array();
        $docresult=mysqli_query($this->conn,$docdetails);
        if(mysqli_num_rows($docresult)>0)
        {
   			while ($docrow=mysqli_fetch_array($docresult)) 
   			{            
	            $details = [	"id" => $docrow['doctor_id'], "d_mobile" => $docrow['d_mobile'], "email" => $docrow['email'], "username" => $docrow['username'], "doctor_full_name" => $docrow['doctor_full_name'], "speciality" => $docrow['speciality'], "profession" => $docrow['profession'] 
	        				];
	        				array_push($docdetail, $details);
            }
            $header=array();
     		array_push($header, 'doctor_full_name');
     		array_push($header, 'email');
     		array_push($header, 'username');
     		array_push($header, 'speciality');
     		array_push($header, 'profession');
     		array_push($header, 'd_mobile');

                echo json_encode(array($docdetail,$header));
        }
        else{
            echo "error";
        }

   }
    
} 


$ob= new login;
if(isset($_POST['login']))
{
	$email=$_POST['email'];
	$password=$_POST['password'];
	
$ob->login_doctor($email,$password);
}


if(isset($_POST['SES']))
{
	$ob->check_session();
}


if(isset($_POST['profile']))
{
	$ob->profile_doctor();
}
if(isset($_POST['edit']))
{
    $type=$_POST['type'];
    $change= $_POST['change'];
    $id= $_POST['id'];
    $ob->edit_profile($type,$change,$id);
}
if(isset($_POST['signup']))
{
    $name=$_POST['name'];
    $userEmail=$_POST['usereml'];
    $pass=$_POST['userpassword'];
    $mobile=$_POST['mobile'];
    $problem=$_POST['problem'];
    $ob->signup($name,$pass,$mobile,$userEmail,$problem);
}
if(isset($_POST['validate_email']))
{
    $emal=$_POST['valemail'];
    $ob->check_email($emal);
}
if(isset($_POST['userlogin']))
{
	$uemail=$_POST['userEmail'];
	$upass=$_POST['userPassword'];
	$ob->checkloginuser($uemail,$upass);
}
if(isset($_POST['appointement_page']))
{
	// echo $_SESSION['user_session'];
	$ob->appointment_page();
}
if(isset($_POST['apnt_time']))
{
	$date=$_POST['date'];
	$slot=$_POST['slot'];
	$diid=$_POST['diid'];

	$ob->apnt_time($date,$slot,$diid);
}
if(isset($_POST['apntslot']))
{
	$newslot=$_POST['apntslot'];
	$newdate=$_POST['date1'];
	$pid=$_SESSION['p_id'];
	$did=$_POST['did'];
	$ob->makeappointmentslot($newslot,$newdate,$pid,$did);
}
if(isset($_POST['doctordetails']))
{
	$ob->getdoctordetails();
}
?>
