<?php

class User
{
    private $id;
    private $username;
    private $email;
    private $passwordHash;
    private $roleId;
    private $points;

    public function __construct($id, $username, $email, $passwordHash, $roleId, $points)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->roleId = $roleId;
        $this->points = $points;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }
}
