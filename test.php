<?php

    // jon - newPassword123
    $mark = "tldrP@ssword";
    $betty = "SimonRulez48";
    $marshall = "MarkisStupid49";
    $gov = "superSecretPassword01";

    echo password_hash($mark, PASSWORD_DEFAULT) . "<br>";
    echo password_hash($betty, PASSWORD_DEFAULT) . "<br>";
    echo password_hash($marshall, PASSWORD_DEFAULT) . "<br>";
    echo password_hash($gov, PASSWORD_DEFAULT) . "<br>";

?>