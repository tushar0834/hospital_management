<?php

header('Access-Control-Allow-Origin: *');

class user
{

    function __construct()
    {
    	$conn=mysqli_connect("sql308.epizy.com","epiz_27176442","4sIHehVpgh9","epiz_27176442_rubal");
		$this->conn=$conn;
    }


    function user_login()
    {
        $userValid="select * from user where userId='".$_POST['userId']."'";

        $query = mysqli_query($con,$userValid);
        $result = mysqli_num_rows($query);

            if ($result > 1 && $result<1) 
            {
                $responce = "Enter correct userId";
            }
            else
            {
                $passValid="SELECT * FROM user WHERE userId='".$_POST['userId']."' AND password='".$_POST['password']."'" ;
                $query1 = mysqli_query($this->con,$passValid);
                $result1 = mysqli_num_rows($query1);

                    if ($result > 1 && $result<1) 
                    {
                        $responce = "Enter correct password";
                    }
                    else
                    {
                        $responce = "correct";            
                    }
            }

        echo json_encode($responce) ;

    }


	function showProfile()
	{
		$sql="SELECT * FROM user";

        $result=mysqli_query($this->con,$sql);
        if(mysqli_num_rows($result)>0)
        {
   			while ($row=mysqli_fetch_array($result)) 
   			{            
	            $profile = [ $row['sNO'] => [	
                    "id" => $row['sNo'], 
                    "fName" => $row['fName'],
                    "lName" => $row['lName'], 
                    "DOB" => $row['DOB'],
                    "gender" => $row['gender'],
                    "email" => $row['email'],
                    "cCode" => $row['cCode'], 
                    "mobile" => $row['mobile'], 
                    "userId" => $row['userId']
                ]

					];
            }
                
                echo json_encode($profile);
        }
        else{
            echo "Profile not found";
        }
	}

    function signup()
    {
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $DOB = $_POST['DOB'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $cCode = $_POST['countryCode'];
        $mobile = $_POST['mobile'];
        $userId = $_POST['userId'];
        $password = $_POST['password'];

        if ($gender=="male") 
        {
            $profileImage="image/male.png";
        }
        elseif ($gender=="female") 
        {
            $profileImage="image/female.png";
        }
        else
        {
            $profileImage ="";
        }

        $sql = "INSERT INTO user VALUES(NULL,'$fName','$lName','$DOB','$gender','$email','$countryCode','$mobile','$userId','$password','$profileImage')";
        $query = mysqli_query($con,$sql);

        if ($query) 
        {
            $responce = "Data inserted";
        }
        else
        {
            $responce = "Data not inserted";
        }
        echo json_encode($responce);
    }

} 



$ob= new user;
if(isset($_POST['login'])=="1")
{
    $email=$_POST['email'];
    $passwod=$_POST['password'];
    
$ob->user_login();
}


if(isset($_POST['profile'])=="2")
{
	$ob->showProfile();
}

if (isset($_POST['signup'])=="3") 
{
    $ob->signup();
}


?>



