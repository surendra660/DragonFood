<?php
session_start();
require('sendmail.php');
include('connect.php');
$errors = array();

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $token = md5(RAND(2000, 4000)); 

    if (isset($_POST['termsandcondition'])) {
        $checkbox = $_POST['termsandcondition'];
    }

    //firstname
    if (!empty($fname)) {
        if (preg_match("/^[A-Za-z ]+$/", $fname)) {
            $fname = $fname;
        } else {
            $errors['fn'] = "First Name must be alphabet only.";
        }
    } else {
        $errors['fn'] = "First Name is required";
    }

    //lastname
    if (!empty($lname)) {
        if (preg_match("/^[A-Za-z ]+$/", $lname)) {
            $lname = $lname;
        } else {
            $errors['ln'] = "Last Name must be alphabet only.";
        }
    } else {
        $errors['ln'] = "Last Name is required";
    }

    //email
    if (!empty($email)) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            $qry = "SELECT COUNT(*) AS COUNT FROM CUSTOMER_REG WHERE CUSTOMER_EMAIL='$email' ";
            $send = oci_parse($conn,$qry);            
            oci_execute($send);
            $row = oci_fetch_assoc($send);
            if($row['COUNT']==0){
                $email = $email;
            }else{
                $errors['e'] = "Email already exist";
            }            
        } else {
            $errors['e'] = "Invalid email format";
        }
    } else {
        $errors['e'] = "Email is required";
    }

    //username
    if (!empty($uname)) {
        if (preg_match("/^[A-Za-z]+$/", $uname))
            if (strlen($uname) >= 6) {
                $uname = $uname;
            } else {
                $errors['un'] = "Username must be at least 6 characters";
            }
        else {
            $errors['un'] = "Username must be alphabet only.";
        }
    } else {
        $errors['un'] = "Username is required";
    }

    //password
    if (!empty($password)) {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/';
        if (preg_match($pattern, $password)) {
            $password = $password;
        } else {
            $errors['p'] = "at least one uppercase, one symbol and one digit";
        }
    } else {
        $errors['p'] = "Password is required";
    }

    //DOB
    if (!empty($dob)) {
        $dob = $dob;
    } else {
        $errors['dob'] = "Required*";
    }

    if (!empty($gender)) {
        $gender = $gender;
    } else {
        $errors['g'] = "Required*";
    }

    //terms and condition
    if (!isset($checkbox)) {
        $errors['t'] = "Required*";
    }

    //insert
    if (count($errors) == 0) {


        $insert = 'INSERT INTO customer_reg (customer_fname, customer_lname, customer_email, customer_username, customer_password, customer_dob, customer_gender)' .
            'VALUES (:fname, :lname, :email, :uname, :password, to_date(:dob, \'YYYY/MM/DD\'), :gender)';

        $send = oci_parse($conn, $insert);

        oci_bind_by_name($send, ':fname', $fname);
        oci_bind_by_name($send, ':lname', $lname);
        oci_bind_by_name($send, ':email', $email);
        oci_bind_by_name($send, ':uname', $uname);
        oci_bind_by_name($send, ':password', $password);
        oci_bind_by_name($send, ':dob', $dob);
        oci_bind_by_name($send, ':gender', $gender);

        $result = oci_execute($send);

        $to = $email;
        $subject = "Verify Email";
        $msg = "Click <a href='http://localhost/assets2/verifyemail.php?email=$email&token=$token'>here</a> to verify your email.";   
        $sendMail = sendMail($to, $subject, $msg); 

        if (!$result) {
            $message = ['message' => "Error inserting data: " . oci_error($send)['message'], 'color' => "danger"];
        } else {
            $message = ['message' => "Data inserted successfully.<br>Please check your email for verification.", 'color' => "success"];
        }
        $_SESSION['message'] = $message;
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: register.php');
}
