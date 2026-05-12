cat > db.php <<'EOF'
<?php

$servername = getenv("DB_HOST") ?: "mysql-service";
$username   = getenv("DB_USER") ?: "lokesh";
$password   = getenv("DB_PASSWORD") ?: "lokesh@123";
$dbname     = getenv("DB_NAME") ?: "onlineshop";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
EOF
