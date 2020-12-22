<?php

function maileveryone()
{
    // get all email adresses:
    $emailfile = file_get_contents('./data/emails.txt');
    $emails = explode("\n", $emailfile);
    var_dump($emails);
}

maileveryone();
