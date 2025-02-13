<?php

require_once __DIR__ . '/../models/User.php';
require_once 'Repository.php';

class UserRepository extends Repository
{
    // Pobieranie użytkownika na podstawie nazwy użytkownika
    public function getUserByUsername($username)
    {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new User(
                $data['user_id'],       // userId
                $data['username'],      // username
                $data['email'],         // email
                $data['password_hash'], // password_hash
                $data['role_id'],       // role_id
                $data['points']         // points
            );
        }

        return null;
    }

    // Tworzenie nowego użytkownika
    public function createUser(User $user)
    {
        $stmt = $this->connect()->prepare(
            'INSERT INTO users (username, email, password_hash, role_id, points) 
             VALUES (:username, :email, :password_hash, :role_id, :points)'
        );
        $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password_hash' => $user->getPasswordHash(),
            'role_id' => $user->getRoleId(),
            'points' => $user->getPoints()
        ]);
    }

    public function updateUserPoints($userId, $newPoints)
    {
        $stmt = $this->connect()->prepare(
            'UPDATE users SET points = :points WHERE user_id = :user_id'
        );
        $stmt->execute([
            'user_id' => $userId,
            'points' => $newPoints
        ]);
    }
    public function updateUserPassword($userId, $hashedPassword)
    {
        $stmt = $this->connect()->prepare('
        UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id
    ');
        $stmt->execute(['password_hash' => $hashedPassword, 'user_id' => $userId]);
    }

    public function deleteUser($userId)
    {
        $stmt = $this->connect()->prepare('DELETE FROM users WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
    }
    public function getAllUsers()
    {
        $stmt = $this->connect()->prepare('SELECT * FROM users');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($data as $userData) {
            $users[] = new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password_hash'],
                $userData['role_id'],
                $userData['points']
            );
        }

        return $users;
    }

}
