<?php


$slotSymbols = ["W", "$", "$", "*", "^", "!", "*", "^", "!", "*", "^", "!", "*", "^"];
$gains = [
    5 => "^",
    10 => "*",
    30 => "!",
    70 => "$",
    100 => "W"
];
$slotMachine = [
    [" ", " ", " "," "],
    [" ", " ", " "," "],
    [" ", " ", " "," "],

];
$coefficients = [
    1 => 10,
    2 => 20,
    3 => 40,
    4 => 80
];


function displaySlots(array $slots)
{
    echo " {$slots[0][0]} | {$slots[0][1]} | {$slots[0][2]} | {$slots[0][3]} \n";
    echo "---+---+---+---\n";
    echo " {$slots[1][0]} | {$slots[1][1]} | {$slots[1][2]} | {$slots[1][3]} \n";
    echo "---+---+---+---\n";
    echo " {$slots[2][0]} | {$slots[2][1]} | {$slots[2][2]} | {$slots[2][3]} \n";
    echo "---------------\n";
}

$PullSlots = function () use (&$slotMachine, $slotSymbols) {
    for ($i = 0; $i < count($slotMachine); $i++) {
        for ($k = 0; $k < count($slotMachine[0]); $k++) {
            $slotMachine[$i][$k] = $slotSymbols[array_rand($slotSymbols)];
        }
    }
};

$moneyAmount = (int)readline("Sveicināti Fēniksā! Ievadiet Jūsu naudas daudzumu: ");

while (true) {
    $payout = 0;
    $rate = (int)readline("Ievadiet jūsu likmi (10, 20, 40, 80): ");

    if (!in_array($rate, $coefficients)) {
        echo "Nepareiza likme!\n";
        continue;
    }

    if ($moneyAmount < $rate) {
        echo "Jums nav pietiekami naudas!\n";
        exit;
    }

    $coefficient = array_search($rate, $coefficients);
    $moneyAmount = $moneyAmount - $rate;

    $PullSlots();
    displaySlots($slotMachine);

    for ($i = 0; $i < count($slotMachine); $i++)
    {
        if ($slotMachine[$i][0] === $slotMachine[$i][1]
            && $slotMachine[$i][1] === $slotMachine[$i][2]
            && $slotMachine[$i][2] === $slotMachine[$i][3])
        {
            $basePayout = array_search($slotMachine[$i][0], $gains);
            $payout = $payout + $basePayout * $coefficient;
        }
    }

    if ($slotMachine[0][0] === $slotMachine[1][1]
        && $slotMachine[1][1] === $slotMachine[2][2]
        && $slotMachine[2][2] === $slotMachine[2][3])
    {
        $basePayout = array_search($slotMachine[0][0], $gains);
        $payout = $payout + $basePayout * $coefficient;
    }

    if ($slotMachine[0][2] === $slotMachine[1][1]
        && $slotMachine[1][1] === $slotMachine[2][0]
        && $slotMachine[2][0] === $slotMachine[0][3])
    {
        $basePayout = array_search($slotMachine[0][2], $gains);
        $payout = $payout + $basePayout * $coefficient;
    }

    if ($slotMachine[0][3] === $slotMachine[1][2]
        && $slotMachine[1][2] === $slotMachine[2][1]
        && $slotMachine[2][1] === $slotMachine[2][0])
    {
        $basePayout = array_search($slotMachine[0][3], $gains);
        $payout = $payout + $basePayout * $coefficient;
    }

    if ($slotMachine[0][1] === $slotMachine[1][2]
        && $slotMachine[1][2] === $slotMachine[2][3]
        && $slotMachine[2][3] === $slotMachine[0][0])
    {
        $basePayout = array_search($slotMachine[0][0], $gains);
        $payout = $payout + $basePayout * $coefficient;
    }

    $moneyAmount = $moneyAmount + $payout;
    echo "Jūs ieguvāt $payout EUR un Jums tagad ir $moneyAmount EUR!\n";
    $playAgain = readline("Vēlaties griezt vēlreiz? (jā, nē) ");
    if ($playAgain !== "jā") {
        exit;
    }
}