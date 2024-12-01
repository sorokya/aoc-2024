<?php

function solve($path) {
  if (!file_exists($path)) {
    echo "Missing input file: $path";
    exit;
  }

  $input = file_get_contents($path);

  if ($input === false || strlen($input) === 0) {
    echo "Invalid input file: $path";
    exit;
  }

  $left = [];
  $right = [];

  $lines = explode("\n", $input);

  foreach ($lines as $line) {
    if ($line === "") {
      continue; 
    }

    $parts = explode("   ", $line);
    if (count($parts) !== 2) {
      echo "Invalid line: $line";
      exit;
    }

    $left[] = (int)$parts[0];
    $right[] = (int)$parts[1];
  }

  $sum = 0;

  for ($i = 0; $i < count($left); $i++) {
    $val = $left[$i];
    $occurences = 0;

    for ($n = 0; $n < count($right); $n++) {
      if ($val == $right[$n]) {
        $occurences += 1;
      }
    }

    $sum += $val * $occurences;
  }

  echo "Answer: $sum\n";
}


solve("/app/01.txt");

?>
