<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Event.php';

class EventRepository extends Repository
{
    public function getActiveEvents()
    {
        $stmt = $this->connect()->prepare('SELECT * FROM events WHERE status_id = 1');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($data as $eventData) {
            $event = new Event(
                $eventData['event_id'],
                $eventData['event_name'],
                $eventData['event_date'],
                $eventData['status_id'],
                $eventData['home_odds'],
                $eventData['away_odds'],
                $eventData['draw_odds']
            );
            $events[] = $event;
        }

        return $events;
    }

    public function getEventById($eventId)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM events WHERE event_id = :event_id');
        $stmt->execute(['event_id' => $eventId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Event(
                $data['event_id'],
                $data['event_name'],
                $data['event_date'],
                $data['status_id'],
                $data['home_odds'],
                $data['away_odds'],
                $data['draw_odds']
            );
        }

        return null;
    }

    public function getAllEvents()
    {
        $stmt = $this->connect()->prepare('SELECT * FROM events');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($data as $eventData) {
            $event = new Event(
                $eventData['event_id'],
                $eventData['event_name'],
                $eventData['event_date'],
                $eventData['status_id'],
                $eventData['home_odds'],
                $eventData['away_odds'],
                $eventData['draw_odds']
            );
            $events[] = $event;
        }

        return $events;
    }

    // Dodaje nowe wydarzenie do bazy
    public function addEvent($eventName, $eventDate, $statusId, $homeOdds, $awayOdds, $drawOdds)
    {
        $stmt = $this->connect()->prepare('
            INSERT INTO events (event_name, event_date, status_id, home_odds, away_odds, draw_odds)
            VALUES (:event_name, :event_date, :status_id, :home_odds, :away_odds, :draw_odds)
        ');

        $stmt->execute([
            'event_name' => $eventName,
            'event_date' => $eventDate,
            'status_id' => $statusId,
            'home_odds' => $homeOdds,
            'away_odds' => $awayOdds,
            'draw_odds' => $drawOdds
        ]);
    }


    // Usuwa wydarzenie z bazy
    public function deleteEvent($eventId)
    {
        $stmt = $this->connect()->prepare('
            DELETE FROM events WHERE event_id = :event_id
        ');

        $stmt->execute([
            'event_id' => $eventId
        ]);
    }

    // Aktualizuje status wydarzenia
    public function updateEventStatus($eventId, $statusId)
    {
        $stmt = $this->connect()->prepare('
            UPDATE events
            SET status_id = :status_id
            WHERE event_id = :event_id
        ');

        $stmt->execute([
            'event_id' => $eventId,
            'status_id' => $statusId
        ]);
    }

}
