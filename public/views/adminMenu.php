<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="/public/css/adminMenuStyle.css">
</head>
<body>
<header>
    <a href="/home">
        <img id="logo" src="/public/img/logo.svg" alt="Logo" />
    </a>
    <div class="header-links">
        <div class="user-points">
            <span>Twoje punkty: <?php echo htmlspecialchars($user->getPoints()); ?></span>
        </div>
        <a href="/logout">Wyloguj się</a>
        <a href="/profile">
            <img class="profile-icon" src="/public/img/profile.png" alt="Profil" />
        </a>
    </div>
</header>


<section class="events-section">
    <h2>Wydarzenia</h2>

    <!-- Formularz do dodawania nowego wydarzenia -->
    <h3>Dodaj nowe wydarzenie</h3>
    <form method="POST" action="/addEvent">
        <label for="event_name">Nazwa wydarzenia:</label>
        <input type="text" name="event_name" required><br>

        <label for="event_date">Data wydarzenia:</label>
        <input type="datetime-local" name="event_date" required><br>

        <label for="status_id">Status:</label>
        <select name="status_id">
            <option value="1">Nowe</option>
            <option value="2">Zakończone</option>
        </select><br>

        <label for="home_odds">Kurs na gospodarzy:</label>
        <input type="number" step="0.01" name="home_odds" required><br>

        <label for="away_odds">Kurs na gości:</label>
        <input type="number" step="0.01" name="away_odds" required><br>

        <label for="draw_odds">Kurs na remis:</label>
        <input type="number" step="0.01" name="draw_odds" required><br>

        <button type="submit">Dodaj wydarzenie</button>
    </form>

    <h3>Lista wydarzeń</h3>
    <table>
        <tr>
            <th>Nazwa wydarzenia</th>
            <th>Data wydarzenia</th>
            <th>Status</th> <!-- Dodany status -->
            <th>Akcje</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event->getEventName()); ?></td>
                <td><?php echo htmlspecialchars($event->getEventDate()); ?></td>

                <!-- Wyświetlanie statusu -->
                <td>
                    <?php
                    $status = $event->getStatusId(); // Zakładamy, że metoda getStatusId() zwraca status
                    if ($status == 1) {
                        echo "Nowe";
                    } elseif ($status == 2) {
                        echo "Zakończone";
                    } else {
                        echo "Nieznany status";
                    }
                    ?>
                </td>

                <td>
                    <!-- Formularz usuwania -->
                    <form method="POST" action="/deleteEvent" onsubmit="return confirm('Czy na pewno chcesz usunąć to wydarzenie?');">
                        <input type="hidden" name="event_id" value="<?php echo $event->getEventId(); ?>">
                        <button type="submit">Usuń</button>
                    </form>

                    <!-- Formularz zakończenia -->
                    <form method="POST" action="/finishEvent" onsubmit="return confirm('Czy na pewno chcesz zakończyć to wydarzenie?');">
                        <input type="hidden" name="event_id" value="<?php echo $event->getEventId(); ?>">
                        <button type="submit">Zakończ</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<section class="users-section">
    <h2>Użytkownicy</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Rola</th>
            <th>Punkty</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user->getUsername()); ?></td>
                <td><?php echo $user->getRoleId() == 2 ? 'Admin' : 'Użytkownik'; ?></td>
                <td><?php echo htmlspecialchars($user->getPoints()); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

</body>
</html>
