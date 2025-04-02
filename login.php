<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Ottieni i dati del form
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $host = "localhost";
        $dbname = "logindb";
        $user = "root";
        $pass = "";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $permissionsList = "";

        try
        {

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            
            /*
            $sql = "SELECT * FROM utente WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => 'test@example.com']);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                echo "User found: " . $user['username'];
            } else {
                echo "No user found.";
            }*/
            echo "Connected to $dbname at $host successfully.";
        
        } catch (PDOException $pe)
        {
            die ("Could not connect to the database $dbname :" . $pe->getMessage());
        }
    }
?>



<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITO PHP</title>

    <style>
        .error { color: red; }
        .success { color: green; }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        function validateForm() {
            const usernameInput = document.getElementById('username');
            const username = usernameInput.value.trim();
            const pswdInput = document.getElementById('password');
            const pswd = pswdInput.value.trim();
            const errorDiv = document.getElementById('client-errors');
            errorDiv.textContent = ''; // Pulisce eventuali messaggi precedenti

            if (!username) {
                errorDiv.textContent = "Inserire username.";
                return false; // Blocca il submit
            } 
            
            if (!pswd) {
                errorDiv.textContent = "Inserire la password.";
                return false; // Blocca il submit
            }

            return true; // Permette l'invio del form
        }

        const form = document.querySelector('form');
        form.onsubmit = validateForm;
    });
</script>

</head>
<body>
<h1>BENVENUTO NEL SITO</h1>
<form method="POST" onsubmit="return validateForm()">
    <label for="username">Nome:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit">Login</button>
    <div id="client-errors" class="error"></div>
</form>
</body>
</html>