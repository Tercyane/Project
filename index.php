<?php include('./layouts/header.php'); ?>

<body>
    <div class="container ">
        <div class="card">
            <div class="card-title">
                <h1>Consulta de Signo Zodiacal</h1>
            </div>
            <div class="card-text">
                <form id="signo-form" method="POST" action="show_zodiac_sign.php">
                    <label class="form-label" for="birthdate">Selecione sua data de nascimento:</label>
                    <input class="form-control " type="date" name="birthdate" required>
                    <button class="btn btn-warning mt-3" type="submit">Consultar Signo</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>