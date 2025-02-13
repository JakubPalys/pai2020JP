<!-- public/views/login.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link rel="stylesheet" href="/public/css/loginStyle.css">
</head>
<body>

<div class="container">
    <img src="/public/img/logo.svg" alt="Logo" class="logo">

    <h1>Logowanie</h1>

    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="/login" method="post">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Zaloguj się</button>
    </form>

    <p>Nie masz konta? <a href="/register">Zarejestruj się</a></p>
</div>

</body>
</html>
