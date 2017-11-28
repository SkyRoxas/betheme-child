<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/organizer.php
 *
 * @package TribeEventsCalendar
 * @version 4.4
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h3>
	<?php
	do_action( 'tribe_events_single_meta_organizer_section_start' );

	foreach ( $organizer_ids as $organizer ) {
		if ( ! $organizer ) {
			continue;
		}

		?>
		<dt style="display:none;"><?php // This element is just to make sure we have a valid HTML ?></dt>
		<div class="tribe-organizer mb-3">
			<?php echo tribe_get_organizer_link( $organizer ) ?>
		</div>
	<div>


			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<div class="mb-3">
					<div class="label">
						<?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?>
					</div>
					<div class="tribe-organizer-tel">
						<?php echo esc_html( $phone ); ?>
					</div>
				</div>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<div class="mb-3">
					<div class="label">
						<?php esc_html_e( 'Email:', 'the-events-calendar' ) ?>
					</div>
					<div class="tribe-organizer-email">
						<?php echo esc_html( $email ); ?>
					</div>
				</div>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<div>
					<?php esc_html_e( 'Website:', 'the-events-calendar' ) ?>
				</div>
				<div class="tribe-organizer-url">
					<?php echo $website; ?>
				</div>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</div>
</div>
