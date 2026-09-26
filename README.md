# Rabeya Furniture & Doors - Custom WooCommerce Theme

A full custom WordPress/WooCommerce theme built from scratch for **Rabeya Furniture and Doors** - a furniture, doors and home decor ecommerce store.

## Features

- Full custom theme (no page builder, no parent theme)
- Warm wood + cream palette, modern minimal layout
- Custom homepage: hero, trust strip, category grid, featured products, quote CTA
- WooCommerce support with custom product grid styling
- Sticky header with live cart count
- Responsive (mobile menu at 820px)
- Translation ready (`rabeya` text domain)
- Theme options via `theme.json` (color palette + font sizes)

## Requirements

- WordPress 6.0+
- PHP 7.4+
- WooCommerce (latest)
- Shared hosting friendly (no build step, no Node)

## Installation

1. Download this repository as a ZIP.
2. WordPress admin -> **Appearance -> Themes -> Add New -> Upload Theme**.
3. Select the ZIP and click **Install Now**, then **Activate**.
4. Install and activate the **WooCommerce** plugin.
5. Run the WooCommerce setup wizard (currency: BDT).

## Recommended setup for Rabeya Furniture and Doors

Create these product categories first:

- Living Room Furniture
- Bedroom Furniture
- Dining & Kitchen
- Doors (Main Door, Bedroom Door, Bathroom Door)
- Windows & Frames
- Office Furniture

Then add product attributes:

- `Wood Type` - Teak, Mahogany, Garjan, Oak, Plywood
- `Finish` - Natural, Walnut, Dark Brown, White
- `Size` - custom (width x height)
- `Door Hand` - Left, Right

## File structure

```
rabeya-furniture-doors/
├── style.css              # Theme header + entry stylesheet
├── functions.php          # Setup, widgets, scripts, helpers
├── header.php             # Topbar + sticky header + nav + cart
├── footer.php             # Footer columns + widgets
├── front-page.php         # Homepage sections
├── index.php              # Archive / blog fallback
├── page.php               # Static pages
├── woocommerce.php        # WooCommerce wrapper
├── theme.json             # Color palette + typography
├── assets/
│   ├── css/main.css       # All design styles
│   └── js/main.js         # Mobile menu + smooth scroll
└── README.md
```

## Customization

- **Colors**: edit the CSS variables at the top of `assets/css/main.css` (`--wood`, `--ink`, `--cream`).
- **Logo**: Appearance -> Customize -> Site Identity -> Logo.
- **Contact info**: edit the footer section in `footer.php`.
- **Hero text**: edit `front-page.php`.

## License

GPL v2 or later.
