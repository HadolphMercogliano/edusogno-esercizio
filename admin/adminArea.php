<?php
require_once "../includes/database.php";
require_once('eventClass.php');
require_once('eventController.php');

// Creazione di un'istanza del controller degli eventi
$eventController = new EventController($conn);

if(session_status() != PHP_SESSION_ACTIVE) {
  session_start();
  if (isset($_SESSION["user_name"])) {
    $nome = $_SESSION["user_name"];
    $email = $_SESSION["user_email"];
    $cognome = $_SESSION["user_surname"];

    // Ottieni tutti gli eventi 
    $events = $eventController->getEvents();
  }
  else {
    header("Location: ../index.php");
    exit;
  }
  
  session_write_close();
}
 if (isset($_POST["delete"])) {
  $id_evento = $_POST["delete"];
  try {
    $eventController->deleteEvent($id_evento);

    header("Location: adminArea.php");
    exit;
  } 
  catch (Exception $e) {
    $error_message = $e->getMessage();
  }
  
 }

if (isset($_POST["logout"])) {
  logout();
  session_write_close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/style.css">
  <link rel="stylesheet" href="../assets/styles/adminAreaStyle.css">

  <title>Edusogno - Admin Dashboard</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://edusogno.com/logo-black.svg" alt="">
    </div>
    <form id="logoutForm" method="POST">
      <button class="btn" name="logout" value="1">Logout</button>
    </form>
  </header>

  <main>
    <h1>Admin dashboard</h1>
    <div class="container">
      <a href="addEvent.php" class="btn btn-add">Aggiungi evento</a>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome Evento</th>
            <th>Attendees</th>
            <th>Data Evento</th>
            <th>Azioni</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $event) : ?>
          <tr>
            <td><?php echo $event->getId(); ?></td>
            <td><?php echo $event->getNomeEvento(); ?></td>
            <td><?php echo $event->getAttendees(); ?></td>
            <td><?php echo $event->getDataEvento(); ?></td>
            <td class="actions">
              <a href="editEvent.php?id=<?php echo $event->getId(); ?>" class="btn">M</a>
              <form method="post">
                <button class="btn btn-delete" type="submit" name="delete"
                  value="<?php echo $event->getId(); ?>">X</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>