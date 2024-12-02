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

  $lines = explode("\n", $input);

  $safe = 0;

  foreach ($lines as $line) {
    if ($line === "") {
      continue; 
    }

    $levels = array_map(fn($l): int => (int)$l, explode(" ", $line));
    $asc = $levels;
    $desc = $levels;

    sort($asc);
    rsort($desc);

    if ($levels != $asc && $levels != $desc) {
      continue;
    }

    $valid = true;
    for ($i = 0; $i < count($levels); $i++) {
      $prev = $i > 0 ? $levels[$i - 1] : null;
      $next = $i < count($levels) - 1 ? $levels[$i + 1] : null;
      $curr = $levels[$i];

      if ($prev == null || $next == null) {
        continue;
      }

      if (abs($curr - $prev) < 1 || abs($curr - $prev) > 3) {
        $valid = false;
        break;
      }

      if (abs($curr - $next) < 1 || abs($curr - $next) > 3) {
        $valid = false;
        break;
      }
    }

    if ($valid) {
      $safe += 1;
    }
  }

  echo "Safe: $safe\n";
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

  echo "Answer 2: $sum\n";
}

solve_a("/app/02.txt");
// solve_b("/app/01.txt");

?>
