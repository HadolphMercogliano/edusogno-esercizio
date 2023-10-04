<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/styles/style.css">
  <title>Edusogno</title>
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
      <form action="">

        <div>
          <label for="email">Inserisci l'email</label>
          <input type="email" id="email" placeholder="name@example.com" name="email">
          <span id="emailError" class="error-message"></span>
        </div>

        <div>
          <label for="password">Inserisci la password</label>
          <input type="password" id="password" placeholder="Scrivila qui" name="password">
          <span id="passwordError" class="error-message"></span>
        </div>
        <div class="submit-button">
          <button type="submit" id="submitBtn">accedi</button>
        </div>
      </form>
      <a href="./index.php">Non hai ancora un profilo?<b> Registrati</b></a>
    </div>
  </main>

</body>

</html>