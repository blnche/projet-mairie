<?php
    function safeEcho (string $text) : void
    {
        $safeText = htmlspecialchars($text);

        echo $safeText;
    }
?>