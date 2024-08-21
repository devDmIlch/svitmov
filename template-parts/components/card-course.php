<?php
/**
 * Template for single 'Course card'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

// This template requires arguments.
if ( empty( $args ) ) {
	return;
}

// Prepare classes for the card.
$classes = implode( ' ', [ 'card-course', ...( $args['classes'] ?? [] ) ] );

?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<p class="course-type" type="<?php echo esc_attr( $args['course_type'] ); ?>">
		<?php
		switch ( $args['course_type'] ) {
			case 'in-person':
				esc_html_e( 'В нашому центрі', 'svitmov' );
				break;
			case 'online':
				esc_html_e( 'Онлайн', 'svitmov' );
				break;
			case 'mixed':
				esc_html_e( 'В центрі та онлайн', 'svitmov' );
				break;
		}
		?>
	</p>
	<div class="card-body">
		<h2 class="card-title">
			<?php echo esc_html( $args['title'] ); ?>
		</h2>
		<?php if ( ! empty( $args['lang_levels'] ) ) : ?>
			<p class="lang-levels">
				<span class="level-text">
					<?php
					if ( count( $args['lang_levels'] ) > 1 ) {
						esc_html_e( 'Рівні', 'svitmov' );
					} else {
						esc_html_e( 'Рівень', 'svitmov' );
					}
					?>
				</span>
				<span class="level-name">
					<?php echo esc_html( implode( ', ', array_map( static fn ( $term_obj ) => $term_obj->name, $args['lang_levels'] ) ) ); ?>
				</span>
			</p>
		<?php endif; ?>
		<p class="schedule">
			<span class="detail-name">
				<?php esc_html_e( 'Заняття:', 'svitmov' ); ?>
			</span>
			<span class="detail-value">
				<?php
				echo esc_html( $args['num_lessons'] ) . ' ';

				switch ( $args['num_lessons_per'] ) {
					case 'week':
						esc_html_e( 'в тиждень', 'svitmov' );
						break;
					case 'month':
						esc_html_e( 'в місяць', 'svitmov' );
						break;
					case 'full':
						esc_html_e( 'за курс', 'svitmov' );
						break;
				}
				?>
			</span>
		</p>
		<?php if ( ! empty( $args['month_duration'] ) ) : ?>
			<p class="duration">
				<span class="detail-name">
					<?php esc_html_e( 'Тривалісь:', 'svitmov' ); ?>
				</span>
				<span class="detail-value">
					<?php echo esc_html( $args['month_duration'] . ' ' . __( 'місяців', 'svitmov' ) ); ?>
				</span>
			</p>
		<?php endif; ?>
	</div>
	<div class="card-bottom">
		<div class="separator"></div>
		<div class="price-list">
			<?php if ( ! empty( $args['price']['full'] ) ) : ?>
				<div class="price-cat">
					<p class="price-cat-name"><?php esc_html_e( 'За курс', 'svitmov' ); ?></p>
					<p class="price-val"><?php echo esc_html( $args['price']['full'] . ' ' . __( 'грн', 'svitmov' ) ); ?></p>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $args['price']['month'] ) ) : ?>
				<div class="price-cat">
					<p class="price-cat-name"><?php esc_html_e( 'За місяць', 'svitmov' ); ?></p>
					<p class="price-val"><?php echo esc_html( $args['price']['month'] . ' ' . __( 'грн', 'svitmov' ) ); ?></p>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $args['price']['lesson'] ) ) : ?>
				<div class="price-cat">
					<p class="price-cat-name"><?php esc_html_e( 'За заняття', 'svitmov' ); ?></p>
					<p class="price-val"><?php echo esc_html( $args['price']['lesson'] . ' ' . __( 'грн', 'svitmov' ) ); ?></p>
				</div>
			<?php endif; ?>
		</div>
		<div class="is-active" active="<?php echo esc_attr( $args['is_active'] ); ?>">
			<?php
			switch ( $args['is_active'] ) {
				case 1:
					esc_html_e( 'Набір триває', 'svitmov' );
					break;
				case 0:
					esc_html_e( 'Набір припинено', 'svitmov' );
					break;
			}
			?>
		</div>
		<div class="action-buttons">
			<a class="action-button" href="<?php echo esc_url( $args['permalink'] ); ?>">
				<?php esc_html_e( 'Детальніше', 'svitmov' ); ?>
			</a>
			<?php if ( $args['is_active'] ?? true ) : ?>
				<a class="button-yellow-small create-form" course="<?php echo esc_attr( $args['course_id'] ); ?>">
					<?php esc_html_e( 'Записатися', 'svitmov' ); ?>
				</a>
			<?php else : ?>
				<a class="button-yellow-small inactive">
					<?php esc_html_e( 'Записатися', 'svitmov' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
