<?php

function solve_a($path) {
  if (!file_exists($path)) {
    echo "Missing input file: $path";
    exit;
  }

  $input = file_get_contents($path);

  if ($input === false || strlen($input) === 0) {
    echo "Invalid input file: $path";
    exit;
  }

  $value = 0;
  $lastPosition = 0;

  while (true) {
    $pos = strpos($input, "mul(", $lastPosition);

    if ($pos == false) {
      break;
    }

    $lastPosition = $pos + 4;

    $inside = substr($input, $pos + 4, strpos($input, ")", $pos) - $pos - 4);

    if (isNumericOrCommaOnly($inside) === false) {
      continue;
    }

    $parts = explode(",", $inside);

    if (count($parts) !== 2) {
      continue;
    }

    $numbers = array_map("intval", $parts);

    if (count($numbers) == 2) {
      $value += $numbers[0] * $numbers[1];
    }
  }

  echo "Part one: $value\n";
}

function isNumericOrCommaOnly($string) {
    for ($i = 0; $i < strlen($string); $i++) {
        $char = $string[$i];
        if (!is_numeric($char) && $char !== ',') {
            return false;
        }
    }
    return true;
}

solve_a("/app/03.txt");

?>
