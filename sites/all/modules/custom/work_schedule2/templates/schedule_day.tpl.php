<?php
global $t;
$t = $table;
$date = $t[0];
?>

<?php print theme('schedule_menu'); ?>

<div "clear:both; margin-top: 30px;">
<h1>
  <div style = "float: left; width: 50px;">
    <a href="/schedule/day/<?php echo date('Y-m-d',strtotime('-1 days', strtotime($date)));?>" ><<</a>
  </div>
  <div style = "float: left; margin-left: 300px;"> 
    <?php echo date('l, M j, Y', strtotime($date)); ?>
  </div>
  <div style = "float: right; width:50px;">
    <a href="/schedule/day/<?php echo date('Y-m-d',strtotime('+1 days', strtotime($date)));?>" >>></a>
  </div>
</h1>
<br style="clear: left;" />
</div>

<?php
global $t;
$data = $t[1];
foreach($data as $d) {
  header('Content-Type: text/plain');
  print $d;
}
