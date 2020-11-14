<?php
$rgb = ["Red", "Green", "Blue"];
$cmyk = ["C" => "Cyan", "M" => "Magenta", "Y" => "Yellow", "K" => "Key"];

echo "rgb besteht aus: ";
foreach ($rgb as $color) {
    echo "$color, ";
}

echo "<br>cmyk besteht aus: ";
foreach ($cmyk as $letter => $color) {
    echo "$letter für $color, ";
}