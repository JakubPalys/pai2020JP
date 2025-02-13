<?php

class Event
{
    private $eventId;
    private $eventName;
    private $eventDate;
    private $statusId;
    private $homeOdds;
    private $awayOdds;
    private $drawOdds;

    public function __construct($eventId, $eventName, $eventDate,$statusId, $homeOdds, $awayOdds, $drawOdds)
    {
        $this->eventId = $eventId;
        $this->eventName = $eventName;
        $this->statusId = $statusId;
        $this->eventDate = $eventDate;
        $this->homeOdds = $homeOdds;
        $this->awayOdds = $awayOdds;
        $this->drawOdds = $drawOdds;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }
    public function getStatusId()
    {
        return $this->statusId;
    }
    public function getHomeOdds()
    {
        return $this->homeOdds;
    }

    public function getAwayOdds()
    {
        return $this->awayOdds;
    }

    public function getDrawOdds()
    {
        return $this->drawOdds;
    }
}
