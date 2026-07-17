<?php
/**
 * The full "Contacts" section: phone/e-mail/social info column plus the
 * contact form. Included near-verbatim on every page template, mirroring
 * the original one-page design where contacts are always reachable.
 *
 * @package StudioFrame
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sf_phone   = get_theme_mod( 'sf_contact_phone', '' );
$sf_email   = sf_get_contact_email();
$sf_socials = sf_get_social_links();

$sf_social_labels = array(
	'telegram'  => 'Telegram',
	'whatsapp'  => 'WhatsApp',
	'vk'        => 'VK',
	'instagram' => 'Instagram',
	'youtube'   => 'YouTube',
);
?>
<section class="contacts" id="contacts">
	<div class="container">
		<div class="contacts__inner">
			<div class="contacts__info">
				<h2 class="contacts__title"><?php esc_html_e( 'Contact', 'studio-frame' ); ?></h2>
				<?php if ( $sf_phone ) : ?>
					<a class="contacts__phone" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $sf_phone ) ); ?>"><?php echo esc_html( $sf_phone ); ?></a>
				<?php endif; ?>
				<?php if ( $sf_email ) : ?>
					<a class="contacts__mail" href="mailto:<?php echo esc_attr( $sf_email ); ?>"><?php echo esc_html( $sf_email ); ?></a>
				<?php endif; ?>
				<?php if ( ! empty( $sf_socials ) ) : ?>
					<div class="contacts__social">
						<?php foreach ( $sf_socials as $sf_network => $sf_url ) : ?>
							<a class="contacts__social-link btn-main" href="<?php echo esc_url( $sf_url ); ?>" target="_blank" rel="noopener noreferrer">
								<span class="btn-main__inner">
									<span class="btn-main__default"><?php echo esc_html( $sf_social_labels[ $sf_network ] ?? $sf_network ); ?></span>
									<span class="btn-main__hover"><?php echo esc_html( $sf_social_labels[ $sf_network ] ?? $sf_network ); ?></span>
								</span>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="contacts__form">
				<h3 class="contacts__form-title"><?php esc_html_e( 'Shall we discuss your project?', 'studio-frame' ); ?></h3>
				<?php get_template_part( 'template-parts/contact/contact-form', null, array( 'context' => 'contacts' ) ); ?>
			</div>
		</div>
	</div>
</section>
