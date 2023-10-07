<?php 
function checkEmailExists($conn, $email) {
// Verifica se l'email è registrata nel database
  $stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $count = 0;
  $stmt->bind_result($count);
  $stmt->fetch();
  $stmt->close();

  if ($count > 0) {
    return true; // L'email è registrata nel database
  } else {
    return false; // L'email non è registrata nel database
  }
}

function generatePasswordResetToken() {
  $token = uniqid();
  return $token;
}

function sendPasswordResetEmail($to, $token) {
  $subject = "Reset Password";
  $message = "Ciao,\n\n Hai richiesto il reset della password. Clicca sul seguente link per reimpostare la tua password:\n\n";
  $message .= "http://localhost/Esercizi%20Corso%20Boolean/edusogno-esercizio/reset-password.php?token=" . urlencode($token);
  $headers = "From: Edusogno@mail.com";

  if (mail($to, $subject, $message, $headers)) {
    return true; // L'email è stata inviata con successo
  } else {
    return false; // Si è verificato un errore durante l'invio dell'email
  }
}
?>