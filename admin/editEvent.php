<?php
require_once "../includes/database.php";
require_once('eventClass.php');
require_once('eventController.php');

// Creazione di un'istanza del controller degli eventi
$eventController = new EventController($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id_evento = $_POST["id_evento"];
  $nome_evento = $_POST["nome_evento"];
  $attendees = $_POST["attendees"];
  $data_evento = $_POST["data_evento"];

  $event = new Event($id_evento, $nome_evento, $attendees, $data_evento);

  try {
    $eventController->editEvent($id_evento, $event);
    // Reindirizza l'utente alla pagina di dashboard dopo l'aggiornamento dell'evento
    header("Location: adminArea.php");
    exit;
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
}

$id_evento = $_GET["id"];

// Ottieni l'evento dal controller degli eventi
$event = $eventController->getEventById($id_evento);

if (!$event) {
  header("Location: adminArea.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/styles/style.css">
  <link rel="stylesheet" href="../assets/styles/userAreaStyle.css">
  <link rel="stylesheet" href="../assets/styles/adminAreaStyle.css">


  <title>Modifica Evento</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="https://edusogno.com/logo-black.svg" alt="">
    </div>
  </header>
  <main>
    <h1>Modifica Evento</h1>
    <div class="form-area">
      <?php if (isset($error_message)): ?>
      <p class="error-message"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <form method="post">
        <input type="hidden" name="id_evento" value="<?php echo $event->getId(); ?>">
        <div>
          <label for="nome_evento">Nome Evento</label>
          <input type="text" id="nome_evento" name="nome_evento" value="<?php echo $event->getNomeEvento(); ?>"
            required>
        </div>
        <div>
          <label for="attendees">Attendees</label>
          <input type="text" id="attendees" name="attendees" value="<?php echo $event->getAttendees(); ?>" required>
        </div>
        <div>
          <label for="data_evento">Data e Ora:</label>
          <input type="datetime-local" id="data_evento" name="data_evento"
            value="<?php echo $event->getDataEvento(); ?>" required>

        </div>
        <div class="button-container d-flex">
          <button id="submitBtn" type="submit" class="btn">Salva Modifiche</button>
          <a id="btn-cancel" href="./adminArea.php" class="btn">annulla</a>
        </div>

      </form>
    </div>
  </main>
  <!-- WAVES & BACKGROUND ELEMENTS -->
  <?php include '../includes/background.php'; ?>
</body>

</html>