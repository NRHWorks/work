   <form action="/timesheet" method="get">
    <div style="float:left">
      <div>
       <label for="name">Start date:</label>
       <input type="text" id="start_date" name="start_date"/>
   </div>
   <div>
      <label for="name">End date:</label>
      <input type="text" id="end_date" name="end_date"/>
   </div>
   <div class="button" style="margin-top: 10px;">
       <input type="submit" value="Generate Report" />
   </div>
 </div>
    <div style="float:left; margin: 20px 0px 0px 20px;">
      <input type="radio" name="group_by" value="any"> Any<br>
      <input type="radio" name="group_by" value="client"> Client<br>
      <input type="radio" name="group_by" value="developer"> Developer<br>
      <input type="radio" name="group_by" value="project"> Project
   </div>
   </form>
   <div style="clear:both;"></div>
<?php
foreach($table as $t) {
   header('Content-Type: text/plain');
   print $t; 
 }