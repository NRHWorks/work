<?php print theme('schedule_menu'); ?>

<form action="/schedule/week/" method="get">
    <div>
        <label for="name">Date:</label>
        <input type="text" id="date" name="date"/>
   </div>
   <div class="button" style="margin-top: 10px;">
      <input type="button" onclick="alert('/schedule/week/' + jQuery('#date').val()); window.location.href = '/schedule/week/' + jQuery('#date').val();" value="Submit" />
   </div>
</form>

<?php
print 'here'; exit;
foreach($table as $t) {
  header('Content-Type: text/plain');
  print $t;
}
