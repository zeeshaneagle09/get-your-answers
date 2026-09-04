<?php
/**
 * Education article status intelligence.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function gyad_get_article_status_data( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$post_type = get_post_type( $post_id );
	$deadline_types = array( 'admission', 'job', 'scholarship' );
	$date = function_exists( 'gyad_get_single_primary_date' ) ? gyad_get_single_primary_date( $post_id ) : '';
	if ( ! $date || ! in_array( $post_type, $deadline_types, true ) ) { return array(); }
	$timestamp = strtotime( $date );
	if ( ! $timestamp ) { return array(); }
	$days = (int) floor( ( $timestamp - current_time( 'timestamp' ) ) / DAY_IN_SECONDS );
	if ( $days < 0 ) { return array( 'state' => 'closed', 'label' => 'Deadline passed', 'detail' => 'The listed application deadline has passed.' ); }
	if ( $days <= 3 ) { return array( 'state' => 'urgent', 'label' => 0 === $days ? 'Deadline today' : sprintf( 'Deadline in %d day%s', $days, 1 === $days ? '' : 's' ), 'detail' => 'Check the official notice before submitting.' ); }
	return array( 'state' => 'open', 'label' => sprintf( '%d days remaining', $days ), 'detail' => 'The listed deadline is still ahead.' );
}

function gyad_render_article_status_strip( $post_id = 0 ) {
	$data = gyad_get_article_status_data( $post_id );
	if ( empty( $data ) ) { return; }
	?>
	<div class="article-status-strip article-status-strip--<?php echo esc_attr( $data['state'] ); ?>" role="status">
		<span class="article-status-strip__dot" aria-hidden="true"></span>
		<strong><?php echo esc_html( $data['label'] ); ?></strong>
		<span><?php echo esc_html( $data['detail'] ); ?></span>
	</div>
	<?php
}
