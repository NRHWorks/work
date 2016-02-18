<?php
global $t;
$t = $table;
$date = $t[0];
$day = date('w', strtotime($date));
$start_date = date('Y-m-d', strtotime('-' .$day. ' days', strtotime($date)));
$end_date = date('Y-m-d', strtotime('+ 6 days', strtotime($start_date)));
$begin = date('l, M j, Y', strtotime($start_date));
$end = date('l, M j, Y', strtotime('+6 days', strtotime($start_date))); ?>

<form action="/schedule/week/" method="get" style="float:right;" width: "300px;">
    <div style="float:left; margin-right: 10px;">
        <label for="name">Date:</label>
        <input type="text" id="date" name="date"/>
   </div>
   <div class="button" style="margin-top: 20px; float:left;">
       <input type="submit" value="Submit" />
   </div>
</form>

<?php print theme('schedule_menu'); ?>

<script type='text/javascript'>
(function ($) {
  $(document).ready( function(){
    assigned_to_me.toggle();
 });
}(jQuery));

var assigned_to_me = (function ($) {
  return {
    toggle: function(){
      if ($("input[name='assigned_to_me']").attr('checked')) {
        $("li.not-assigned-to-me").hide();
      }
      else {
        $("li.not-assigned-to-me").show();
      }
    }
  }
}(jQuery));

</script>
<input name='assigned_to_me' type='checkbox' onchange='assigned_to_me.toggle();'>Only show tasks that are assigned to me </input>
<div style ="clear:both; margin-top: 10px;">
<h1>
  <div style = "float: left; width: 50px;">
    <a href="/schedule/week/<?php echo date('Y-m-d',strtotime('-7 days', strtotime($start_date)));?>" ><<</a>
  </div>
  <div style = "float: left; margin-left: 120px;"> 
    Week of: <?php echo "$begin - $end" ?>
  </div>
  <div style = "float: right; width:50px;">
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