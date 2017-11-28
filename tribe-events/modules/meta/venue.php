<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>

<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<div class="mb-3">
		<div class="tribe-events-single-section-title label">
			<?php esc_html_e( tribe_get_venue_label_singular(), 'the-events-calendar' ) ?>
		</div>
		<div class="tribe-venue"> <?php echo tribe_get_venue() ?> </div>
	</div>

	<div class="mb-3">
		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>
		<?php if ( tribe_address_exists() ) : ?>
			<div class="tribe-venue-location">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if ( tribe_show_google_map_link() ) : ?>
						<?php echo tribe_get_map_link_html(); ?>
					<?php endif; ?>
				</address>
			</div>
		<?php endif; ?>
	</div>

	<div>
		<?php if ( ! empty( $phone ) ): ?>
			<div class="label"> <?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?> </div>
			<div class="tribe-venue-tel"> <?php echo $phone ?> </div>
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
			<div> <?php esc_html_e( 'Website:', 'the-events-calendar' ) ?> </div>
			<div class="url"> <?php echo $website ?> </div>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
	</div>
</div>
