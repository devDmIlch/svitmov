<?php
/**
 * Template for the 'Advantages section'.
 *
 * @package svitmov/theme
 * @since 0.0.1
 */

$items = [
	'diamond' => __( 'Якісні знання, що відповідають міжнародним стандартам', 'svitmov' ),
	'badge'   => __( 'Ми — офіційний центр з підготовки та складання міжнародних іспитів Cambridge', 'svitmov' ),
	'paper'   => __( 'Сертифіковані викладачі', 'svitmov' ),
	'book'    => __( 'Можливість обрати зручну форму навчання', 'svitmov' ),
	'person'  => __( 'Турбота про клієнтів', 'svitmov' ),
	'coffee'  => __( 'Комфортна та привітна атмосфера', 'svitmov' ),
]

?>
<section class="section-advantages">
	<h2 class="section-title">
		<?php esc_html_e( 'Чому ми?', 'svitmov' ); ?>
	</h2>
	<div class="content-wrap">
		<?php foreach ( $items as $item_class => $item_desc ) : ?>
			<div class="adv-el gray-box">
				<div class="adv-img">
					<?php \Svitmov\Includes\Helpers::the_svg_file( $item_class ); ?>
				</div>
				<p class="adv-desc heavy-text">
					<?php echo esc_html( $item_desc ); ?>
				</>
			</div>
		<?php endforeach; ?>
	</div>
</section>
