<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        // Ottieni i dati del form
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $host = "localhost";
        $dbname = "loginphp";
        $user = "root";
        $pass = "";
        $permissionsList = "";

        //inserire pdo e verifica login
        try
        {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if(password_verify($password, $username)) {
            $sql = "SELECT password as pss FROM utente WHERE username = :usrname";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usrname', $username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $permissionsList = "Permessi associati a " . $username . ":\\n";

            foreach ($row as $permesso)
                $permissionsList .= "[" . $permesso['id_permesso'] . "] - " . $permesso['descrizione'] . "\\n";
            }
            else
                $permissionsList = "Username o password errati!";

        }catch (PDOException $e) {
            die("Errore di connessione: " . $e->getMessage());
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
            // Funzione di validazione
            function validateForm() {
                const usernameInput = document.getElementById('username');
                const username = usernameInput.value.trim();
                const pswdInput = document.getElementById('password');
                const pswd = pwdInput.value.trim();
                const errorDiv = document.getElementById('client-errors');
                errorDiv.textContent = ''; // Pulisce eventuali messaggi precedenti

                if (!username) {
                    errorDiv.textContent = "Inserire username.";
                    return false; // nessuna POST
                } else if (!pswd) {
                    errorDiv.textContent = "Indirizzo la password.";
                    return false; // nessuna POST
                }
                return "login.php"; // POST verso il server alla stessa pagina PHP
            }

            // Associa la funzione di validazione al form
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