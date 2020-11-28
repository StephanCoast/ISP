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

echo "<br><br>";

//ZUFALL - Lottozahlengenerator
for ($number = 1; $number <= 49; $number++) {
    $numbers[] = $number;
}

for ($quantity = 1; $quantity <= 6; $quantity++) {
    $key = mt_rand(0, count($numbers) - 1);
    $drawnNumbers[] = $numbers[$key];
    unset($numbers[$key]);
    $numbers = array_values($numbers);
}

sort($drawnNumbers);
foreach ($drawnNumbers as $number) {
    echo "$number <br>\r\n";
}

echo "<br>";

//Kürzer
$drawnNumbers = array_rand($numbers, 6);
foreach ($drawnNumbers as $number) {
    echo "$number <br>\r\n";
}