<?php
include "db.php";

session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {

    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = $_POST["password"];

    // ================= USER LOGIN =================
    $sql = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
    $run_query = mysqli_query($con, $sql);

    if ($run_query && mysqli_num_rows($run_query) == 1) {

        $row = mysqli_fetch_array($run_query);

        $_SESSION["uid"] = $row["user_id"];
        $_SESSION["name"] = $row["first_name"];

        $ip_add = $_SERVER['REMOTE_ADDR'];

        // Handle cart from cookie
        if (isset($_COOKIE["product_list"])) {

            $p_list = stripslashes($_COOKIE["product_list"]);
            $product_list = json_decode($p_list, true);

            for ($i = 0; $i < count($product_list); $i++) {

                $p_id = $product_list[$i];

                $verify_cart = "SELECT id FROM cart WHERE user_id = '$_SESSION[uid]' AND p_id = '$p_id'";
                $result = mysqli_query($con, $verify_cart);

                if (mysqli_num_rows($result) < 1) {

                    $update_cart = "UPDATE cart 
                                    SET user_id = '$_SESSION[uid]' 
                                    WHERE ip_add = '$ip_add' AND user_id = -1";

                    mysqli_query($con, $update_cart);

                } else {

                    $delete_existing_product = "DELETE FROM cart 
                                               WHERE user_id = -1 
                                               AND ip_add = '$ip_add' 
                                               AND p_id = '$p_id'";

                    mysqli_query($con, $delete_existing_product);
                }
            }

            setcookie("product_list", "", time() - 3600, "/");

            echo "cart_login";
            exit();
        }

        echo "login_success";
        echo "<script> location.href='index.php'; </script>";
        exit();
    }

    // ================= ADMIN LOGIN =================
    $admin_password = md5($password);

    $admin_sql = "SELECT * FROM admin_info 
                  WHERE admin_email = '$email' 
                  AND admin_password = '$admin_password'";

    $admin_query = mysqli_query($con, $admin_sql);

    if ($admin_query && mysqli_num_rows($admin_query) == 1) {

        $row = mysqli_fetch_array($admin_query);

        $_SESSION["uid"] = $row["admin_id"];
        $_SESSION["name"] = $row["admin_name"];

        echo "login_success";
        echo "<script> location.href='admin/add_products.php'; </script>";
        exit();
    }

    // ================= LOGIN FAILED =================
    echo "<span style='color:red;'>Invalid email or password. Please try again.</span>";
    exit();
}
?>
