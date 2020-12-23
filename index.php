<?php
////////////////////////////////
// handle post form submit
$EMALFILEPATH = "./data/emails.txt";
$email = "";
$thankyou = "";
if (isset($_GET["thankyou"]) && $_GET["thankyou"] == "1") $thankyou = "Super, ab jetzt lernst du jeden Tag eine neue Redensart kennen.";
if (isset($_GET["thankyou"]) && $_GET["thankyou"] == "2") $thankyou = "Wir haben deine Email Adresse bereits in unserem System.";

if (!$thankyou && isset($_POST["email"])) {
    $email = trim($_POST["email"]);
    $email = preg_replace("/(\r\n|\n|\r)/", "", $email);
    $currentemails = file_get_contents($EMALFILEPATH);
    if (!stristr($currentemails, $email)) {
        file_put_contents($EMALFILEPATH, $email . "\n", FILE_APPEND);
        // TODO erste Bestätigungsmail senden.
        $ret = exec('cd C:\xampp\htdocs\redewendungen-im-deutschen; node mailer.js 2>&1', $out, $err);

        header("Location:index.php?thankyou=1");
    } else {
        $thankyou = "Diese Mail ist im System bereits vorhanden.";
        header("Location:index.php?thankyou=2");
    }
}



////////////////////////////////
// fetch saying
$sayingsAsJSON = file_get_contents("./data/redewendungen_shuffled.json");
$sayingsArr = json_decode($sayingsAsJSON, true);
$randomIndex =  random_int(0, count($sayingsArr) - 1);
$chosenSaying = $sayingsArr[$randomIndex];
while (count($chosenSaying["meanings"]) == 0) {
    $randomIndex =  random_int(0, count($sayingsArr) - 1);
    $chosenSaying = $sayingsArr[$randomIndex];
}





function getRandomSaying()
{
    return "";
}


?>

<!DOCTYPE html>

<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0" />
    <title>Deutsche Redensarten lernen</title>
    <meta name="description" content="Täglich neue Redewendungen lernen: Tausende deutsche Ausdrücke, die die eigene Sprache verschönern.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        #quote {
            font-style: italic;
        }

        #credit {
            font-size: 12px;
        }
    </style>
    <nav class="navbar bg-success navbar-dark">
        <div class="container" style="position: relative">
            <div class="text-center navbar-brand" style="width: 100%">
                Redewendungen lernen
            </div>
            <a href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" style="position:absolute; right: 16; top: 8; cursor: pointer;" width="24" height="24" viewBox="0 0 24 24" fill="#FFF">
                    <path d="M13.5 2c-5.629 0-10.212 4.436-10.475 10h-3.025l4.537 5.917 4.463-5.917h-2.975c.26-3.902 3.508-7 7.475-7 4.136 0 7.5 3.364 7.5 7.5s-3.364 7.5-7.5 7.5c-2.381 0-4.502-1.119-5.876-2.854l-1.847 2.449c1.919 2.088 4.664 3.405 7.723 3.405 5.798 0 10.5-4.702 10.5-10.5s-4.702-10.5-10.5-10.5z" /></svg>
            </a>
        </div>
    </nav>
    <div class="container">
        <h1 class="p-4 mt-4 mb-4 text-center" id="quote">
            "<?= $chosenSaying["title"] ?>"
        </h1>
    </div>
    <div class=" text-dark mb-4 ">
        <div class="container bg-light shadow-sm rounded">
            <div class="p-4 mt-4">
                <h2>Bedeutung:</h2>
                <p class="">
                    <?= $chosenSaying["meanings"][0] ?>
                </p>
            </div>
        </div>
    </div>
    <?php if (count($chosenSaying["examples"]) != 0) : ?>
        <div class=" text-dark mb-4 ">
            <div class="container bg-light shadow-sm rounded">
                <div class="p-4 mt-4">
                    <h2>Beispiel:</h2>
                    <?php foreach ($chosenSaying["examples"] as $example) : ?>
                        <p>
                            <?= $example ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (count($chosenSaying["herkunft"]) != 0) : ?>
        <div class=" text-dark mb-4 ">
            <div class="container bg-light shadow-sm rounded">
                <div class="p-4 mt-4">
                    <h2>Herkunft:</h2>
                    <?php foreach ($chosenSaying["herkunft"] as $example) : ?>
                        <p>
                            <?= $example ?>
                        </p>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class=" text-dark mb-4 ">
        <div class="container bg-light shadow-sm rounded">
            <div class="p-4 mt-4">
                <h2>Jeden Tag dazulernen:</h2>
                <?php if (!$thankyou) : ?>
                    <p>
                        Wir schicken dir jeden morgen eine Email, mit der Redewendung des
                        Tages
                    </p>
                    <form method="post" action="index.php">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Deine Email Adresse:</label>
                            <input type="email" required class="form-control mt-4" id="exampleFormControlInput1" name="email" placeholder="name@example.com" />
                            <button type="submit" class="btn btn-success mt-4 mb-4">Abschicken</button>
                        </div>
                    </form>
                <?php else : ?>
                    <p class="text-success">
                        <?= $thankyou ?>
                    </p>

                <?php endif; ?>
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