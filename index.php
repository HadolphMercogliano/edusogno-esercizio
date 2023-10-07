<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
  
  // se il form è stato inviato includo la connessione al database
  require_once __DIR__ . "/includes/database.php";
  require_once __DIR__ . "/includes/loginFunctions.php";
  

  $email = $_POST["email"];
  $password = md5($_POST["password"]);
  
  $success = login($conn, $email,$password);

  if (!$success) {
    $error_message = "Errore di login. Email o password non validi.";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/styles/style.css">
  <title>Edusogno - Login</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://edusogno.com/logo-black.svg" alt="">
    </div>
  </header>
  <main>
    <h1>Hai già un account?</h1>
    <div class="form-area">

      <?php if (isset($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <?php if (isset($_GET["success"]) && $_GET["success"] == 1): ?>
      <p class='success-message'> Cambio password avvenuto con successo!</p>
      <?php endif; ?>

      <form method="post">

        <div>
          <label for="email">Inserisci l'email</label>
          <input type="email" id="email" placeholder="name@example.com" name="email" required>
        </div>

        <div>
          <label for="password">Inserisci la password</label>
          <input type="password" id="password" placeholder="Scrivila qui" name="password" required>
        </div>
        <a class="resetPsw" href="./resetPswRequest.php">Password dimenticata?<b>Clicca qui!</b></a>

        <div class="button-container">
          <button type="submit" class="btn" id="submitBtn">accedi</button>
        </div>
      </form>


      <a href="./register.php">Non hai ancora un profilo?<b> Registrati</b></a>
    </div>
  </main>

  <!-- WAVES & BACKGROUND ELEMENTS -->
  <?php include './includes/background.php'; ?>
</body>

</html>