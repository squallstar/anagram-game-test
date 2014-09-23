<?php

class AnagramGame
{
  const LEADERBOARD_PATH = 'leaderboard.json';

  private $_currentWord;

  private $_wordsList;

  private $_fixturesPath;

  private $_leaderboard;

  public function __construct($fixturesPath)
  {
    $this->_fixturesPath = $fixturesPath;
    $this->_loadLeaderboard();
    $this->_generateRandomWord();
  }

  private function _loadLeaderboard()
  {
    if (file_exists(self::LEADERBOARD_PATH))
    {
      $this->_leaderboard = json_decode(file_get_contents(self::LEADERBOARD_PATH), true);
    }
    else
    {
      $this->_leaderboard = [];
    }
  }

  private function _pushResultOnLeaderboard($score, $word)
  {
    $this->_leaderboard[] = [
      'score' => $score,
      'words' => $word,
      'at' => time()
    ];

    usort($this->_leaderboard, function($a, $b){
      return ($a['score'] < $b['score']) ? 1 : -1;
    });

    $this->_leaderboard = array_slice($this->_leaderboard, 0, 10);

    $this->_saveLeaderboard();
  }

  private function _saveLeaderboard()
  {
    file_put_contents(self::LEADERBOARD_PATH, json_encode($this->_leaderboard));
  }

  public function getLeaderboard()
  {
    return $this->_leaderboard;
  }

  private function _ensureWordsListIsLoaded()
  {
    if (!$this->_wordsList)
    {
      $this->_wordsList = explode("\n", file_get_contents($this->_fixturesPath));
    }
  }

  private function _generateRandomWord()
  {
    $length = rand(16, 20);

    for ($str = '', $i = 0, $len = strlen($a = 'abcdefghijklmnopqrstuvwxyz')-1; $i != $length; $i++)
    {
      $charIdx = rand(0,$len);
      $str .= $a{$charIdx};
    }

    $this->_currentWord = $str;
    unset($str);
  }

  public function getCurrentWord()
  {
    return $this->_currentWord;
  }

  public function getCheckForWord($word)
  {
    return md5('averyrandomstring' . date('d') . $word);
  }

  public function submitWord($playerInput, $word, $check)
  {
    if ($check !== $this->getCheckForWord($word)) die('Cheating? Really?');

    $this->_ensureWordsListIsLoaded();

    $filteredInput = preg_replace('/[^' . $word . ']/', '', $playerInput);

    $input = '';

    $len = strlen($filteredInput);

    for ($i=0; $i < $len; $i++)
    {
      if (strpos($input, $filteredInput[$i]) === false) $input .= $filteredInput[$i];
    }

    unset($letter);

    $score = 0;
    $matchedWord = null;

    foreach ($this->_wordsList as &$listWord)
    {
      if (strpos($input, $listWord) !== false && $score < strlen($listWord))
      {
        $score = strlen($listWord);
        $matchedWord = $listWord;
      }
    }

    unset($listWord);

    if ($score > 0)
    {
      $this->_pushResultOnLeaderboard($score, $input);
    }

    return [
      'score' => $score,
      'matchedWord' => $listWord,
      'playerInput' => $input,
      'characters' => $word
    ];
  }
}