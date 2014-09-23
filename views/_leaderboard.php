<h2>Leaderboard</h2>

<?php if (count($leaderboard)) { ?>
  <table border=1 width=400>
    <thead>
      <th>Score</th>
      <th>Words</th>
      <th>Posted at</th>
    </thead>
    <tbody>
    <?php foreach ($leaderboard as $result) { ?>
      <tr>
        <td align="center"><?php echo $result['score']; ?></td>
        <td align="center"><?php echo $result['words']; ?></td>
        <td align="center"><?php echo date('d/m/Y H:i', $result['at']); ?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php } else { ?>
  <p>No results yet</p>
<?php } ?>