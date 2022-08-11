<?php
require('adminSessionCheck.php');
require('connect.php');
$errors = array();


if (isset($_POST['submit'])) {
    $cid = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];


    if (!empty($fname)) {
        if (preg_match("/^[A-Za-z ]+$/", $fname)) {
            $fname = $fname;
        } else {
            $errors['fn'] = "First Name must be alphabet only.";
        }
    } else {
        $errors['fn'] = "First Name is required";
    }

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
            $email = $email;
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

    if (count($errors) == 0) {
        $qry = "UPDATE customer_reg SET CUSTOMER_FNAME='$fname',
            CUSTOMER_LNAME='$lname',
            CUSTOMER_USERNAME='$uname',
            CUSTOMER_EMAIL='$email',
            CUSTOMER_PASSWORD='$password',
            CUSTOMER_DOB= to_date('$dob','YYYY/MM/DD'),
            CUSTOMER_GENDER='$gender'
            WHERE CUSTOMER_REG_ID='$cid' ";

        $send = oci_parse($conn, $qry);
        $result = oci_execute($send);

        if (oci_num_rows($send) > 0) {
            header('Location: amendCustomer.php?id=' . $cid);
        } else {
            echo "Record Not Found";
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: amendCustomer.php?id=' . $cid);
}
