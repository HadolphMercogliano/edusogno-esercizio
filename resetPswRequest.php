<?php
require __DIR__ . "../vendor/autoload.php";

if (isset($_POST["email"])) {
  require_once __DIR__ . "/includes/database.php";
  require_once "./includes/resetPswFunctions.php";


  $email = $_POST["email"];

 
  if (checkEmailExists($conn, $email)) {    
    $success_message = "La procedura è andata a buon fine. Controlla la tua email per ulteriori istruzioni.";

    // Crea il token per il reset password
    $token = bin2hex(random_bytes(15));
  
    // Setta i parametri della mail
    $subject = 'Reset Password';
    $body = "<html><body>";
    $body .= "<p>Ciao,</p>";
    $body .= "<p>Hai richiesto il reset della password. Clicca sul seguente link per reimpostare la tua password:</p>";
    $body .= "<p><a href=\"http://localhost/Esercizi%20Corso%20Boolean/edusogno-esercizio/resetPswForm.php?token=" . $token . "\">Reset Password</a></p>";
    $body .= "</body></html>";

  if (sendEmail($email, $subject, $body)) {
    
    $success_message = "La procedura è andata a buon fine. Controlla la tua email per ulteriori istruzioni.";
    
    // Salva in db il token collegato all' utente
    saveResetToken($conn, $email, $token);
  } 
  else {
    $error_message = "Si è verificato un errore durante l'invio dell'email. Riprova più tardi.";
  }
} 
else {
  $error_message = "Email non registrata.";
}
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/styles/style.css">
  <title>Edusogno - Reset Password</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://edusogno.com/logo-black.svg" alt="">
    </div>
  </header>
  <main>
    <h1>Password reset</h1>
    <div class="form-area">

      <!-- messaggi di avvenuto invio della mail di reset o errore -->
      <?php if (isset($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>

      <?php elseif (isset($success_message)): ?>
      <p class="success-message"><?php echo $success_message; ?>
        <a href="./index.php">Torna al login</a>
      </p>
      <?php endif; ?>

      <form method="post">
        <div>
          <label for="email">Inserisci la mail con cui ti sei registrato</label>
          <input type="email" id="email" placeholder="name@example.com" name="email" required>
        </div>
        <div class="button-container d-flex">
          <button type="submit" class="btn" id="submitBtn">Reset</button>
          <a id="btn-cancel" href="./index.php" class="btn">annulla</a>
        </div>
      </form>
    </div>
  </main>

  <!-- WAVES & BACKGROUND ELEMENTS -->
  <?php include './includes/background.php'; ?>
</body>

</html>