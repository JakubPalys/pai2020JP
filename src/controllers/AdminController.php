<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../repository/EventRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/BetRepository.php';

class AdminController extends AppController
{
    // Sprawdzenie czy użytkownik ma rolę admina
    private function checkAdmin()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserByUsername($_SESSION['user']);

        if ($user->getRoleId() !== 2) {
            header('Location: /profile');
            exit;
        }

        return $user;
    }

    // Strona administracyjna
    public function adminMenu()
    {
        $user = $this->checkAdmin();  // Sprawdzamy czy to admin

        $eventRepository = new EventRepository();
        $events = $eventRepository->getAllEvents();

        $userRepository = new UserRepository();
        $users = $userRepository->getAllUsers();

        $this->render('adminMenu', [
            'user' => $user,
            'events' => $events,
            'users' => $users
        ]);
    }

    // Dodawanie nowego eventu
    public function addEvent()
    {
        $this->checkAdmin();

        if ($this->isPost()) {
            $eventName = $_POST['event_name'];
            $eventDate = $_POST['event_date'];
            $statusId = $_POST['status_id'];
            $homeOdds = $_POST['home_odds'];
            $awayOdds = $_POST['away_odds'];
            $drawOdds = $_POST['draw_odds'];

            $eventRepository = new EventRepository();
            $eventRepository->addEvent($eventName, $eventDate, $statusId, $homeOdds, $awayOdds, $drawOdds);

            header('Location: /adminMenu');
            exit;
        }
    }




// Usuwanie eventu
    public function deleteEvent()
    {
        $this->checkAdmin();

        if (isset($_POST['event_id'])) {
            $eventId = $_POST['event_id'];

            $eventRepository = new EventRepository();

            $eventRepository->deleteEvent($eventId);

            header('Location: /adminMenu');
            exit;
        }
    }





    // Zakończenie wydarzenia
    public function finishEvent()
    {
        $this->checkAdmin();

        if ($this->isPost()) {
            $eventId = $_POST['event_id'];

            $eventRepository = new EventRepository();
            $betRepository = new BetRepository();

            $eventRepository->updateEventStatus($eventId, 2);

            $bets = $betRepository->getBetsByEventId($eventId);
            foreach ($bets as $bet) {
                $betRepository->settleBet($bet);
            }

            header('Location: /adminMenu');
            exit;
        }
    }








}
