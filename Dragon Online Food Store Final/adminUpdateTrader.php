<?php
require('adminSessionCheck.php');
require('connect.php');
$errors = array();

if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $tid = $_POST['id'];
    $fname = $_POST['fullname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];    
    $street = $_POST['street'];
    $city = $_POST['city'];
    $district = $_POST['district'];
    $province = $_POST['province'];

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
            $errors['pa'] = "at least one uppercase, one symbol and one digit";
        }
    } else {
        $errors['pa'] = "Password is required";
    }


    //fullname
    if (!empty($fname)) {
        if (preg_match("/^[A-Za-z ]+$/", $fname))
            if (strlen($fname) > 6) {
                $fname = $fname;
            } else {
                $errors['fn'] = "Fullname must be at least 6 characters";
            }
        else {
            $errors['fn'] = "Fullname must be alphabet only.";
        }
    } else {
        $errors['fn'] = "Fullname is required";
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

    //contact number
    if (!empty($contact)) {
        $pattern = "/^(0|[1-9][0-9]*)$/";
        if (preg_match($pattern, $contact)) {
            if (strlen($contact) == 10) {
                $contact = $contact;
            } else {
                $errors['c'] = "Phone number must be of 10 digits";
            }
        } else {
            $errors['c'] = "Phone number must be numeric";
        }
    } else {
        $errors['c'] = "Phone number is required";
    }

    //product type
    if ($type == "") {
        $type['t'] = "Required";
    } else {
        $type = $type;
    }

    //street name
    if (!empty($street)) {
        $street = $street;
    } else {
        $errors['s'] = "Street name is required";
    }

    //district
    if (!empty($district)) {
        $district = $district;
    } else {
        $errors['d'] = "District name is required";
    }

    //city
    if (!empty($city)) {
        $city = $city;
    } else {
        $errors['ct'] = "City name is required";
    }

    //province
    if (!empty($province)) {
        $pattern = "/^(0|[1-9][0-9]*)$/";
        if (preg_match($pattern, $province)) {
            if (($province) < 9) {
                $province = $province;
            } else {
                $errors['p'] = "Province number is incorrect";
            }
        } else {
            $errors['p'] = "Province number must be numeric";
        }
    } else {
        $errors['p'] = "Province number is required";
    }

    if (count($errors) == 0) {

        $qry = "UPDATE trader_reg SET 
        TRADER_USERNAME='$uname', 
        TRADER_PASSWORD='$password',
        CONTACT_NAME='$fname',
        CONTACT_EMAIL='$email',
        CONTACT_NUMBER='$contact',        
        TRADER_STREET='$street',
        TRADER_DISTRICT= '$district',
        TRADER_CITY='$city',
        TRADER_PROVINCE='$province'
        WHERE TRADER_REG_ID='$tid' ";

        $send = oci_parse($conn, $qry);
        $result = oci_execute($send);

        if (oci_num_rows($send) > 0) {
            header('Location: amendTrader.php?id=' . $tid);
        } else {
            echo "Record Not Found";
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: amendTrader.php?id=' . $tid);
}
