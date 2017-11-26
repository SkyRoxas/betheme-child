<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @version 4.6.3
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// The address string via tribe_get_venue_details will often be populated even when there's
// no address, so let's get the address string on its own for a couple of checks below.
$venue_address = tribe_get_address();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Venue Name
$venue_name= tribe_get_venue();

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="my-4">
	<!-- Event Title -->
	<?php do_action( 'tribe_events_before_the_event_title' ) ?>
	<h3 class="tribe-events-list-event-title mb-2">
		<a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
			<?php the_title() ?>
		</a>
	</h3>
	<?php do_action( 'tribe_events_after_the_event_title' ) ?>

	<!-- Event Meta -->
	<?php do_action( 'tribe_events_before_the_meta' ) ?>
	<div> <!--class tribe-events-event-meta-->
		<div class="author <?php echo esc_attr( $has_venue_address ); ?>">

			<!-- Schedule & Recurrence Details -->
			<div class="tribe-event-schedule-details mb-2">
				<?php echo tribe_events_event_schedule_details() ?>
			</div>

			<!-- location -->
			<?php if ( $venue_name ) : ?>
				<div class="address-location">
					<span class="label">地點：</span><span class="location"><?php echo $venue_details['linked_name']; ?></span>
				</div>
			<?php endif; ?>

			<?php if ( $venue_details ) : ?>
				<!-- Venue Display Info -->
				<div class="tribe-events-venue-details">
				<?php
					// $address_delimiter = empty( $venue_address ) ? ' ' : ', ';
	                //
					// // These details are already escaped in various ways earlier in the process.
					// echo implode( $address_delimiter, $venue_details );
	                //
					// if ( tribe_show_google_map_link() ) {
					// 	echo tribe_get_map_link_html();
					// }
				?>
				</div> <!-- .tribe-events-venue-details -->
			<?php endif; ?>

		</div>
	</div><!-- .tribe-events-event-meta -->

	<!-- Event Cost -->
	<!-- <?php if ( tribe_get_cost() ) : ?>
		<div class="tribe-events-event-cost">
			<span class="ticket-cost"><?php echo tribe_get_cost( null, true ); ?></span>
			<?php
			/**
			 * Runs after cost is displayed in list style views
			 *
			 * @since 4.5
			 */
			do_action( 'tribe_events_inside_cost' )
			?>
		</div>
	<?php endif; ?> -->

	<?php do_action( 'tribe_events_after_the_meta' ) ?>

	<!-- Event Image -->
	<div class="my-4">
		<?php echo tribe_event_featured_image( null, 'medium' ); ?>
	</div>

	<!-- Event Content -->
	<?php do_action( 'tribe_events_before_the_content' ); ?>
	<div class="tribe-events-list-event-description tribe-events-content description entry-summary">
		<?php echo tribe_events_get_the_excerpt( null, wp_kses_allowed_html( 'post' ) ); ?>
	</div><!-- .tribe-events-list-event-description -->

	<div class="d-flex">
		<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more px-5 py-2" rel="bookmark" style="border:1px solid;">
			<?php esc_html_e( '了解更多', 'the-events-calendar' ) ?>
		</a>
	</div>
	<?php
	do_action( 'tribe_events_after_the_content' );
	?>
</div>

<hr>
