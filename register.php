<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  require_once __DIR__ . "/includes/database.php";
  require_once __DIR__ . "/includes/registerFunctions.php";
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $result = register($conn, $nome, $cognome, $email, $password);

  if ($result === true) {
    if ($email === "admin@admin.com") { 
        header("Location: admin/adminArea.php"); 
      }
       else { 
        header("Location: userArea.php"); 
      } 
    exit;
  } else {
    $error_message = $result;
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
  <title>Edusogno - Registrazione</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://edusogno.com/logo-black.svg" alt="">
    </div>
  </header>
  <main>
    <h1>Crea il tuo account</h1>
    <div class="form-area">
      <?php if (isset($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <form method="post">
        <div>
          <label for="nome">Inserisci il nome</label> <br>
          <input type="text" placeholder="Mario" id="nome" name="nome" required>
        </div>
        <div>
          <label for="cognome">Inserisci il cognome</label>
          <input type="text" id="cognome" placeholder="Rossi" name="cognome" required>
        </div>
        <div>
          <label for="email">Inserisci l'email</label>
          <input type="email" id="email" placeholder="name@example.com" name="email" required>
        </div>
        <div>
          <label for="password">Inserisci la password</label>
          <input type="password" id="password" placeholder="Scrivila qui" name="password" required>
        </div>
        <div class="button-container">
          <button type="submit" class="btn" id="submitBtn">Registrati</button>
        </div>
      </form>
      <a href="./index.php">Hai già un account? <b>Accedi</b></a>
    </div>
  </main>
  <!-- WAVES & BACKGROUND ELEMENTS -->
  <?php include './includes/background.php'; ?>
</body>

</html>