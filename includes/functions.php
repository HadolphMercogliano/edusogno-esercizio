<?php

function login($conn,$email,$password) {

    $stmt = $conn->prepare("SELECT * FROM `utenti` WHERE `email` = ? AND `password` = ?");
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows) {
      if(session_status() != PHP_SESSION_ACTIVE) {
        session_start();
      }
      $user = $result->fetch_assoc();    
      $_SESSION["user_id"] = $user['id'];
      $_SESSION["user_name"] = $user['nome'];


      session_write_close();
      header("Location: userArea.php"); 
    exit();
  } else {
    return false;
  }
}

function logout() {
  if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
  }
}