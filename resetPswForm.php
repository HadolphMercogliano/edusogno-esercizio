<?php
require_once __DIR__ . "/includes/database.php";
 require_once "./includes/resetPswFunctions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $token = $_GET["token"];
  $password = $_POST["password"];
  $passwordConfirm = $_POST["password-confirm"];

  if (checkPasswordsMatch($password, $passwordConfirm)) {

    // Verifica se il token corrisponde nel database, in caso positivo ritorna la mail associata
    $email = getEmailByResetToken($conn, $token);
    if ($email) {

      // Aggiorna la password associata al reset_token
      updatePassword($conn, $email, $password);

      // Imposta il reset_token su NULL
      clearResetToken($conn, $email);

      // Reindirizza l'utente a una pagina di successo
      header("Location: index.php?success=1");
      exit;
    } 
    else {
      $error_message = "Token non valido.";
    }
  } 
  else {
    $error_message = "Le password non corrispondono.";
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
    <h1>Nuova password</h1>
    <div class="form-area">
      <form method="post">
        <div>
          <label for="password">Inserisci la nuova password</label>
          <input type="password" id="password" placeholder="" name="password" required>
        </div>
        <div>
          <label for="password-confirm">Conferma la nuova password</label>
          <input type="password" id="password-confirm" placeholder="" name="password-confirm" required>
        </div>
        <div class="button-container">
          <button type="submit" class="btn" id="submitBtn">Reset</button>
        </div>
      </form>
    </div>
  </main>

  <!-- WAVES & BACKGROUND ELEMENTS -->
  <div class="container-custom">
    <svg id="wave-1" xmlns="http://www.w3.org/2000/svg" width="1440" viewBox="0 0 1440 128" fill="none">
      <path
        d="M550.04 20.7802C309.334 -30.4323 58.3859 24.9498 -37 59.0424V152L1505.7 142.434C1506.68 130.171 1508.06 94.1161 1505.7 48.0053C1428.64 75.2303 850.923 84.7959 550.04 20.7802Z"
        fill="white" />
    </svg>

    <svg id="wave-2" xmlns="http://www.w3.org/2000/svg" width="1440" viewBox="0 0 1440 433" fill="none">
      <path
        d="M488.772 199.429C281.838 125.104 291.158 -34.8781 -52.8359 7.2956L-120.693 422.193L1422.4 630.732C1432.33 576.156 1460.02 415.457 1491.34 209.267C1394.73 318.23 695.707 273.754 488.772 199.429Z"
        fill="#CBDAEC" />
    </svg>

    <svg id="wave-3" width="1440" viewBox="0 0 1440 226" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M1333.21 30.8969C1794.82 -45.248 2276.07 37.0965 2459 87.7868V226L-499.505 211.778C-501.388 193.544 -504.023 139.936 -499.505 71.3763C-351.721 111.856 756.189 126.078 1333.21 30.8969Z"
        fill="#B8CCE4" />
    </svg>

    <!-- SPACESHIP -->
    <svg id="spaceship" width="111" height="185" viewBox="0 0 111 185" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M55.5 0L87.1099 63H23.8901L55.5 0Z" fill="white" />
      <rect x="24" y="63" width="63" height="96" fill="white" />
      <path d="M0 145.867L20 127V159.145L0 185V145.867Z" fill="white" />
      <path d="M111 145.867L91 127V159.145L111 185V145.867Z" fill="white" />
      <rect x="53" y="128" width="5" height="56" fill="white" />
      <circle cx="55.5" cy="102.5" r="14.5" fill="#D9E5F3" />
    </svg>

    <!-- ELLIPSIS -->
    <svg id="ellipse1" xmlns="http://www.w3.org/2000/svg" width="181" height="181" viewBox="0 0 181 181" fill="none">
      <circle cx="90.5" cy="90.5" r="90.5" fill="white" />
    </svg>

    <svg id="ellipse2" width="180" height="358" viewBox="0 0 180 358" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="1" cy="179" r="179" fill="white" />
    </svg>
  </div>
</body>

</html>