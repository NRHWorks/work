<?php

while ($arg = drush_shift()) {

  $node = node_load($arg);

  $node->field_status['und'][0]['tid'] = 7;

  node_save($node);
}
