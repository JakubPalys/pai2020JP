<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Bet.php';

class BetRepository extends Repository
{
    public function createBet($userId, $eventId, $betAmount, $betChoice, $potentialWin)
    {
        $stmt = $this->connect()->prepare('
        INSERT INTO bets (user_id, event_id, bet_amount, bet_choice, bet_date, potential_win) 
        VALUES (:user_id, :event_id, :bet_amount, :bet_choice, current_timestamp, :potential_win)
    ');
        $stmt->execute([
            'user_id' => $userId,
            'event_id' => $eventId,
            'bet_amount' => $betAmount,
            'bet_choice' => $betChoice,
            'potential_win' => $potentialWin
        ]);
    }


    public function getSortBetsByUser($userId, $status = 'active')
    {
        $statusCondition = ($status === 'active') ? 'AND events.status_id = 1' : 'AND events.status_id = 2';
        $stmt = $this->connect()->prepare('
        SELECT bets.*, events.status_id
        FROM bets
        INNER JOIN events ON bets.event_id = events.event_id
        WHERE bets.user_id = :user_id ' . $statusCondition
        );
        $stmt->execute(['user_id' => $userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bets = [];
        foreach ($data as $betData) {
            $bet = new Bet(
                $betData['bet_id'],
                $betData['user_id'],
                $betData['event_id'],
                $betData['bet_amount'],
                $betData['bet_choice'],
                $betData['bet_date'],
                $betData['potential_win']
            );
            $bets[] = $bet;
        }

        return $bets;
    }

    public function getBetsByEventId($eventId) {
        $sql = "SELECT * FROM bets WHERE event_id = :event_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);  // Zwracamy tablicę obiektów zakładów
    }

    public function deleteBetsByUserId($userId)
    {
        $stmt = $this->connect()->prepare('DELETE FROM bets WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
    }



    public function settleBet($betId, $eventId, $eventResult)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM bets WHERE bet_id = :bet_id');
        $stmt->execute(['bet_id' => $betId]);
        $betData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$betData) {
            throw new Exception("Zakład o podanym ID nie istnieje.");
        }

        $isWin = false;
        $isDraw = false;
        if ($eventResult === $betData['bet_choice']) {
            $isWin = true;
        } elseif ($eventResult === 'draw' && $betData['bet_choice'] === 'draw') {
            $isDraw = true;
        }

        $stmt = $this->connect()->prepare('
            UPDATE bets 
            SET potential_win = :potential_win, 
                bet_status = :bet_status 
            WHERE bet_id = :bet_id
        ');

        $potentialWin = 0;
        $betStatus = 'lost';

        if ($isWin) {
            $potentialWin = $betData['bet_amount'] * 2;
            $betStatus = 'won';
        } elseif ($isDraw) {
            $potentialWin = $betData['bet_amount'];
            $betStatus = 'draw';
        }

        $stmt->execute([
            'bet_id' => $betId,
            'potential_win' => $potentialWin,
            'bet_status' => $betStatus
        ]);

        return $betStatus;
    }
}