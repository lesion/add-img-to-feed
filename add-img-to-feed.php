<?php
/*
Plugin Name: Add Image to Feed
Description: Add image media content and enclosure tags to RSS
Version:     1.4
Author:      lesion
License:  AGPL 3.0

Add Image to Feed is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free
Software Foundation, either version 3 of the license, or any later version.

Add Image to Feed is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with Add Image To Feed.
If not, see (https://www.gnu.org/licenses/agpl-3.0.html).
*/

defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

// add the namespace to the RSS opening element
add_action( 'rss2_ns', 'addimgtofeed_add_media_namespace');
function addimgtofeed_add_media_namespace() {
  echo "xmlns:media=\"http://search.yahoo.com/mrss/\"\n\t";
  echo "xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\"\n";
}


add_action( 'rss_item', 'addimgtofeed_custom_feed_meta', 5, 1 );
add_action( 'rss2_item', 'addimgtofeed_custom_feed_meta', 5, 1 );

function addimgtofeed_custom_feed_meta() {
  global $post;
  if (!has_post_thumbnail($post->ID)) { return; }

  $thumbnail_id = get_post_thumbnail_id( $post->ID );
  if(empty($thumbnail_id)) { return; }

  
  $image_full   = wp_get_attachment_image_src( $thumbnail_id, 'full');

  if ($image_full !== false) {
    printf(
        "<media:content url='%s' type='%s' width='%s' height='%s' medium='image' />\n\n\t\t",
          esc_attr($image_full[0]),
          get_post_mime_type( $thumbnail_id ),
          $image_full[2],
          $image_full[1]
    );

    printf(
      "<itunes:image href='%s' />\n\n",
        $image_full[0]
    );
  }
}
