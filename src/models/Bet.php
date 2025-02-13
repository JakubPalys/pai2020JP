<?php

class Bet
{
    private $id;
    private $userId;
    private $eventId;
    private $betAmount;
    private $betChoice;
    private $betDate;
    private $potentialWin;
    public $event;
    public function __construct($id, $userId, $eventId, $betAmount, $betChoice, $betDate, $potentialWin)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->eventId = $eventId;
        $this->betAmount = $betAmount;
        $this->betChoice = $betChoice;
        $this->betDate = $betDate;
        $this->potentialWin = $potentialWin;
    }

    public function getBetId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getBetAmount()
    {
        return $this->betAmount;
    }

    public function getBetChoice()
    {
        return $this->betChoice;
    }

    public function getBetDate()
    {
        return $this->betDate;
    }

    public function getPotentialWin()
    {
        return $this->potentialWin;
    }
    public function getEvent()
    {
        return $this->event;
    }
    public function setEvent($event)
    {
        $this->event = $event;
    }
}
