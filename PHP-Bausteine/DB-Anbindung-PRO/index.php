<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'StudentRepository.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'StudentModel.php';

$start = 10000000;
$end   = 30000000;


// Verbindung zur Datenbank herstellen
try {
    $pdo = new PDO('mysql:host=localhost:3306; charset=utf8; dbname=db_anbindung_pro',
        'reginheart',
        'geDxxt82qQa0eek0'
    );
} catch (Exception $e) {
    echo "Verbindung zur Datenbank funktioniert nicht";
    exit;
}


$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


// Datenbankabfrage über die Klasse StudentRepository vornehmen
$studentRepository = new StudentRepository($pdo);
$student = $studentRepository->fetchStudentByMatNr($start, $end);

// 1. Ausgabe
echo 'Das Objekt $student sieht wie folgt aus:<pre>';
print_r($student);
echo '</pre>';

echo "<hr>";

// 2. Ausgabe
foreach ($student as $row) {
    echo $row->name . " ist im Studiengang " . $row->course . "<br>";
}

echo "<hr>";

// 3. Ausgabe
foreach ($student as $row) {
    $row->extractFirstName($row->name);
    echo $row->firstName . " ist im " . $row->semester . ". Semester <br>";
}

echo "<hr>";

// 4. Ausgabe
echo $student[1]->firstName . " studiert " . $student[1]->course;
