<h2>You played against this string: <?php echo $characters; ?></h2>
<p>You entered: <?php echo $playerInput; ?></p>

<?php if ($matchedWord) { ?>
  <p>You won with this match: <strong><?php echo $matchedWord; ?></strong></p>
<? } ?>

<h3>Score: <?php echo $score; ?></h3>

<hr />