<?php 
/*
 Plugin Name: Simple Youtube Widget
 Plugin URI:
 Description: Easy to use youtube plugin, no API needed, live channel broadcast
 Version: 1.0.0
 Author: Ujwol Bastakoti
 Author URI:
 License: GPLv2
 */


class simpleyoutube_plugin_with_widget extends WP_Widget{
    
    
    public function __construct() {
        parent::__construct(
            'simple_youtube_widget', // Base ID
            'Simple Youtube Widget', // Name
            array( 'description' => __( 'Easy to use youtube widget', 'text_domain' ), ) // Args
            );
    }//end of function construct
    
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Youtube', 'text_domain' );
        }
        ?>
    
   		 <p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		    </p>
		    
		    
		     <p>
				<label for="<?php echo $this->get_field_id( 'yotube_video_id' ); ?>"><?php _e( 'Video ID: For Playlist to play leave this field empty' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_video_id' ); ?>" name="<?php echo $this->get_field_name( 'youtube_video_id' ); ?>" type="text" value="<?php if(isset($instance['youtube_video_id'])){ echo esc_attr( $instance['youtube_video_id' ] ); } ?>" />
		    </p>
		    
		     <p>
				<label for="<?php echo $this->get_field_id( 'yotube_playlist_id' ); ?>"><?php _e( 'Playlist ID:  ' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_playlist_id' ); ?>" name="<?php echo $this->get_field_name( 'youtube_playlist_id' ); ?>" type="text" value="<?php if(isset($instance['youtube_playlist_id'])){ echo esc_attr( $instance['youtube_playlist_id' ] ); } ?>" />
		    </p>
		    <!--
		    <p>
				<label for="<?php echo $this->get_field_id( 'yotube_channel_id' ); ?>"><?php _e( 'Channel ID:' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_channel_id' ); ?>" name="<?php echo $this->get_field_name( 'youtube_channel_id' ); ?>" type="text" value="<?php if(isset($instance['youtube_channel_id'])){ echo esc_attr( $instance['youtube_channel_id' ] ); } ?>" />
		    </p>
		    -->
		    <p>
				<label for="<?php echo $this->get_field_id( 'yotube_player_dimension' ); ?>"><?php _e( 'Player Dimension: ' ); ?></label> 
				<br/>
				<span>Width:</span><input style="width:100px !important;" id="<?php echo $this->get_field_id( 'youtube_player_width' ); ?>" name="<?php echo $this->get_field_name( 'youtube_player_width' ); ?>" type="text" value="<?php if(isset($instance['youtube_player_width'])){ echo esc_attr( $instance['youtube_player_width' ] ); } ?>" />&nbsp;X&nbsp;
				<span>Height:</span><input style="width:100px !important;"  id="<?php echo $this->get_field_id( 'youtube_player_height' ); ?>" name="<?php echo $this->get_field_name( 'youtube_player_height' ); ?>" type="text" value="<?php if(isset($instance['youtube_player_height'])){ echo esc_attr( $instance['youtube_player_height' ] ); } ?>" />
		    </p>
		    
		   
   <?php
         }//end of function form
    
    
         /**
          * Sanitize widget form values as they are saved.
          *
          * @see WP_Widget::update()
          *
          * @param array $new_instance Values just sent to be saved.
          * @param array $old_instance Previously saved values from database.
          *
          * @return array Updated safe values to be saved.
          */
         public function update( $new_instance, $old_instance ) {
             $instance = array();
             $instance['title'] = strip_tags( $new_instance['title'] );
             //$instance['youtube_channel_id'] = strip_tags($new_instance['youtube_channel_id']);
             $instance['youtube_playlist_id'] = strip_tags($new_instance['youtube_playlist_id']);
             $instance['youtube_video_id'] = strip_tags($new_instance['youtube_video_id']);
             $instance['youtube_player_width'] = strip_tags($new_instance['youtube_player_width']);
             $instance['youtube_player_height'] = strip_tags($new_instance['youtube_player_height']);
             return $instance;
         }//end of function update
         
         
         /*
         //get the video feed from youtube
         public function youtube_channel_latest_video($youTubeChannelId){
             
             
             include_once( ABSPATH . WPINC . '/feed.php' );
             // Get a SimplePie feed object from the specified feed source and convert them to array.
             
               
                 
             $feed = fetch_feed('https://www.youtube.com/feeds/videos.xml?channel_id='.trim($youTubeChannelId));
           
             $maxitems =0;
             
             // Checks that the object is created correctly
             if ( ! is_wp_error( $feed ) ){
                 
                 // Figure out how many total items there are, but limit it to 5.
                 $maxitems = $feed->get_item_quantity(1);
                 
                 // Build an array of all the items, starting with element 0 (first element).
                 $rss_items = $feed->get_items( 0, 1 );
             }
             
             if($maxitems != 0){
                 
              
                 // Loop through each feed item and display each item as a hyperlink.
                 foreach ( $rss_items as $item ){
                     
                     $sanitizedFeed['permalink'] = $item ->get_permalink();
                    
                     
                 }
                 
                 $youtubeVideoLink = str_replace('?v=', '/',str_replace('watch', 'embed',$sanitizedFeed['permalink']));
                 
             }//end of if
             
             
          
             return $youtubeVideoLink;
             
             
             
         }//end of function
         
         */
    
   
         /**
          * Front-end display of widget.
          *
          * @see WP_Widget::widget()
          *
          * @param array $args     Widget arguments.
          * @param array $instance Saved values from database.
          */
         public function widget( $args, $instance ) {
             
             
             extract( $args );
             $title = apply_filters( 'widget_title', $instance['title'] );
             echo $before_widget;
             if ( ! empty( $title ) )
                 echo $before_title . $title . $after_title;
             
             
             extract( $args );
             $title = apply_filters( 'widget_title', $instance['title'] );
             
             if(!empty($instance['youtube_video_id'] )){
                
                 
                 $videoToDisplay = 'https://www.youtube.com/embed/'.$instance['youtube_video_id'];
                 
                 
                }
                else if(!empty($instance['youtube_playlist_id'])){
                    
                    $videoToDisplay = "https://www.youtube.com/embed/videoseries?list=".$instance['youtube_playlist_id'];
                  }
                  /*
                  else if(!empty($instance['youtube_channel_id'])) {
                      
                      $videoToDisplay =  $this->youtube_channel_latest_video($instance['youtube_channel_id']);
                  }
                  */
                  else{
                      
                      
                  }
             ?>
             
               <div  class="youtube_widget_area">
               
               
                
                <iframe width="<?php if(!empty($instance['youtube_player_width'])){echo($instance['youtube_player_width']);}else{echo"400";}?>" height="<?php if(!empty($instance['youtube_player_height'])){echo($instance['youtube_player_height']);}else{echo"315";}?>" src="<?php echo($videoToDisplay);?>" frameborder="0"  allow="autoplay"; encrypted-media" allowfullscreen></iframe>
               						  
               	  
               
               </div>
             
             
           <?php     
            
           
            
         }
}


/*function resgiter widget as plguin*/
function register_simpleyoutube_plugin_with_widget(){
    register_widget( "simpleyoutube_plugin_with_widget" );
}

add_action( 'widgets_init', 'register_simpleyoutube_plugin_with_widget' );	

?>