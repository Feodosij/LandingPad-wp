<?php
/**
 * Reusable Template: Contacts Section
 */

$title = get_field('contacts_section_title', 'option');

$email_icon = get_field('contact_email_icon', 'option');
$email      = get_field('contact_email', 'option');

$phone_icon = get_field('contact_phone_icon', 'option');
$phone      = get_field('contact_phone', 'option');

$social_icon = get_field('contact_social_icon', 'option');
$socials     = get_field('contact_social_list', 'option');

$accent_bg_light = isset($GLOBALS['accent_bg_light']) ? $GLOBALS['accent_bg_light'] : '#F9FBFF';
$accent_font = isset($GLOBALS['accent_font']) ? $GLOBALS['accent_font'] : '#0F38B4';
?>

<section class="contacts" id="contacts" style="--accent-font: <?php echo esc_attr( $accent_font ); ?>; --accent-bg-light: <?php echo esc_attr( $accent_bg_light ); ?>;">
    <div class="container">
        <?php if ( $title ) {?>
            <div class="contacts__title">
                <h2>
                    <?php echo esc_html( $title ); ?>
            
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_528)">
                            <path d="M19.6337 37.8516C23.7921 37.8516 31.0693 37.5084 38 37.5084M13.396 28.5869L27.9505 10.7437M3 25.4986C3 24.4006 3 9.94306 3 2.85156" stroke="#0F38B4" stroke-width="3.46535" stroke-linecap="round" />
                        </g>
                        <defs>
                            <clipPath id="clip0_1_528">
                            <rect width="40" height="40" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </h2>
            </div>
        <?php } ?>
        <div class="contacts__grid">
            <div class="contact-card">
                <div class="contact-card__top-icon">
                    <?php if ( $email_icon ) { ?>
                        <img src="<?php echo esc_url( $email_icon ); ?>" alt="Email icon" loading="lazy">
                    <?php } ?>
                </div>

                <div class="contact-card__divider"></div>

                <div class="contact-card__content">
                    <?php if ( $email ) { ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-link"><?php echo esc_html( $email ); ?></a>
                    <?php } ?>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-card__top-icon">
                    <?php if ( $phone_icon ) { ?>
                        <img src="<?php echo esc_url( $phone_icon ); ?>" alt="Phone icon" loading="lazy">
                    <?php } ?>
                </div>

                <div class="contact-card__divider"></div>

                <div class="contact-card__content">
                    <?php if ( $phone ) { 
                        $phone_clean = preg_replace( '/[^0-9+]/', '', $phone ); ?>
                        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="contact-link"><?php echo esc_html( $phone ); ?></a>
                    <?php } ?>
                </div>
            </div>

            <div class="contact-card">
                <div class="contact-card__top-icon">
                    <?php if ( $social_icon ) { ?>
                        <img src="<?php echo esc_url( $social_icon ); ?>" alt="Social icon" loading="lazy">
                    <?php } ?>
                </div>

                <div class="contact-card__divider"></div>

                <div class="contact-card__content">
                    <?php if ( $socials ) { ?>
                        <div class="socials-list">
                            <?php foreach ( $socials as $item ) { 
                                $icon = $item['social_icon'];
                                $link = $item['social_link'];
                                if ( !$icon ) continue;
                                ?>

                                <a href="<?php echo esc_url( $link ); ?>" class="social-link" target="_blank">
                                    <img src="<?php echo esc_url( $icon ); ?>" alt="Social icon" loading="lazy">
                                </a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>