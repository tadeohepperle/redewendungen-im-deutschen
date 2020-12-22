<?php


$SAYINGS = file_get_contents("./data/redewendungen.json");


function getRandomSaying()
{
    return "";
}


?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0" />
    <title>Deutsche Redensarten lernen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        #quote {}

        #credit {
            font-size: 12px;
        }
    </style>
    <nav class="navbar bg-success navbar-dark">
        <div class="text-center navbar-brand" style="width: 100%">
            Redewendungen lernen
        </div>
    </nav>
    <div class="container">
        <h1 class="p-4 mt-4 mb-4 text-center" id="quote">
            "das Kind mit dem Bade ausschütten"
        </h1>
    </div>
    <div class="bg-light text-dark mb-4 shadow-sm rounded">
        <div class="container">
            <div class="p-4 mt-4">
                <h2>Bedeutung:</h2>
                <p class="" id="quote">
                    Mit einer bestimmten Handlungsweise auch erhaltenswerte Zustände
                    beseitigen, oder auch bei einer Diskussion in einer Art und Weise
                    argumentieren, dass wichtige Zustände ignoriert werden und bei
                    Folgehandlungen verlorenzugehen drohen.
                </p>
            </div>
        </div>
    </div>
    <div class="bg-light text-dark mb-4 shadow-sm rounded">
        <div class="container">
            <div class="p-4 mt-4">
                <h2>Beispiel:</h2>
                <p class="" id="quote">
                    "Wenn wir jetzt eine Zugangskontrolle mit Röntgenschleuse
                    einrichten, dann schütten wir das Kind mit dem Bade aus."
                </p>
            </div>
        </div>
    </div>
    <div class="bg-light text-dark mb-4 pb-4 shadow-sm rounded">
        <div class="container">
            <div class="p-4 mt-4">
                <h2>Jeden Tag dazulernen:</h2>
                <p>
                    Wir schicken dir jeden morgen eine Email, mit der Redewendung des
                    Tages
                </p>
                <form>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Deine Email Adresse:</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <div class="text-center navbar-brand" style="width: 100%; font-size: 16px">
                24.12.2020 – Für Linh zum Geburtstag ♡
            </div>
        </div>
    </nav>
</body>

</html>