<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Bet.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../repository/EventRepository.php';
require_once __DIR__ . '/../repository/BetRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class DefaultController extends AppController
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        header('Location: /home');
        exit;
    }

    public function home()
    {
        session_start();


        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUsername($_SESSION['user']);

        $eventRepository = new EventRepository();
        $events = $eventRepository->getActiveEvents();

        $this->render('home', ['events' => $events, 'user' => $user]);
    }


    // Składanie zakładu
    public function placeBet()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($this->isPost()) {
            $eventId = $_POST['event_id'];
            $betAmount = $_POST['bet_amount'];
            $betChoice = $_POST['bet_choice'];

            $eventRepository = new EventRepository();
            $event = $eventRepository->getEventById($eventId);

            $odds = 0;
            switch ($betChoice) {
                case 'home':
                    $odds = $event->getHomeOdds();
                    break;
                case 'away':
                    $odds = $event->getAwayOdds();
                    break;
                case 'draw':
                    $odds = $event->getDrawOdds();
                    break;
            }

            $potentialWin = $betAmount * $odds;

            $userRepository = new UserRepository();
            $user = $userRepository->getUserByUsername($_SESSION['user']);
            $events = $eventRepository->getActiveEvents();

            if ($user->getPoints() < $betAmount) {
                $_SESSION['error'] = 'Nie masz wystarczającej ilości punktów na ten zakład.';
                header('Location: /home');
                exit;
            }

            $betRepository = new BetRepository();
            $betRepository->createBet($user->getId(), $eventId, $betAmount, $betChoice, $potentialWin);

            $userRepository->updateUserPoints($user->getUsername(), $user->getPoints() - $betAmount);

            $_SESSION['success'] = 'Zakład został pomyślnie złożony! Powodzenia!';

            header('Location: /home');
            exit;
        }
    }





    // Wylogowanie użytkownika
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: /login');
        exit;
    }
}
