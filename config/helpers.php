<?php
function formatINR($amount) {
    if ($amount == null) return "0";

    $amount = (string) $amount;
    $decimal = "";

    if (strpos($amount, '.') !== false) {
        list($amount, $decimal) = explode('.', $amount);
        $decimal = "." . substr($decimal, 0, 2);
    }

    $last3 = substr($amount, -3);
    $rest  = substr($amount, 0, -3);

    if ($rest !== '') {
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
        return $rest . "," . $last3 . $decimal;
    }

    return $last3 . $decimal;
}
