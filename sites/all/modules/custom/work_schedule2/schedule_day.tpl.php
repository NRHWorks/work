<?php print theme('schedule_menu'); ?>

<form action="/schedule/day" method="get">
    <div>
        <label for="name">Date:</label>
        <input type="text" id="date" name="date"/>
   </div>
   <div class="button" style="margin-top: 10px;">
       <input type="submit" value="Submit" />
   </div>
</form>

<?php
foreach($table as $t) {
  header('Content-Type: text/plain');
  print $t;
}