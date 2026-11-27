<?php
/**
 * Shared YouTube player for recorded videos and broadcasts.
 *
 * @package SAC
 */

$video_id = $args['video_id'];
$language = (string) apply_filters( 'wpml_current_language', '' );
if ( ! preg_match( '/^[a-z]{2}(?:-[a-z0-9]{2,8})?$/iD', $language ) ) {
	$language = str_replace( '_', '-', get_locale() );
}

$embed_url = add_query_arg(
	array( 'hl' => $language, 'cc_lang_pref' => $language, 'cc_load_policy' => '1' ),
	'https://www.youtube-nocookie.com/embed/' . $video_id
);
/* translators: %s: the video title. */
$player_title = sprintf( __( 'YouTube video: %s', 'sac' ), wp_strip_all_tags( $args['title'] ?? get_the_title() ) );
?>
<div class="sac-video-player">
	<iframe src="<?php echo esc_url( $embed_url ); ?>" title="<?php echo esc_attr( $player_title ); ?>" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" allow="encrypted-media; picture-in-picture; fullscreen" allowfullscreen></iframe>
</div>
<p class="mt-3"><a href="<?php echo esc_url( 'https://www.youtube.com/watch?v=' . $video_id ); ?>"><?php esc_html_e( 'Watch on YouTube', 'sac' ); ?></a></p>
