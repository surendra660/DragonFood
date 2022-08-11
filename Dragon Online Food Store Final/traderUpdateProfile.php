<?php
require('traderSessionCheck.php');
include('connect.php');
$errors = array();

if (isset($_POST['submit'])) {
    $fname = $_POST['fullname'];
    $uname = $_POST['uname'];
    $tid = $_POST['id'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST['street'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $province = $_POST['province'];

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
    if (!empty($phoneNumber)) {
        $pattern = "/^(0|[1-9][0-9]*)$/";
        if (preg_match($pattern, $phoneNumber)) {
            if (strlen($phoneNumber) == 10) {
                $phoneNumber = $phoneNumber;
            } else {
                $errors['pn'] = "Phone number must be of 10 digits";
            }
        } else {
            $errors['pn'] = "Phone number must be numeric";
        }
    } else {
        $errors['pn'] = "Phone number is required";
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
        $errors['c'] = "City name is required";
    }

    //province
    if (!empty($province)) {
        $pattern = "/^(0|[1-9][0-9]*)$/";
        if (preg_match($pattern, $province)) {
            if (($province) < 9) {
                $province = $province;
            } else {
                $errors['pv'] = "Province number is incorrect";
            }
        } else {
            $errors['pv'] = "Province number must be numeric";
        }
    } else {
        $errors['pv'] = "Province number is required";
    }
    
    //update
    if (count($errors) == 0) {

        $qry = "UPDATE trader_reg SET 
        TRADER_USERNAME='$uname', 
        TRADER_PASSWORD='$password',
        CONTACT_NAME='$fname',
        CONTACT_EMAIL='$email',
        CONTACT_NUMBER='$phoneNumber',        
        TRADER_STREET='$street',
        TRADER_DISTRICT= '$district',
        TRADER_CITY='$city',
        TRADER_PROVINCE='$province'
        WHERE TRADER_REG_ID='$tid' ";
        
        $send = oci_parse($conn, $qry);
        $result = oci_execute($send);

        if (oci_num_rows($send) > 0) {
            header('Location: traderUpdateProfile.php?id=' . $tid);
        } else {
            echo "Record Not Found";
            exit;
        }
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: traderManageProfile.php?id=' . $tid);
}
