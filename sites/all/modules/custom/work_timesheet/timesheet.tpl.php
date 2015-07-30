   <form action="/timesheet" method="get">
   <div>
       <label for="name">Start date:</label>
       <input type="text" id="start_date" name="start_date"/>
   </div>
   <div>
      <label for="name">End date:</label>
      <input type="text" id="end_date" name="end_date"/>
   </div>
   <div class="button">
       <input type="submit" value="Generate Report" />
   </div>
   </form>
<?php
   print $table; 