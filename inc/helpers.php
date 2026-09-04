<?php
/**
 * Theme helper functions.
 *
 * @package Get_Your_Answers_Daily
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get a formatted application deadline.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function gyad_get_deadline( $post_id = 0 ) {

	$post_id = $post_id ? absint( $post_id ) : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	return trim(
		(string) get_post_meta(
			$post_id,
			'application_deadline',
			true
		)
	);
}


/**
 * Convert a deadline string to a timestamp.
 *
 * @param string $deadline Deadline string.
 * @return int
 */
function gyad_get_deadline_timestamp( $deadline ) {

	if ( empty( $deadline ) ) {
		return 0;
	}

	$timestamp = strtotime( $deadline );

	return $timestamp ? (int) $timestamp : 0;
}


/**
 * Get human-readable time remaining until a deadline.
 *
 * @param string $deadline Deadline string.
 * @return string
 */
function gyad_get_deadline_remaining( $deadline ) {

	$timestamp = gyad_get_deadline_timestamp( $deadline );

	if ( ! $timestamp ) {
		return '';
	}

	$now = current_time( 'timestamp' );

	$seconds_left = $timestamp - $now;

	if ( $seconds_left < 0 ) {
		return 'Deadline passed';
	}

	$days_left = (int) ceil(
		$seconds_left / DAY_IN_SECONDS
	);

	if ( 1 === $days_left ) {
		return '1 day left';
	}

	if ( $days_left < 7 ) {
		return $days_left . ' days left';
	}

	$weeks_left = (int) floor(
		$days_left / 7
	);

	if ( 1 === $weeks_left ) {
		return '1 week left';
	}

	if ( $weeks_left < 5 ) {
		return $weeks_left . ' weeks left';
	}

	$months_left = (int) floor(
		$days_left / 30
	);

	if ( 1 === $months_left ) {
		return '1 month left';
	}

	return $months_left . ' months left';
}


/**
 * Get a formatted deadline date.
 *
 * @param string $deadline Deadline string.
 * @return string
 */
function gyad_format_deadline( $deadline ) {

	$timestamp = gyad_get_deadline_timestamp( $deadline );

	if ( ! $timestamp ) {
		return '';
	}

	return wp_date(
		get_option( 'date_format' ),
		$timestamp
	);
}


/**
 * Get a deadline month abbreviation.
 *
 * @param string $deadline Deadline string.
 * @return string
 */
function gyad_deadline_month( $deadline ) {

	$timestamp = gyad_get_deadline_timestamp( $deadline );

	if ( ! $timestamp ) {
		return '';
	}

	return strtoupper(
		wp_date( 'M', $timestamp )
	);
}


/**
 * Get a deadline day number.
 *
 * @param string $deadline Deadline string.
 * @return string
 */
function gyad_deadline_day( $deadline ) {

	$timestamp = gyad_get_deadline_timestamp( $deadline );

	if ( ! $timestamp ) {
		return '';
	}

	return wp_date(
		'd',
		$timestamp
	);
}


/**
 * Determine whether a deadline is still active.
 *
 * @param string $deadline Deadline string.
 * @return bool
 */
function gyad_deadline_is_active( $deadline ) {

	$timestamp = gyad_get_deadline_timestamp( $deadline );

	if ( ! $timestamp ) {
		return false;
	}

	return $timestamp >= current_time( 'timestamp' );
}