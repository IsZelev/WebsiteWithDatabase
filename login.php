<?php
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $host = "localhost";
    $dbname = "logindb";
    $db_user = "root";
    $db_pass = "";

    $currentTimestamp = date('H:i:s');

    if (isset($_POST['login'])) {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch the user's password
            $stmt = $conn->prepare("SELECT password FROM utente WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                // Update last login time after successful login
                $stmt = $conn->prepare("UPDATE utente SET last_login = :last_login WHERE username = :username");
                $stmt->bindParam(':last_login', $currentTimestamp);
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                // Success message
                $successMessage = "Login riuscito! Benvenuto $username.";
            } else {
                $errorMessage = "Username o password errati!";
            }
        } catch (PDOException $e) {
            $errorMessage = "Errore di connessione: " . $e->getMessage();
        }
    }

    if (isset($_POST['register'])) {
        $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $db_user, $db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if username already exists
            $stmt = $conn->prepare("SELECT * FROM utente WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $errorMessage = "Username già esistente!";
            } else {
                // Insert new user with current timestamps
                $stmt = $conn->prepare("INSERT INTO utente (username, password, creation_timestamp, last_login) VALUES (:username, :password, :creation_timestamp, :last_login)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $newPasswordHash);
                $stmt->bindParam(':creation_timestamp', $currentTimestamp);
                $stmt->bindParam(':last_login', $currentTimestamp);
                $stmt->execute();

                $successMessage = "Registrazione riuscita! Ora puoi effettuare il login.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Errore di connessione: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Website with database</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            width: 100%;
            margin-bottom: 10px;
        }

        .form-section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <h1>Registrazione o Login</h1>

    <div class="form-section">
        <form method="POST" novalidate>
            <label for="username">Nome:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>

            <button type="submit" name="login">Login</button>
            <button type="submit" name="register">Registrati</button>

            <?php if (!empty($errorMessage)): ?>
                <div class="error"><?= $errorMessage ?></div>
            <?php endif; ?>
            <?php if (!empty($successMessage)): ?>
                <div class="success"><?= $successMessage ?></div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>
