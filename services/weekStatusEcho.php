<?php
    function checkStatus($status) : void
    {
        if ($status === "Yes")
        {
            $print = '✅';
        } else if ($status === "No")
        {
            $print = '❌';
        } else if ($status === "Holiday")
        {
            $print = '☀️';
        } else
        {
            $print = '-';
        }

        echo $print;
    }
?>