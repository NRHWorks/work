<?php
  $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

  foreach ($days as $k => $d) { 
    $monday->modify('+ ' . $k . ' days');
    $dates[$monday->format('Y-m-d 00:00:00')] = $d;
  }

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
      <th>&nbsp;</th>
      <?php foreach ($dates as $d) : ?>
        <th><?php print $d; ?></th>
      <?php endforeach; ?>
    </tr>
    <?php foreach ($project_data as $client => $projects): $eo = 'even'; ?>
      <tr>
        <th colspan="8" style="text-align:center;"><?php print $client; ?></th>
      </tr>
      <?php foreach ($projects as $project => $ts) : ?>
        <?php $eo = ($eo == 'even') ? 'odd' : 'even'; ?>
        <tr class="<?php print $eo; ?>">
          <td style="font-weight:bold;"><?php print $project; ?></td>
          <?php foreach ($dates as $date => $d) : ?>
            <td>
              <?php
                foreach ($times as $time) {
                  if (isset($tasks[$date])) {
                    foreach ($tasks[$date][$time][$client][$project] as $t => $tu) {
                      print $tu . ': ' . $t . '<br>';
                    }
                  }
                }
              ?>
            </td>
          <?php endforeach; ?>
        <tr>
      <?php endforeach; ?>
    <?php endforeach; ?>  
  </tbody>
</table>

<?php //print '<pre>'; print_r($tasks); exit; ?>
