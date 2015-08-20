<?php
//print 'here'; exit;
foreach($table as $t) {
  //print '<pre>'; print_r($t); exit;
  header('Content-Type: text/plain');
  print $t;
}