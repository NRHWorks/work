<?php
  $project_data = array();
  foreach ($tasks as $date => $times) {
    foreach ($times as $time => $clients) {
      foreach ($clients as $client => $projects) {
        foreach ($projects as $project => $ts) {
          foreach ($ts as $t => $tu) {
            $project_data[$client][$project][] = $t;
          }
        }
      }
    }
  }

  $times = array('AM', 'PM', 'PM+');
?>

<?php print theme('schedule_menu'); ?>

<table>
  <tbody>
    <tr>
      <th width="10%">&nbsp;</th>
      <?php foreach ($times as $t) : ?>
        <th style="text-align:center;" width="30%"><?php print str_replace('PM+', 'Evening', $t); ?></th>
      <?php endforeach; ?>
    </tr>
    <?php foreach ($project_data as $c => $p): $eo = 'even'; ?>
      <tr>
        <th colspan="4" style="text-align:center;"><?php print $c; ?></th>
      </tr>
      <?php foreach ($p as $project => $tsks) : ?>
        <tr>
          <td><?php print $project; ?></td>
          <?php foreach ($times as $t) : ?>
            <td>
              <?php
                foreach ($tasks[date('Y-m-d 00:00:00')][$t][$c][$project] as $t => $tu) {
                  print "$tu: $t<br />";
                }
              ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>

    <?php endforeach; ?>  
  </tbody>
</table>