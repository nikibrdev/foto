=== Studio Frame ===
Requires at least: 6.4
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: photography, portfolio, custom-colors, custom-logo, custom-menu, featured-images, translation-ready, block-patterns

A modern, art-directed WordPress theme built for photographers, with a friendly setup checklist and no required third-party plugins.

== Description ==

Studio Frame is a portfolio-first WordPress theme for photographers: a
homepage with a featured-project slider, a filterable portfolio grid,
single project pages with a photo gallery and a booking form, client
testimonials, an FAQ section and a real, working contact form — all
editable from the WordPress admin, without touching a line of code.

**Highlights**

* Portfolio ("Project") custom post type with price, date, status and a
  photo gallery per project.
* Two taxonomies — Project Categories and Project Statuses — power the
  catalogue filter buttons and each project's status badge, with a
  per-status accent colour.
* Testimonials and FAQ custom post types for the homepage sections.
* A dedicated "Studio Frame Settings" panel in the Customizer covers the
  hero section, the About teaser, the call-to-action band, contact
  details, social links, the footer and the site's colour scheme — with
  live colour preview.
* Real contact + booking forms (AJAX, nonce-protected, honeypot + rate
  limited, delivered by e-mail) — no form-builder plugin required.
* A "Get Started" screen under Appearance with a live setup checklist and
  one-click, fully reversible demo content.
* Gutenberg block patterns and style variations for building extra pages
  without a page-builder plugin.
* Custom fields are powered by a bundled copy of the CMB2 library — no
  separate plugin to install.
* Translation-ready (text domain `studio-frame`); ships with a complete
  Russian (ru_RU) translation matching the theme's original design
  reference, and an English default for every other locale.

**No required plugins.** Everything above works out of the box on a
stock WordPress install. An SEO plugin (Yoast SEO, RankMath) is
optional — Studio Frame provides a minimal built-in meta description /
Open Graph fallback and automatically steps aside if one is active.

== Installation ==

1. In WordPress, go to **Appearance > Themes > Add New > Upload Theme**
   and upload the theme's `.zip` file, or extract it directly into
   `wp-content/themes/`.
2. Activate the theme.
3. You'll be taken to (or notified about) **Appearance > Get Started** —
   follow the checklist there. It links directly to the right screen for
   every step: logo, contact e-mail, menu, your first project, the About
   and Contacts pages, testimonials and FAQ.
4. Not sure where to start? Click **Install demo content** on that same
   screen to see a fully populated example site, then replace the sample
   projects/testimonials/FAQ with your own at your own pace.
5. Open the **Customizer** (Appearance > Customize) to edit all of the
   site's text, contact details, social links and colours.

== Frequently Asked Questions ==

= Do I need any other plugins for this theme to work? =

No. Custom fields, the contact/booking forms and the portfolio filter are
all built into the theme. An SEO plugin is optional.

= How do I add a project to my portfolio? =

Go to **Projects > Add New**. Set a Cover Photo (Featured Image), write a
short description in the main editor, then fill in the "Project Details"
box below it (price, date, status, photo gallery) and assign a Category
in the sidebar.

= How do I change the colours? =

**Appearance > Customize > Studio Frame Settings > Colours.** Changes
preview live before you publish them.

= Where do the contact form submissions go? =

To the e-mail address set in **Customizer > Studio Frame Settings >
Contact Details**, or your WordPress admin e-mail if that field is left
empty.

= Can I use Elementor or another page builder with this theme? =

Studio Frame's own templates are plain PHP, not built with a page
builder, so they aren't editable with one. Extra pages you create
yourself (using the "Blank canvas" page template) use the standard
WordPress block editor, including the theme's own block patterns.

== Changelog ==

= 1.0.0 =
* Initial release.

== Credits ==

* CMB2 (bundled, GPL-2.0-or-later) — https://github.com/CMB2/CMB2
* Swiper (MIT) — https://swiperjs.com
* GraphModal (MIT) — https://github.com/nikita-team/graph-modal
* normalize.css (MIT) — https://necolas.github.io/normalize.css/
* GSAP + ScrollTrigger — https://gsap.com (see LICENSE for current terms)
* IBM Plex Sans (SIL OFL 1.1), Manrope (SIL OFL 1.1)

See LICENSE for full attribution and licensing details.
