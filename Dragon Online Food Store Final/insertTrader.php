<?php
session_start();

include('connect.php');
$errors = array();

if (isset($_POST['submit'])) {
    $fullname = $_POST['fullname'];
    $uname = $_POST['uname'];
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

    if (isset($_POST['termsandcondition'])) {
        $checkbox = $_POST['termsandcondition'];
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
    if (!empty($fullname)) {
        if (preg_match("/^[A-Za-z ]+$/", $fullname))
            if (strlen($fullname) > 6) {
                $fullname = $fullname;
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

    //terms and condition
    if (!isset($checkbox)) {
        $errors['t'] = "required";
    }


    //insert
    if (count($errors) == 0) {

        $insert = 'INSERT INTO trader_reg (trader_username, trader_password, contact_name, contact_email, contact_number, trader_street, trader_district, trader_city, trader_province)' .
            'VALUES (:uname, :password, :fullname, :email, :phoneNumber, :street, :district, :city, :province)';

        $send = oci_parse($conn, $insert);

        oci_bind_by_name($send, ':uname', $uname);
        oci_bind_by_name($send, ':password', $password);
        oci_bind_by_name($send, ':fullname', $fullname);
        oci_bind_by_name($send, ':email', $email);
        oci_bind_by_name($send, ':phoneNumber', $phoneNumber);        
        oci_bind_by_name($send, ':street', $street);
        oci_bind_by_name($send, ':district', $district);
        oci_bind_by_name($send, ':city', $city);
        oci_bind_by_name($send, ':province', $province);

        $result = oci_execute($send);

        if (!$result) {
            $message = ['message' => "Error inserting data: " . oci_error($send)['message'], 'color' => "danger"];
        } else {
            $message = ['message' => "Data inserted successfully", 'color' => "success"];
        }
        $_SESSION['message'] = $message;
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: traderRegister.php');
}
