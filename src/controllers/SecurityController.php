<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    // Strona logowania
    public function login()
    {
        session_start();

        // Jeśli użytkownik już jest zalogowany, przekierowanie na stronę główną
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }

        // Obsługa logowania, jeśli formularz został wysłany
        if ($this->isPost()) {
            // Pobranie danych logowania
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userRepository = new UserRepository();

            // Pobieranie użytkownika z repozytorium na podstawie nazwy użytkownika
            $user = $userRepository->getUserByUsername($username);

            if ($user && password_verify($password, $user->getPasswordHash())) {
                // Jeśli użytkownik istnieje i hasło jest poprawne, zapisujemy użytkownika w sesji
                $_SESSION['user'] = $user->getUsername();
                header('Location: /home'); // Po zalogowaniu, przejście do strony głównej
                exit;
            } else {
                // Jeśli dane logowania są błędne, wyświetlenie komunikatu
                $this->render('login', ['error' => 'Niepoprawna nazwa użytkownika lub hasło']);
            }
        } else {
            // Jeśli nie jest to POST, po prostu wyświetlamy formularz logowania
            $this->render('login');
        }
    }

    // Strona rejestracji
    public function register()
    {
        session_start();

        // Jeśli użytkownik już jest zalogowany, przekierowanie na stronę główną
        if (isset($_SESSION['user'])) {
            header('Location: /home');
            exit;
        }

        // Obsługa rejestracji, jeśli formularz został wysłany
        if ($this->isPost()) {
            // Pobranie danych rejestracyjnych
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Weryfikacja, czy hasła są takie same
            if ($password !== $confirmPassword) {
                $this->render('register', ['error' => 'Hasła muszą być takie same']);
                return;
            }

            $userRepository = new UserRepository();

            // Sprawdzenie, czy użytkownik o danej nazwie już istnieje
            if ($userRepository->getUserByUsername($username)) {
                $this->render('register', ['error' => 'Nazwa użytkownika jest już zajęta']);
                return;
            }

            // Tworzenie nowego użytkownika
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $newUser = new User(0, $username, $email, $hashedPassword, 1, 1000); // userId=0 (baza danych zajmie się generowaniem ID), rola=1, punkty=1000

            // Zapisanie użytkownika w bazie
            $userRepository->createUser($newUser);

            // Po rejestracji, przekierowanie do logowania
            header('Location: /login');
            exit;
        }

        // Wyświetlenie formularza rejestracji
        $this->render('register');
    }
}
