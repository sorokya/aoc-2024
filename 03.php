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

function solve_b($path) {
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

  $enabled = true;

  while (true) {
    $mulPos = strpos($input, "mul(", $lastPosition);
    $doPos = strpos($input, "do()", $lastPosition);
    $dontPos = strpos($input, "don't()", $lastPosition);

    $commands = [];

    if ($mulPos !== false) {
      $commands[] = ["mul", $mulPos];
    }

    if ($doPos !== false) {
      $commands[] = ["do", $doPos];
    }

    if ($dontPos !== false) {
      $commands[] = ["dont", $dontPos];
    }

    usort($commands, 'compare');

    $command = array_shift($commands);
    
    if ($command === null) {
      break;
    }

    if ($command[0] === "do") {
      $enabled = true;
      $lastPosition = $doPos + 4;
      continue;
    }

    if ($command[0] === "dont") {
      $enabled = false;
      $lastPosition = $dontPos + 7;
      continue;
    }

    $lastPosition = $mulPos + 4;

    $inside = substr($input, $mulPos + 4, strpos($input, ")", $mulPos) - $mulPos - 4);

    if (isNumericOrCommaOnly($inside) === false) {
      continue;
    }

    $parts = explode(",", $inside);

    if (count($parts) !== 2) {
      continue;
    }

    $numbers = array_map("intval", $parts);

    if ($enabled) {
      $value += $numbers[0] * $numbers[1];
    }
  }

  echo "Part two: $value\n";
}

function compare($a, $b) {
  if ($a[1] == $b[1]) {
    return 0;
  }

  return ($a[1] < $b[1]) ? -1 : 1;
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
solve_b("/app/03.txt");

?>
