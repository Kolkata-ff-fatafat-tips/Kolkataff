<?php if (!defined('ABSPATH')) exit; ?>
<section class="kff-container kff-section">
    <div class="kff-section__head">
        <p class="kff-eyebrow">Support</p>
        <h1>Contact Us</h1>
        <p>Update these details from the Kolkata FF dashboard.</p>
    </div>
    <div class="kff-contact-grid">
        <article><span>Email</span><strong><?php echo esc_html(kff_get_option('contact_email')); ?></strong></article>
        <article><span>Phone</span><strong><?php echo esc_html(kff_get_option('contact_phone')); ?></strong></article>
        <article><span>Address</span><strong><?php echo esc_html(kff_get_option('contact_address')); ?></strong></article>
    </div>
    <form class="kff-contact-form" method="post" action="mailto:<?php echo esc_attr(kff_get_option('contact_email')); ?>">
        <label>Name <input name="name" required></label>
        <label>Email <input type="email" name="email" required></label>
        <label>Message <textarea name="message" rows="5" required></textarea></label>
        <button class="kff-btn" type="submit">Send Message</button>
    </form>
</section>
