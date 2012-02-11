<?php 

/**
 * RSS widget class
 *
 * @since 2.8.0
 */
class links_category_widget extends WP_Widget_RSS {

	function links_category_widget() {
	
		$widget_ops = array( 'description' => __('Displays links for this category') );
		$this->WP_Widget( 'links_category_widget', __('Links Per Category'), $widget_ops);
		
	}

	function widget($args, $instance) {
	
		global $post;

		if ( isset($instance['error']) && $instance['error'] )
			return;
						
		if(!is_home()){
		
			$words = array();
		
			$post_categories = wp_get_post_categories($post->ID);
			
			$data = get_the_category($post_categories);
								
			while($post_category = array_pop($data)){
				
				array_push($words,$post_category->name);
			
			}	
						
			$args = array(
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'number'                   => '100',
				'taxonomy'                 => 'link_category');
				
			$link_categories = get_categories($args);
			
			$count_links = $instance["number_links"];

			while($category = array_shift($link_categories)){
			
				if(in_array($category->name,$words)){
				
					$args = array(	
						'limit'          => $count_links,
						'category'       => $category->term_id	
						);
													
					$link_data = get_bookmarks( $args );
						
					while($link = array_shift($link_data)){
					
						echo "<li><a href='" . $link->link_url . "'>" . $link->link_name . "</a></li>";
						$count_links--;
					
					}
				
				}
			
			}
		
		}else{		
		
			$category = get_the_terms($instance["default_keyword"],"link_category");
			
			$args = array(	
						'limit'          => $instance["number_links"],
						'category'       => $instance["default_keyword"]	
						);
									
			$link_data = get_bookmarks( $args );
						
			while($link = array_shift($link_data)){
			
				echo "<li><a href='" . $link->link_url . "'>" . $link->link_name . "</a></li>";
			
			}
			
		}
				
	}

	function form($instance) {		
	
		echo '<div id="links_categories_widget-form">';		
		echo '<p><label for="' . $this->get_field_id("default_keyword") .'">Default Keyword (if one not found on post)</label></p>';
		
		
		$args = array(
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'number'				   =>  '100',
		'taxonomy'                 => 'link_category'
		);
				
		$link_categories = get_categories($args);
				
		echo '<select name="' . $this->get_field_name("default_keyword") . '">'; 
		
		while($category = array_shift($link_categories)){
						
			echo "<option ";
			
			if($instance['default_keyword']==$category->term_id){
			
				echo " selected ";
			
			}
			
			echo " value='" . $category->term_id . "'>" . $category->name . "</option>";
		
		}
		
		echo "</select>";
		
		echo '<p><label for="' . $this->get_field_id("number_links") .'">Number of links:</label>';
		echo '<input type="text" name="' . $this->get_field_name("number_links") . '" '; 
		echo 'id="' . $this->get_field_id("number_links") . '" value="' . $instance["number_links"] . '" /></p>';
		echo '</div>';
	}

	
	
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;		
		$instance['default_keyword'] = $new_instance['default_keyword'];
		$instance['number_links'] = $new_instance['number_links'];	
		return $instance;
	}
	
}

 ?>