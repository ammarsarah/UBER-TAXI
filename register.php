<?php
$conn = new mysqli("localhost", "root", "", "uber_taxi");

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (nom, prenom, email, tel, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nom, $prenom, $email, $tel, $password);
$stmt->execute();

echo "Inscription réussie";
?>
