<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Bet.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../repository/BetRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class ProfileController extends AppController
{
    // Wyświetlanie profilu użytkownika
    public function profile()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUsername($_SESSION['user']);

        // Pobieramy aktywne i zakończone zakłady użytkownika
        $betRepository = new BetRepository();
        $activeBets = $betRepository->getSortBetsByUser($user->getId(), 'active');
        $completedBets = $betRepository->getSortBetsByUser($user->getId(), 'completed');

        // Łączymy zakłady z danymi o wydarzeniu
        $eventRepository = new EventRepository();
        foreach ($activeBets as $bet) {
            $betEvent = $eventRepository->getEventById($bet->getEventId());
            $bet->setEvent($betEvent);  // Przypisanie wydarzenia do zakładu
        }

        foreach ($completedBets as $bet) {
            $betEvent = $eventRepository->getEventById($bet->getEventId());
            $bet->setEvent($betEvent);  // Przypisanie wydarzenia do zakładu
        }

        // Wyświetlamy stronę profilu
        $this->render('profile', [
            'user' => $user,
            'activeBets' => $activeBets,
            'completedBets' => $completedBets
        ]);
    }

    // Zmiana hasła
    public function changePassword()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUsername($_SESSION['user']);
        $betRepository = new BetRepository();
        $activeBets = $betRepository->getSortBetsByUser($user->getId(), 'active');
        $completedBets = $betRepository->getSortBetsByUser($user->getId(), 'completed');

        if ($this->isPost()) {
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!password_verify($oldPassword, $user->getPasswordHash())) {
                $_SESSION['error'] = 'Stare hasło jest niepoprawne.';
                header('Location: /profile');
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Hasła nie są takie same.';
                header('Location: /profile');
                exit;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $userRepository->updateUserPassword($user->getId(), $hashedPassword);

            $_SESSION['success'] = 'Haslo zmienione!';

            header('Location: /profile');
            exit;
        }
    }

    // Usunięcie konta
    public function deleteAccount()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUsername($_SESSION['user']);

        $betRepository = new BetRepository();
        $betRepository->deleteBetsByUserId($user->getId());

        $userRepository->deleteUser($user->getId());

        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
