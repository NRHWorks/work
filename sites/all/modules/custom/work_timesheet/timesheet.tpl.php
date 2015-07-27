   <form action="/timesheet" method="get">
   <div>
       <label for="name">Start date:</label>
       <input type="text" id="start_date" />
   </div>
   <div>
      <label for="name">End date:</label>
      <input type="text" id="end_date" />
   </div>
   <div class="button">
       <button type="submit">Generate Report</button>
   </div>
   </form>
<?php
   print $table; 