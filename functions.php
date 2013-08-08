<?php

/* Functions for FOL blog hub child theme */

// set default content width
if ( ! isset( $content_width ) ) $content_width = 640;


function get_link_count($catid) {
	//get link count for a given category id 
	
	$linkcat = get_term( $catid, 'link_category' );
	
	if ($linkcat) {
		return ( $linkcat->count );
	} else {
		return (-1);
	}
}

function get_post_count($catid) {
	// get the number of posts in a given category
	
	$postsInCat = get_term_by( 'id', $catid, 'category' ); 
	return ( $postsInCat->count );

}


function twentyeleven_posted_on() {
// mods to the metadata output
	
	if ( in_category( array( 1,13 ) ) ) {
	
		/*
		 syndicated post metadata - override the default we don't need author link, just
		 the date and time of the original post and a link to author archives. Used for default (1)
		 and the synidcated category (13)
		*/
	
		printf( __( '<span class="sep">Future of Learning syndicated item published on </span><strong><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></strong><br /><a class="url fn n" href="%3$s">see all syndicated posts from this source</a>', 'twentyeleven' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' at ' . get_the_time() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
		);
	
	
	} else {
		// use normal meta data for internal authored posts 
		printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twentyeleven' ), get_the_author() ),
		esc_html( get_the_author() )
		);

	}

}


/* modify recent post widget to truncate title length
   since twitter ones are way long
   http://wordpress.stackexchange.com/questions/24316/how-to-truncate-titles-in-recent-posts-widget
   ------------------------------------------------------- */

add_action( 'widgets_init', 'switch_recent_posts_widget' );

function switch_recent_posts_widget() {

    unregister_widget( 'WP_Widget_Recent_Posts' );
    register_widget( 'WP_Widget_Recent_Posts_Truncated' );

}


function limit_text($text, $limit) {
// from http://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php

      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
    
    

class WP_Widget_Recent_Posts_Truncated extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your site") );
        parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
        $this->alt_option_name = 'widget_recent_entries';

        add_action( 'save_post', array(&$this, 'flush_widget_cache') );
        add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
        add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( isset($cache[$args['widget_id']]) ) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
        if ( ! $number = absint( $instance['number'] ) )
            $number = 10;

        $r = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
        if ($r->have_posts()) :
?>
        <?php echo $before_widget; global $post ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul>
        <?php  while ($r->have_posts()) : $r->the_post(); ?>
        <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
            <?php 
            if( get_the_title() ) 
                echo limit_text( get_the_title(), 10);
            else 
                the_ID(); 
            ?>
        </a></li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
    }
}


?>