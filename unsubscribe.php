<?php


$message = "Du wurdest aus der Mailing-Liste entfernt und erhältst in Zukunft keine Redewendungen mehr per Mail.";
if (isset($_GET["email"])) {
    $email = urldecode($_GET["email"]);
    $f = file_get_contents("./data/emails.txt");
    $emails = explode("\n", $f);
    $newemails = array();
    foreach ($emails as $e) {
        if ($e != $email) array_push($newemails, $e);
    }
    file_put_contents("./data/emails.txt", implode("\n", $newemails));

    if (count($emails) == count($newemails)) $message = "Deine Email ist nicht in unserem System vorhanden.";
} else {
    $message = "Deine Email ist nicht in unserem System vorhanden.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abmeldung</title>
</head>

<body>
    <h3><?= $message ?></h3>
</body>

</html>