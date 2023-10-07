<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require  "./vendor/autoload.php";


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
    return true;
  } else {
    return false;
  }
}

function saveResetToken($conn, $email, $token) {
  $stmt = $conn->prepare("UPDATE utenti SET reset_token = ? WHERE email = ?");
  $stmt->bind_param("ss", $token, $email);
  $stmt->execute();
  $stmt->close();
}

function sendEmail($to, $subject, $body) {

  $mail = new PHPMailer(true);

  try {

    // Configura le impostazioni del server SMTP
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Username = '86b3831d86f654';
    $mail->Password = '59164f528dff99';
    $mail->Port = 2525;

    // Imposta i dettagli dell'email
    $mail->setFrom('admin@edusogno.com', 'Admin');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;
    
    $mail->isHtml(true);

    // Invia l'email
    $mail->send();

    return true; 
  } catch (Exception $e) {
    // var_dump($e);
    return false; 
  }
}

function getEmailByResetToken($conn, $token) {
  $stmt = $conn->prepare("SELECT email FROM utenti WHERE reset_token = ?");
  $stmt->bind_param("s", $token);
  $stmt->execute();
  $email = 0;
  $stmt->bind_result($email);
  $stmt->fetch();
  $stmt->close();

  return $email;
}

function updatePassword($conn, $email, $password) {
  $hashedPassword = md5($password);
  $stmt = $conn->prepare("UPDATE utenti SET password = ? WHERE email = ?");
  $stmt->bind_param("ss", $hashedPassword, $email);
  $stmt->execute();
  $stmt->close();
}

function clearResetToken($conn, $email) {
  $stmt = $conn->prepare("UPDATE utenti SET reset_token = NULL WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->close();
}

function checkPasswordsMatch($password, $passwordConfirm) {
  return $password === $passwordConfirm;
}
?>