<h1>Create words using these letters: <strong><?php echo $word; ?></strong></h1>

<form method="POST">
  <input type="hidden" name="randomWord" value="<?php echo $word; ?>"/>
  <input type="hidden" name="check" value="<?php echo $check; ?>"/>
  <input type="text" name="inputWords" placeholder="enter words here"/>
  <input type="submit" />
</form>

<hr />

<?php if ($results) echo ViewHelper::renderPartial('results', $results); ?>

<?php echo ViewHelper::renderPartial('leaderboard', ['leaderboard' => $leaderboard]); ?>