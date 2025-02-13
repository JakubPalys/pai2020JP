<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktywne Wydarzenia</title>
    <link rel="stylesheet" href="/public/css/homeStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
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

<!-- Komunikaty o sukcesie i błędzie -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_SESSION['success']); ?>
    </div>
    <?php unset($_SESSION['success']); // Usuwanie komunikatu po wyświetleniu ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_SESSION['error']); ?>
    </div>
    <?php unset($_SESSION['error']); // Usuwanie komunikatu po wyświetleniu ?>
<?php endif; ?>

<h1>Aktywne Wydarzenia</h1>

<?php if (!empty($events)): ?>
    <div class="events-list">
        <?php foreach ($events as $event): ?>
            <div class="event">
                <h3><?php echo htmlspecialchars($event->getEventName()); ?></h3>
                <p><?php echo "Data: " . $event->getEventDate(); ?></p>

                <!-- Formularz składania zakładu -->
                <form action="/placeBet" method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event->getEventId(); ?>" />

                    <label for="bet_choice">Wybierz wynik:</label><br />
                    <select name="bet_choice" required>
                        <option value="home">Zwycięstwo gospodarzy (kurs: <?php echo $event->getHomeOdds(); ?>)</option>
                        <option value="away">Zwycięstwo gości (kurs: <?php echo $event->getAwayOdds(); ?>)</option>
                        <option value="draw">Remis (kurs: <?php echo $event->getDrawOdds(); ?>)</option>
                    </select><br />

                    <label for="bet_amount">Kwota zakładu:</label><br />
                    <input type="number" name="bet_amount" required min="1" step="0.01" /><br />

                    <button type="submit" class="btn btn-primary">Postaw zakład</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Brak aktywnych wydarzeń.</p>
<?php endif; ?>
</body>
</html>
