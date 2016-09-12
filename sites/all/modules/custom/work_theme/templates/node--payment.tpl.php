<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted): ?>
    <div class="submitted">
      <?php print $submitted; ?>
    </div>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      hide($content['field_payment_time']);
      print render($content['field_date']) . '<br />';
      print render($content['field_developer']) . '<br />';
    ?>
  </div>
  
  <?php

    $user = user_load($node->field_developer['und'][0]['uid']);

    $rate = $user->field_rate['und'][0]['value'];

    $headers = array('Date', 'Task', 'Description', 'Hours');

    $data = array();
    $rows = array();

    $hours = 0;

    foreach ($node->field_payment_time['und'] as $t) {
      $he = $t['entity']->hostEntity();

      $p = node_load($he->field_project['und'][0]['nid']);

      $data[] = array(
        'project' => $p->title,
        'date' => '<span style="white-space:nowrap">' . date('M d, Y', strtotime($t['entity']->field_date['und'][0]['value'])). "</span>",
        'task' => l($he->title, 'node/' . $he->nid),
        'description' => $t['entity']->field_description['und'][0]['value'],
        'hours' => $t['entity']->field_hours['und'][0]['value'],
      );

      $hours += $t['entity']->field_hours['und'][0]['value'];
    }
     
    work_theme_aasort($data, 'date'); 
    work_theme_aasort($data, 'project'); 

    $project = '';

    foreach ($data as $d) {
      if ($project != $d['project']) {
        $project = $d['project'];
        $rows[] = array(array('data' => "<strong>$project</strong>", 'colspan' => 4));
      }
      $rows[] = array($d['date'], $d['task'], $d['description'], $d['hours']);
    }

    $rows[] = array(
                array(
                  'data' => '<strong>Total: </strong> <div style="float:right; font-weight: bold;">' . $hours .' hours / $' . ($hours * $rate)  . '</div>',
                  'colspan' => 4,

                ),
              );

    print theme('table', array('header'=> $headers, 'rows' => $rows));
  ?>



  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
