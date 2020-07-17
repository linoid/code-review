<?php

/**
 * Utility function to retrieve Course Material nodes by course code.
 *
 */
function mi_custom_course_has_files($code) {
  if (!empty($code)) {
    $code=preg_replace('/[^A-Za-z0-9-]+/', '', $code);
    $q = new EntityFieldQuery();
    $res = $q->entityCondition('entity_type', 'node')
      ->propertyCondition('type', 'course_materials')
      ->propertyCondition('status', NODE_PUBLISHED)
      ->fieldCondition('field_supplement_course_code', 'value', $code)
      ->execute();
  }
  
  $nodes = array();
  if (isset($res['node'])) {
    $nids = array_keys($res['node']);
    $nodes = node_load_multiple($nids);
  }

  foreach ($nodes as $node) {
    foreach ($node->field_supplement_files as $file) {
      $filename =  $file[0]['filename'];
      echo '<a class="button-watch" href="/sites/default/files/' . $filename . '" download>view course materials</a>';
    }
  }

}
