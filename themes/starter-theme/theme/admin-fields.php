<?php

add_action('admin_head', 'manipulate_post_fields');

function manipulate_post_fields () {
  $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);

  ?>
  <style>
    /*{
      display: none;
      }*/
  </style>
  <?php

  switch ($post_id) {
    case 1:
      ?><style>
        /* { display: block; } */
      </style><?php
      break;
  }
}
