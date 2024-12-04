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

  $map = [[]];
  $count = 0;

  for ($y = 0; $y < count($lines); $y++) {
    $line = $lines[$y];
    for ($x = 0; $x < strlen($line); $x++) {
      $map[$y][$x] = $line[$x];
    }
  }

  for($y = 0; $y < count($map); $y++) {
    for($x = 0; $x < count($map[$y]); $x++) {
      $words = [
        find_horizontal($map, $x, $y, false),
        find_horizontal($map, $x, $y, true),
        find_vertical($map, $x, $y, false),
        find_vertical($map, $x, $y, true),
        find_diagonal($map, $x, $y, "top-left"),
        find_diagonal($map, $x, $y, "top-right"),
        find_diagonal($map, $x, $y, "bottom-left"),
        find_diagonal($map, $x, $y, "bottom-right"),
      ];

      var_dump($words);

      foreach ($words as $word) {
        if ($word === "XMAS") {
          $count += 1;
        }
      }
    }
  }

  echo "a: $count\n";
}

function find_horizontal($map, $x, $y, $reverse) {
  $coords = range($x, $x + ($reverse) ? -4 : 4);
  if (array_any($coords, function($c) use($map, $y) {
    return $c < 0 || $c >= count($map[$y]);
  })) {
    return false;
  }

  $letters = [];
  foreach ($coords as $c) {
    $letters[] = $map[$y][$c];
  }

  return implode("", $letters);
}

function find_vertical($map, $x, $y, $reverse) {
  $coords = range($y, $y + ($reverse) ? -4 : 4);
  if (array_any($coords, function($c) use($map) {
    return $c < 0 || $c >= count($map);
  })) {
    return false;
  }

  $letters = [];
  foreach ($coords as $c) {
    $letters[] = $map[$c][$x];
  }

  return implode("", $letters);
}

function find_diagonal($map, $x, $y, $direction) {
  $dx = 0;
  $dy = 0;

  if ($direction === "top-left") {
    $dx = -1;
    $dy = -1;
  }

  if ($direction ===  "top-right") {
    $dx = 1;
    $dy = -1;
  }

  if ($direction === "bottom-left") {
    $dx = -1;
    $dy = 1;
  }

  if ($direction === "bottom-right") {
    $dx = 1;
    $dy = 1;
  }

  $letters = [];
  for ($i = 0; $i < 4; $i++) {
    $new_x = $x + $i * $dx;
    $new_y = $y + $i * $dy;

    if ($new_x < 0 || $new_x >= count($map[0]) || $new_y < 0 || $new_y >= count($map)) {
        return false;
    }

    $letters[] = $map[$new_y][$new_x];
  }

  return implode("", $letters);
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
}

solve_a("/app/04.txt");
solve_b("/app/04.txt");

?>
