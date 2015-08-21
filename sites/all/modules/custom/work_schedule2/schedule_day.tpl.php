<form action="/schedule/day" method="get">
    <div style="float:left">
      <div>
       <label for="name">Date:</label>
       <input type="text" id="date" name="date"/>
   	   </div>
   <div>

<?php
//print 'here'; exit;
foreach($table as $t) {
  //print '<pre>'; print_r($t); exit;
  header('Content-Type: text/plain');
  print $t;
}