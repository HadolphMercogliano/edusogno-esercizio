<?php

function register($conn, $nome, $cognome, $email, $password) {
  // Controllo che nome e cognome non siano vuoti
  if (empty($nome)) {
    return "Inserisci il nome.";
  } 
  
  elseif (empty($cognome)) {
    return "Inserisci il cognome.";
  }

  // Controllo che l'email sia valida
  elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "Inserisci un indirizzo email valido.";
  }

  // Controllo che la password abbia almeno 8 caratteri
  elseif (strlen($password) < 8) {
    return "La password deve contenere almeno 8 caratteri.";
  } 
  
  else {
    // Controllo se l'email è già presente nel database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $count = 0;
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
if (isset($count) && $count > 0) {
  return "L'indirizzo email è già stato registrato.";
} 

else {
     
      $password = md5($password);
      $stmt = $conn->prepare("INSERT INTO `utenti` (`nome`, `cognome`, `email`, `password`) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $nome, $cognome, $email, $password);
      $stmt->execute();
      $stmt->close();

       if(session_status() != PHP_SESSION_ACTIVE) {
        session_start();
        $_SESSION["user_name"] = $_POST["nome"];
        $_SESSION["user_surname"] = $_POST["cognome"];
        $_SESSION["user_email"]= $_POST["email"];
      session_write_close();
      }

      return true;
    }
  }
}
?>