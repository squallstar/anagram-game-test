<?php

/**
 * 1. Bootstrap phase
 */

$here = dirname(__FILE__);

foreach (['AnagramGame', 'ViewHelper'] as $lib)
{
  require_once $here . '/libs/' . $lib . '.php';
}


/**
 * 2. Here we go!
 */

$game = new AnagramGame($here . '/fixtures/words.txt');

$currentWord = $game->getCurrentWord();

$viewData = [
  'word' => $currentWord,
  'check' => $game->getCheckForWord($currentWord),
  'results' => false
];

// Check whether the user is sending results
if (isset($_POST['inputWords']) && strlen($_POST['inputWords']))
{
  $playerInput = $_POST['inputWords'];
  $word = $_POST['randomWord'];
  $check = $_POST['check'];

  $viewData = array_merge($viewData, [
    'results' => $game->submitWord($playerInput, $word, $check)
  ]);
}

$viewData['leaderboard'] = $game->getLeaderboard();

echo ViewHelper::render('game', $viewData);