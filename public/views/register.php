<!-- public/views/register.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="/public/css/loginStyle.css">
</head>
<body>

<div class="container">
    <img src="/public/img/logo.svg" alt="Logo" class="logo">

    <h1>Rejestracja</h1>

    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="/register" method="post">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required> <!-- Pole e-mail -->

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Potwierdź hasło:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Zarejestruj się</button>
    </form>
    <p>Masz już konto? <a href="/login">Zaloguj się</a></p>
    <p>
