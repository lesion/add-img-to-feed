<?php
/*
Plugin Name: Add Image to Feed
Description: Add image media content and enclosure tags to RSS
Version:     1.0
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


add_action( 'rss_item', 'addimgtofeed_custom_feed_meta', 5, 1 );
add_action( 'rss2_item', 'addimgtofeed_custom_feed_meta', 5, 1 );
function addimgtofeed_custom_feed_meta() {
	global $post;
	if(!has_post_thumbnail($post->ID)) return;
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	if(empty($thumbnail_id)) return;

	$image_full = wp_get_attachment_image_src( $thumbnail_id, 'full' );
	$image_medium = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
	$image_thumb = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );

	if ($image_full !== false) {
		echo '<enclosure url="' . esc_attr($image_full[0]) . '" length="' . esc_attr($image_full[4]) . '" type="image/jpg" />' . "\n";
		echo '<media:content url="' . esc_attr($image_medium[0]) . '" width="' . esc_attr($image_medium[1]) . '" height="' . esc_attr($image_medium[2]) . '" medium="image" type="image/jpg" />' . "\n";
		echo '<media:thumbnail url="'. esc_attr($image_thumb[0]) . '" width="' . esc_attr($image_thumb[1]) . '" height="' . esc_attr($image_thumb[2]) . '" medium="image" type="image/jpg" />' . "\n";
	}
}



