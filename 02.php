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
    if (is_safe($line)) {
      $safe += 1;
    }
  }

  echo "Answer 1: $safe\n";
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

  $lines = explode("\n", $input);

  $safe = 0;

  foreach ($lines as $line) {
    $levels = explode(" ", $line);
    for ($i = 0; $i <= count($levels); $i++) {
      $levelsCopy = $levels;
      if ($i > 0) {
        array_splice($levelsCopy, $i - 1, 1);
      }

      $levels_str = implode(" ", $levelsCopy);
      if (is_safe($levels_str)) {
        $safe += 1;
        break;
      }
    }
  }

  echo "Answer 2: $safe\n";
}

function is_safe($line) {
    if ($line === "") {
      return false; 
    }

    $levels = array_map(fn($l): int => (int)$l, explode(" ", $line));
    $asc = $levels;
    $desc = $levels;

    sort($asc);
    rsort($desc);

    if ($levels != $asc && $levels != $desc) {
      return false;
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

    return $valid;
}

solve_a("/app/02.txt");
solve_b("/app/02.txt");

?>
