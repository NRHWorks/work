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
  $title = $e->field_title['und'][0]['value'];
  
  preg_match('/To Do: #(\d\d\d\d)/',$title,$todoid);

  if (isset($todoid[1])) {
    $tdid = $todoid[1];
  }
?>
<div class="<?php print $classes; ?> clearfix <?php if (isset($tdid)) { print " todo-$tdid"; } ?> "<?php print $attributes; ?> 
     <?php if (isset($tdid)) : ?>
      onmouseover="jQuery('.todo-<?php print $tdid; ?>').parent().css('background-color','#FFC');" 
      onmouseout="jQuery('.todo-<?php print $tdid ?>').parent().css('background-color','transparent');"
    <?php endif; ?>>
  <div class="content"<?php print $content_attributes; ?>>
    <a class="comment-show-hide" href="#" onclick="jQuery(this).siblings('.field-name-field-comment-description').toggle(); return false;">Show/Hide</a>
    <?php
      print render($content);
    ?>
  </div>
</div>
