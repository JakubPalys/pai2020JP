<!-- public/views/profile.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
    <link rel="stylesheet" href="/public/css/profileStyle.css">
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
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_SESSION['error']); ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="profile-container">
    <h1>Profil użytkownika: <?php echo htmlspecialchars($user->getUsername()); ?></h1>

    <!-- Aktywne zakłady -->
    <section class="bets-section">
        <h2>Aktywne zakłady</h2>
        <?php if (empty($activeBets)): ?>
            <p>Brak aktywnych zakładów.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($activeBets as $bet): ?>
                    <li>Zakład na: <?php echo htmlspecialchars($bet->event->getEventName()); ?>, Kwota: <?php echo htmlspecialchars($bet->getBetAmount()); ?>, Wybór: <?php echo htmlspecialchars($bet->getBetChoice()); ?>, Potencjalna wygrana: <?php echo htmlspecialchars($bet->getPotentialWin()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <!-- Zakończone zakłady -->
    <section class="bets-section">
        <h2>Zakończone zakłady</h2>
        <?php if (empty($completedBets)): ?>
            <p>Brak zakończonych zakładów.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($completedBets as $bet): ?>
                    <li>Zakład na: <?php echo htmlspecialchars($bet->event->getEventName()); ?>, Kwota: <?php echo htmlspecialchars($bet->getBetAmount()); ?>, Wybór: <?php echo htmlspecialchars($bet->getBetChoice()); ?>, Wygrana: <?php echo htmlspecialchars(2*$bet->getPotentialWin()); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <!-- Zmiana hasła -->
    <section class="change-password-section">
        <h2>Zmiana hasła</h2>
        <form method="POST" action="/changePassword">
            <label for="old_password">Stare hasło:</label>
            <input type="password" name="old_password" required><br>

            <label for="new_password">Nowe hasło:</label>
            <input type="password" name="new_password" required><br>

            <label for="confirm_password">Potwierdź nowe hasło:</label>
            <input type="password" name="confirm_password" required><br>

            <button type="submit">Zmień hasło</button>
        </form>
    </section>

    <!-- Usunięcie konta -->
    <section class="delete-account-section">
        <h2>Usuń konto</h2>
        <form method="POST" action="/deleteAccount">
            <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć swoje konto?');">Usuń konto</button>
        </form>
    </section>
</div>
<div class="admin-link-container">
    <a href="/adminMenu" class="admin-link">Admin Menu</a>
</div>
</body>
</html>
