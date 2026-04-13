<?php
ob_start(); // Prevent header errors
session_start();

// ================= DB CONNECTION =================
$db = mysqli_connect("mysql-db", "lokesh", "lokesh@123", "onlineshop");

if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ================= VARIABLES =================
$username = "";
$email    = "";
$errors = array();

// ================= REGISTER ADMIN =================
if (isset($_POST['reg_user'])) {

    $username = mysqli_real_escape_string($db, $_POST['admin_name']);
    $email = mysqli_real_escape_string($db, $_POST['admin_email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // Validation
    if (empty($username)) { $errors[] = "Username is required"; }
    if (empty($email)) { $errors[] = "Email is required"; }
    if (empty($password_1)) { $errors[] = "Password is required"; }
    if ($password_1 != $password_2) {
        $errors[] = "Passwords do not match";
    }

    // Check existing user
    $user_check_query = "SELECT * FROM admin_info 
                         WHERE admin_name='$username' OR admin_email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['admin_name'] === $username) {
            $errors[] = "Username already exists";
        }
        if ($user['admin_email'] === $email) {
            $errors[] = "Email already exists";
        }
    }

    // Insert if no errors
    if (count($errors) == 0) {

        $password = md5($password_1);

        $query = "INSERT INTO admin_info (admin_name, admin_email, admin_password)
                  VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);

        $_SESSION['admin_name'] = $username;
        $_SESSION['admin_email'] = $email;
        $_SESSION['success'] = "You are now logged in";

        header('Location: /admin/');
        exit();
    }
}

// ================= ADMIN LOGIN =================
if (isset($_POST['login_admin'])) {

    $admin_username = mysqli_real_escape_string($db, $_POST['admin_username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($admin_username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (count($errors) == 0) {

        $password = md5($password);

        $query = "SELECT * FROM admin_info 
                  WHERE admin_email='$admin_username' 
                  AND admin_password='$password'";

        $results = mysqli_query($db, $query);

        if ($results && mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);

            $_SESSION['admin_email'] = $row['admin_email'];
            $_SESSION['admin_name'] = $row['admin_name'];
            $_SESSION['success'] = "You are now logged in";

            header('Location: /admin/');
            exit();

        } else {
            $errors[] = "Wrong username/password combination";
        }
    }
}
?>
