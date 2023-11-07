<?php

$startTime = strtotime('08:00');
$endTime = strtotime('18:00');
$interval = 30 * 60; // 30 minutes en secondes

$slots = []; // Tableau pour stocker les créneaux d'une jouenée
$removedSlots = []; // Tableau pour stocker les créneaux supprimés

// Crée un tableau avec tous les créneaux horaires de la journée
while ($startTime < $endTime) {
    $slotStart = date('H:i', $startTime);
    $startTime += $interval;
    $slotEnd = date('H:i', $startTime);
    $slots[] = ['start' => $slotStart, 'end' => $slotEnd];
}

// Supprime les créneaux où des événements sont planifiés
$events = [
    ['start' => '09:00', 'end' => '11:30'],
    ['start' => '11:30', 'end' => '12:30'],
    ['start' => '11:00', 'end' => '11:30'],
    ['start' => '15:30', 'end' => '16:00'],
    ['start' => '17:30', 'end' => '18:00'],
    // Ajoutez d'autres événements avec leurs heures de début et de fin
];

foreach ($events as $event) {
    $eventStart = strtotime($event['start']);
    $eventEnd = strtotime($event['end']);
    $slots = array_filter($slots, function ($slot) use ($eventStart, $eventEnd, &$removedSlots) {
        $slotStart = strtotime($slot['start']);
        $slotEnd = strtotime($slot['end']);
        $isOverlapping = !($slotStart >= $eventEnd || $slotEnd <= $eventStart);

        if (!$isOverlapping) {
            $removedSlots[] = $slot; // Stocke les créneaux supprimés
        }

        return !$isOverlapping;
    });
}

// Maintenant, $slots contient les créneaux horaires disponibles
foreach ($slots as $slot) {
    echo 'Créneau disponible : ' . $slot['start'] . ' - ' . $slot['end'] . PHP_EOL . '<br>';
}

// Vous pouvez accéder aux créneaux supprimés dans $removedSlots si nécessaire

