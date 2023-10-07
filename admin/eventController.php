<?php

class EventController {
    private $conn;

    public function __construct($conn) {
      $this->conn = $conn;
    }

    public function addEvent(Event $evento) {
      $nome_evento = $evento->getNomeEvento();
      $attendees = $evento->getAttendees();
      $data_evento = $evento->getDataEvento();
      
      $stmt = $this->conn->prepare("INSERT INTO eventi (nome_evento, attendees, data_evento) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $nome_evento, $attendees, $data_evento);
      
      if ($stmt->execute()) {
        $stmt->close(); 
        return true;
      } 
      else {
        $stmt->close();
        throw new Exception("Errore nell'inserimento dell'evento nel database.");
      }
    }
    

    public function getEvents() {
      $sql = "SELECT * FROM eventi";
      $result = $this->conn->query($sql);
      
      $events = [];

      if ($result) {
          while ($row = $result->fetch_assoc()) {
              $event = new Event($row['id'], $row['nome_evento'], $row['attendees'], $row['data_evento']);
              $events[] = $event;
          }
          $result->close(); // Chiudi il result set
      }

      return $events;
    }

    public function getEventById($id) {
    $stmt = $this->conn->prepare("SELECT * FROM eventi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();

    if (!$event) {
      return null; // L'evento non esiste
    }

    // Creazione di un'istanza dell'evento
    $eventObj = new Event($event['id'], $event['nome_evento'], $event['attendees'], $event['data_evento']);

    return $eventObj;
  }

    public function editEvent($id_evento, Event $event) {
      $nome_evento = $event->getNomeEvento();
      $attendees = $event->getAttendees();
      $data_evento = $event->getDataEvento();
      
      $stmt = $this->conn->prepare("UPDATE eventi SET nome_evento = ?, attendees = ?, data_evento = ? WHERE id = ?");
      $stmt->bind_param("sssi", $nome_evento, $attendees, $data_evento, $id_evento);
      
      if ($stmt->execute()) {
        $stmt->close();
        return true;
      } 
      else {
        $stmt->close();
        throw new Exception("Errore nell'aggiornamento dell'evento nel database.");
      }
    }
    

    public function deleteEvent($id_evento) {
        $stmt = $this->conn->prepare("DELETE FROM eventi WHERE id = ?");
        $stmt->bind_param("i", $id_evento);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            throw new Exception("Errore nell'eliminazione dell'evento dal database.");
        }
    }
}
?>