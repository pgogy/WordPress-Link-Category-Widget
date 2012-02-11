<?php

/*
Plugin Name: links category widget
Description: Facilitates the display of links associated with this category
Version: 0.1
Author: pgogy
*/

function links_category_widget_display() {
	require_once('links_category_widget_class.php' );
	register_widget( 'links_category_widget' );
}
add_action( 'widgets_init', 'links_category_widget_display', 1 );


?>