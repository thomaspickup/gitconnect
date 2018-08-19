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
        $username = $instance['username'];
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        
        // If a username isn't already set use the default of mine
        if ( ! empty( $title ) ) 
        $username = "thomaspickup";

        echo "<br>" . $username;
        echo $args['after_widget'];
    }
         
    // Pulls the repository data linked to the user
    public function connect($username) {
            
    }
    
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'gitconnect_domain' );
        }
        
        if ( isset( $instance[ 'username' ] ) ) {
            $username = $instance[ 'username' ];
        }
        else {
            $username = __( 'thomaspickup', 'gitconnect_domain' );
        }
        
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            <label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
        </p>
        <?php 
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
        return $instance;
    }
}