<?php
require('./vendor/autoload.php');

$stack = new App\Stack();
$stackBin = new App\Stack();
$stackOperators = new App\Stack();
$stackCalculator = new App\StackCalculator($stack, $stackBin, $stackOperators);

$handle = fopen ("php://stdin","r");
echo "Please enter your first instruction: \n";
while($line = fgets($handle)){
    // Enter QUIT/quit to terminate
    if(strtoupper(trim($line)) == 'QUIT'){
        exit("Bye!\n");
    }
    $stackCalculator->run($line);
    echo "\nPlease enter next instruction: \n";
}
