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
      print render($content);
    ?>
  </div>
  
  <?php

    $headers = array('Date', 'Task', 'Description', 'Hours');

    $data = array();
    $rows = array();

    $hours = 0;
    $fee = 0;

    foreach ($node->field_invoice_task['und'] as $t) {
      $task = node_load($t['nid']);

      $p = node_load($task->field_project['und'][0]['nid']);

      foreach ($task->field_time['und'] as $time) {
        $entity = entity_load('field_collection_item', array($time['value'])); 
        $e = array_pop($entity);

        if (isset($e->field_hours['und'][0]['value'])) {
          $data[] = array(
            'project' => $p->title,
            'date' => '<span style="white-space:nowrap">' . date('M d, Y', strtotime($e->field_date['und'][0]['value'])). "</span>",
            'task' => l($task->title, 'node/' . $task->nid),
            'description' => $e->field_description['und'][0]['value'],
            'hours' => $e->field_hours_billed['und'][0]['value'],
            'project_fee' => $p->field_bill_rate['und'][0]['value'],
          );
        }
      }
    }

    $data = work_theme_sort($data, 'date', 'date');
    $data = work_theme_sort($data, 'project');

    $project = '';

    $project_fee = 0;
    $project_hours = 0;

    foreach ($data as $d) {
      if ($project != $d['project']) {
        if (($project_fee > 0) && ($project_hours > 0)) {
            $rows[] = array(
                        array(
                          'data' => '<strong>Total: </strong> <div style="float:right; font-weight: bold;">' . $project_hours .' hours / $' . $project_fee  . '</div>',
                          'colspan' => 4,

                        ),
                      );

            $project_fee = 0;
            $project_hours = 0;
        }

        $project = $d['project'];
        $rows[] = array(array('data' => "<strong style='font-size:16px;'>$project</strong>", 'colspan' => 4));
      }

      $rows[] = array($d['date'], $d['task'], $d['description'], $d['hours']);
      
      $project_hours += $d['hours'];
      $project_fee += $d['hours'] * $d['project_fee'];

      $hours += $d['hours'];
      $fee += $d['hours'] * $d['project_fee'];
    }
            
    $rows[] = array(
                array(
                  'data' => '<strong>Total: </strong> <div style="float:right; font-weight: bold;">' . $project_hours .' hours / $' . $project_fee  . '</div>',
                  'colspan' => 4,

                ),
              );

    $rows[] = array(
                array(
                  'data' => '<span style="font-size:16px;"><strong>Grand Total: </strong> <div style="float:right; font-weight: bold;">' . $hours .' hours / $' . $fee  . '</div></span>',
                  'colspan' => 4, 

                ),
              );

    print theme('table', array('header'=> $headers, 'rows' => $rows));
  ?>



  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</div>
