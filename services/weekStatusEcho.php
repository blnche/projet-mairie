<?php
function checkStatus($status, $type, $day) : string
{
    $print;
    
    if ($status === "Yes") {
        $print = '✅';
    } else if ($status === "No") {
        $print = '❌';
    } else if ($type === 'form') {
        if ($status === "Holiday") {
            $print = '
                <fieldset>
                    <label for="'.$day.'Placebo">(Vacances/Férié)</label>
                    <input type="checkbox" name="'.$day.'Placebo" value="Holiday" checked disabled>
                    <input type="hidden" value="Holiday" name="'.$day.'Placebo">
                </fieldset>';
        } else {
            $print = '
                <fieldset>
                    <label for="'.$day.'"></label>
                    <input type="checkbox" name="'.$day.'" value="Yes">
                </fieldset>️';
        }
    } else if ($status === "Holiday") {
        $print = '☀️';
    } else {
        $print = '-';
    }

    return $print;
}
?>