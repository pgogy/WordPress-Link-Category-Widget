<?php

/*
	Plugin Name: links category widget
	Description: Facilitates the display of links associated with this category
	Version: 0.3
	Author: pgogy
	Plugin URI: http://www.pgogy.com/code/groups/wordpress/links-category-widget/
	Author URI: http://www.pgogy.com
*/

function links_category_widget_display() {
	require_once('links_category_widget_class.php' );
	register_widget( 'links_category_widget' );
}
add_action( 'widgets_init', 'links_category_widget_display', 1 );


?>