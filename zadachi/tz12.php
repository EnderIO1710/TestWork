<?php

//Задача 1

$vars=[
  [399, 9160, 144, 3230, 407, 8875, 1597, 9835], 
  [2093, 3279, 21, 9038, 918, 9238, 2592, 7467],
  [3531, 1597, 3225, 153, 9970, 2937, 8, 807],
  [7010, 662, 6005, 4181, 3, 4606, 5, 3980],
  [6367, 2098, 89, 13, 337, 9196, 9950, 5424],
  [7204, 9393, 7149, 8, 89, 6765, 8579, 55],
  [1597, 4360, 8625, 34, 4409, 8034, 2584, 2],
  [920, 3172, 2400, 2326, 3413, 4756, 6453, 8], 
  [4914, 21, 4923, 4012, 7960, 2254, 4448, 1]
];

$fibo = array();

$fibo[1] = 1;
$fibo[2] = 1;
$summ=0;

for ($i = 3; $i < 99; $i++) {
  $fibo[$i] = bcadd($fibo[$i-1], $fibo[$i-2]);
}



$y = [];
foreach($vars as $var){
  $x = array_intersect($var, $fibo);
  $y = array_merge($y, $x);
}

$y = array_sum($y);

var_dump($y);

// Задание 2

function isSequence3($num) {
  if ($num < 123) return false;
  
  $digits = str_split($num);
  $seq = 1;

  for($i=1; $i<count($digits); $i++) {
    if ($digits[$i] == ($digits[$i - 1] + 1)) $seq++;
    else $seq = 1;
  }
  
  return $seq > 2;
}

$sum1 = 0;
$sum2 = 0;
for ($n=1; $n<=10000; $n++) {
  if (isSequence3($n)) $sum1 += $n;

  $sum2 += $n;
}
$result = $sum2 - $sum1;
var_dump($result);
