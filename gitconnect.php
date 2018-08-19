<?php
/**
 * @package gitconnect
 * @version 0.1
 */
/*
Plugin Name: gitconnect
Plugin URI: https://github.com/thomaspickup/gitconnect
Description: GitConnect links a WordPress site with GitHub. When activated this plugin will embed your most recent GitHub repositories on a WordPress page as well as the Language, Description, Last Updated time, and of course a link to that repository.
Author: Thomas Pickup
Version: 0.1
Author URI: https://thomaspickup.co.uk
Text Domain: gitconnect
*/

// Register and load the widget
function gitconnect_load() {
    register_widget( 'gitconnect_widget' );
}

add_action( 'widgets_init', 'gitconnect_load' );
 
// Creating the widget 
class gitconnect_widget extends WP_Widget {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'gitconnect', 

        // Widget name will appear in UI
        __('gitconnect', 'gitconnect_domain'), 

        // Widget description
        array( 'description' => __( 'A link between GitHub and WordPress.', 'gitconnect_domain' ), ) 
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        echo __( 'Hello, World!', 'gitconnect_domain' );
        echo $args['after_widget'];
    }
         
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
        }
        else {
        $title = __( 'New title', 'gitconnect_domain' );
        }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}