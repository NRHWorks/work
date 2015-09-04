<?php
global $t;
$t = $table;
$date = $t[0];
$day = date('w', strtotime($date));
$start_date = date('Y-m-d', strtotime('-' .$day. ' days', strtotime($date)));
$end_date = date('Y-m-d', strtotime('+ 6 days', strtotime($start_date)));
$begin = date('l, M j, Y', strtotime($start_date));
$end = date('l, M j, Y', strtotime('+6 days', strtotime($start_date)));
print theme('schedule_menu'); ?>

<form action="/schedule/week/" method="get">
    <div>
        <label for="name">Date:</label>
        <input type="text" id="date" name="date"/>
   </div>
   <div class="button" style="margin-top: 10px;">
       <input type="submit" value="Submit" />
   </div>
</form>
<div>
<h1>
  <div style = "float: left; width: 50px;">
    <a href="/schedule/week/<?php echo date('Y-m-d',strtotime('-7 days', strtotime($start_date)));?>" ><<</a>
  </div>
  <div style = "float: left; margin-left: 120px;"> 
    Week of: <?php echo "$begin - $end;" ?>
  </div>
  <div style = "float: right; width:50px">
    <a href="/schedule/week/<?php echo date('Y-m-d',strtotime(' + 1 days', strtotime($end_date)));?>" >>></a>
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