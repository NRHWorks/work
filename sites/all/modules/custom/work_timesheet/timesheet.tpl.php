   <form action="/timesheet" method="get">
   <div>
       <label for="name">Start date:</label>
       <input type="text" id="start_date" name="start_date"/>
   </div>
   <div>
      <label for="name">End date:</label>
      <input type="text" id="end_date" name="end_date"/>
   </div>
   <div>
      <input type="radio" name="group_by" value="any">Any<br>
      <input type="radio" name="group_by" value="client">Client<br>
      <input type="radio" name="group_by" value="developer">Developer<br>
      <input type="radio" name="group_by" value="project">Project
   </div>
   <div class="button">
       <input type="submit" value="Generate Report" />
   </div>
   </form>
<?php
foreach($table as $t) {
   header('Content-Type: text/plain');
   print $t; 
 }