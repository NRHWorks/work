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
  $he = $e->hostEntity();

  $content['field_hours'][0]['#markup'] .= ' hours';
?>

<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <div class="content"<?php print $content_attributes; ?>>
    <div style="float:left; margin-right:20px; font-weight:bold;">
      <a href="#" 
         onclick="  jQuery('#time-wrapper').load('/tasks/update-time/delete/<?php print $he->nid; ?>/<?php print $e->item_id; ?>', function(){work_log.update_log(<?php print $he->nid;?>);});
                    setTimeout(function() { jQuery('#estimate-wrapper').load('/tasks/estimate/<?php print $he->nid; ?>') }, 1000);
                    return false;">X</a>
    </div>
    <?php
      print render($content);
    ?>
  </div>
</div>
