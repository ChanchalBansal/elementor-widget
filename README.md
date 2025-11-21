# Team Member Card — Elementor widget

Adds a simple Elementor widget: **Team member card** with fields:
- Name (text)
- Role (text)
- Bio (textarea)
- Photo (image upload)
- LinkedIn URL (url)

## Installation

1. Copy the `team-member-card` folder into `wp-content/plugins/`.
2. Activate the plugin from the WordPress admin → Plugins.
3. Make sure Elementor is installed & active.
4. In Elementor editor, open the widget panel and search for **Team member card** (category: General).

## Files

- `team-member-card.php` — plugin bootstrap and registration
- `widgets/class-team-member-card-widget.php` — the Elementor widget

## Security & best practices used

- All user-provided values are sanitized before output:
  - `sanitize_text_field()` for single-line fields.
  - `wp_kses_post()` for the bio to allow safe HTML.
  - `esc_url()` for image and link URLs and `esc_html()`/`esc_attr()` for text output.
- Uses `elementor/widgets/register` hook to register the widget.
- Accessible markup (role/alt attributes).
- Keeps naming prefixed (`tmc_`, `TMC_`) to avoid collisions.

## Testing / Debugging

1. Activate plugin + Elementor.
2. Edit a page with Elementor and add “Team member card”.
3. Change fields — the preview updates. Save and view the page front-end.
4. If not showing:
   - Check `WP_DEBUG` for PHP errors.
   - Verify `elementor/loaded` action fired (Elementor active).
   - Make sure files are uploaded correctly.
