<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $selectedRole = $_POST['role'];

    if (empty($email) || empty($password) || empty($selectedRole)) {
        echo "Please fill in all the required fields.";
        exit();
    }

    $sql = "SELECT * FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if ($user['role'] === $selectedRole && $password === $user['password'] && $email === $user['email']){
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            switch ($user['role']) {
                case 'admin':
                    header("Location: ../admin/admin_dashboard.html");
                    break;
                case 'staff':
                    header("Location: ../staff/staff_dashboard.html");
                    break;
                case 'student':
                    header("Location: ../student/student_dashboard.html");
                    break;
                default:
                    echo "Role Unauthorized";
                    exit();
            }

            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
