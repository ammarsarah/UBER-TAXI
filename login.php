<?php
$conn = new mysqli("localhost", "root", "", "uber_taxi");

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    echo "Connexion réussie";
} else {
    echo "Email ou mot de passe incorrect";
}
?>
