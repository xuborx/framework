<?php

function prePrintR($data, $exit = false) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($exit) {
        exit();
    }
}