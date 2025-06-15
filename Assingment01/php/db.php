<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "employeeDB";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}else {
    $stmt = $conn->prepare("insert into employee(id, name, email, position, hours) values(?,?,?,?,?)");
    $stmt->bind_param("ssssi", $id, $name, $email, $department, $hours);
    $stmt->execute();
    echo "New record created successfully";
    $stmt->close();
    $conn->close();
}
?>