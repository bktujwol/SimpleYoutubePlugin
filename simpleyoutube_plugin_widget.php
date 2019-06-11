<?php 
/*
 Plugin Name: Simple Youtube Widget
 Plugin URI:
 Description: Easy to use youtube plugin, no API key needed, all you need is video or playlist id of boardcatable videos
 Version: 2.0.1
 Author: Ujwol Bastakoti
 Author URI:http://ujwolbastakoti.wordpress.com
 text-domain:simple-youtube-widget 
 License: GPLv2
 */


class simpleyoutube_plugin_with_widget extends WP_Widget{
    
    
    public function __construct() {
        parent::__construct(
            'simple_youtube_widget', // Base ID
            'Simple Youtube Widget', // Name
            array( 'description' => __( 'Easy to use youtube widget', 'simple-youtube-widget' ), ) // Args
            );
    }//end of function construct
    

 public function enqueue_youtube_scripts_style( ){
   wp_enqueue_style( 'dashicons' );
   wp_enqueue_script('simpleYoutubeJs', plugins_url('js/simple_youtube.js',__FILE__ ), array(),'',true );

 }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Youtube', 'simple-youtube-widget' );
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
				<label for="<?php echo $this->get_field_id( 'youtube_playlist_id' ); ?>"><?php _e( 'Playlist ID:  ' ); ?></label> 
				
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_playlist_id' ); ?>" name="<?php echo $this->get_field_name( 'youtube_playlist_id' ); ?>" type="text" value="<?php if(isset($instance['youtube_playlist_id'])){ echo esc_attr( $instance['youtube_playlist_id' ] ); } ?>" />
		    </p>
            <p>
				<label for="<?php echo $this->get_field_id( 'yotube_channel_id' ); ?>"><?php _e( 'Channel Id : ' ); ?><a target="_blank" href="<?=esc_url('https://www.youtube.com/account_advanced')?>" ><?=__("Get it here")?> </a> </label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'youtube_channel_id' ); ?>" name="<?php echo $this->get_field_name( 'youtube_channel_id' ); ?>" type="text" value="<?php if(isset($instance['youtube_channel_id'])){ echo esc_attr( $instance['youtube_channel_id' ] ); } ?>" />
		    </p>

		    <p>
				<label for="<?php echo $this->get_field_id( 'yotube_player_dimension' ); ?>"><?php _e( 'Player Dimension: ' ); ?></label> 
				<br/>
				<span>Width:</span><input style="width:100px !important;" id="<?php echo $this->get_field_id( 'youtube_player_width' ); ?>" name="<?php echo $this->get_field_name( 'youtube_player_width' ); ?>" type="text" value="<?php if(isset($instance['youtube_player_width'])){ echo esc_attr( $instance['youtube_player_width' ] ); } ?>" />&nbsp;X&nbsp;
				<span>Height:</span><input style="width:100px !important;"  id="<?php echo $this->get_field_id( 'youtube_player_height' ); ?>" name="<?php echo $this->get_field_name( 'youtube_player_height' ); ?>" type="text" value="<?php if(isset($instance['youtube_player_height'])){ echo esc_attr( $instance['youtube_player_height' ] ); } ?>" />
		    </p>

            <ul>
                <li> Video display priority : </li>
				<li>
                       
                        <ol>
                          <li> Single video with Video Id entered. </li>
                          <li> Playlist with Playlis Id entered. </li>
                          <li> Videos of Channel Id entered</li>
                        </ol>
                </li>
				</ul>
		    
		   
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
             $instance['youtube_channel_id'] = strip_tags($new_instance['youtube_channel_id']);
             $instance['youtube_playlist_id'] = strip_tags($new_instance['youtube_playlist_id']);
             $instance['youtube_video_id'] = strip_tags($new_instance['youtube_video_id']);
             $instance['youtube_player_width'] = strip_tags($new_instance['youtube_player_width']);
             $instance['youtube_player_height'] = strip_tags($new_instance['youtube_player_height']);
             return $instance;
         }//end of function update
         
         
         //get the video feed from youtube
         public function youtube_channel_latest_video($youTubeChannelId){
             
            $url = 'https://www.youtube.com/feeds/videos.xml?channel_id='.trim($youTubeChannelId);
            $xml= json_decode(json_encode(simplexml_load_file($url), JSON_FORCE_OBJECT), TRUE) ;
            foreach ($xml['entry'] as $item ):

                $items [array_pop (explode(':',$item['id']))] = $item['title'];
            endforeach;
             return  $items;             
             
             
         }//end of function
         
   
         /**
          * Front-end display of widget.
          *
          * @see WP_Widget::widget()
          *
          * @param array $args     Widget arguments.
          * @param array $instance Saved values from database.
          */
         public function widget( $args, $instance ) {
            $this->enqueue_youtube_scripts_style();
             extract( $args );
             $title = apply_filters( 'widget_title', $instance['title'] );
             echo $before_widget;
             if ( ! empty( $title ) )
                 echo $before_title . $title . $after_title;
            
             extract( $args );
             $title = apply_filters( 'widget_title', $instance['title'] );
             $width =  !empty($instance['youtube_player_width'])? esc_attr($instance['youtube_player_width']) :"400";
             $height = !empty($instance['youtube_player_height'])? esc_attr($instance['youtube_player_height']) : "315";
             if(!empty($instance['youtube_video_id'] )):
                 $videoToDisplay = 'https://www.youtube.com/embed/'.$instance['youtube_video_id'];  
                 ?>
                <div  width="<?=$width?>" height="<?=$height?>"  id="youtube_widget_area"  >
                   <iframe  frameborder="0"  allow="autoplay"; src="<?=$videoToDisplay?>" encrypted-media allowfullscreen></iframe>
               </div>
                 <?php               
                elseif(!empty($instance['youtube_playlist_id'])):
                    $videoToDisplay = "https://www.youtube.com/embed/videoseries?list=".$instance['youtube_playlist_id'];
                    ?>
                    <div  width="<?=$width?>" height="<?=$height?>"  id="youtube_widget_area" >
                       <iframe  width="<?=$width?>" height="<?=$height?>" src="<?=$videoToDisplay?>" frameborder="0"  allow="autoplay"; encrypted-media allowfullscreen></iframe>
                   </div>
                     <?php   
                  elseif(!empty($instance['youtube_channel_id'])) :
                      $videoList =  $this->youtube_channel_latest_video($instance['youtube_channel_id']);
                      $nextDisplay = 'display:none;';
                      $dataType = ' '; 
                      $i= 1;
                      foreach( $videoList as $key => $title ):
                        if($i === 1) :
                          $firstVid = $key;
                          $firstVidTitle = $title; 
                         elseif ($i=== 2) :
                            $nextDisplay = 'display:inline-block;';  
                        endif;   
                        $dataType .= "data-video-{$i}='{$key}:syt:{$title}' "; 
                        $i++;
                      endforeach;  

                      ?>
                      <div  width="<?=$width?>" height="<?=$height?>" style="height:<?=$height?>px; width:<?=$width?>px;"  id="youtube_widget_area" <?=$dataType?> >
                      <h5 id="syt-title-header" style="text-align:center;width:100%; height:30px; padding:5px; overflow:hidden;"><?=$firstVidTitle?></h5>
                         <iframe width="<?=$width?>" height="<?=$height?>" src="https://www.youtube.com/embed/<?=$firstVid?>" frameborder="0"  allow="autoplay"; encrypted-media" allowfullscreen></iframe>
                        <div id="syt-button-div" style="display:block;">
                            <a id="syt_prev_vid" title="Previous" style="float:left; display:none;margin-left:0px;text-decoration:none;" data-vid-num = "0" href="javaScript:void(0)" class="dashicons-before dashicons-controls-skipback" > </a>
                            <a id="syt_next_vid" title="Next" data-vid-num = "2" style="float:right;<?=$nex?>;margin-right:0px;text-decoration:none;" href="javaScript:void(0)" class="dashicons-before dashicons-controls-skipforward"></a>
                        </div>
                     </div>

                     </section>
                       <?php   
                 endif; 
         }
}


/*function resgiter widget as plguin*/
function register_simpleyoutube_plugin_with_widget(){
    register_widget( "simpleyoutube_plugin_with_widget" );
}

add_action( 'widgets_init', 'register_simpleyoutube_plugin_with_widget' );

?>