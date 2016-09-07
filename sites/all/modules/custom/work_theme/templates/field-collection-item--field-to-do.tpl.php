<?php

/**
 * @file
 * Default theme implementation for field collection items.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>
<?php 
  $e = $variables['elements']['#entity'];
?>
<div class="todo-item todo-<?php print $e->item_id; ?>" onmouseover="jQuery('.todo-<?php print $e->item_id; ?>').parent().css('background-color','#FFC');" onmouseout="jQuery('.todo-<?php print $e->item_id; ?>').parent().css('background-color','transparent');">
  <div class="todo-check">
    <input type="checkbox" data-todo="<?php print $e->item_id; ?>" <?php if ($e->field_todo_status['und'][0]['value'] == 1) { print "checked='checked'"; } ?> /> <strong>#<?php print $e->item_id;?></strong>
  </div>
  <div class="todo-todo <?php if ($e->field_todo_status['und'][0]['value'] == 1) { print "todo-done"; } ?>">
    <?php print $e->field_description['und'][0]['value']; ?>
    <?php
      if ($e->field_todo_status['und'][0]['value'] == 1) {
        $todo_user = user_load($e->field_user['und'][0]['uid']);
        print " ({$todo_user->name})";
      }
    ?>
  </div>
</div>
