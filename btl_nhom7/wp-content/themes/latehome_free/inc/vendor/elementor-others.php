<?php
add_filter( 'elementor/controls/animations/additional_animations',  'latehome_free_add_animations_scroll' );
function latehome_free_add_animations_scroll( $animations ) {
      $animations['Theme Animation'] = [
          'opal-move-up'    => 'Move Up',
          'opal-move-down'  => 'Move Down',
          'opal-move-left'  => 'Move Left',
          'opal-move-right' => 'Move Right',
          'opal-flip'       => 'Flip',
          'opal-helix'      => 'Helix',
          'opal-scale-up'   => 'Scale',
          'opal-am-popup'   => 'Popup',
      ];
      return $animations;
} 
add_filter( 'opalelementor_render_header_container_class', function(){
    return 'container-full';
} );
