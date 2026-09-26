# Rabeya Furniture & Doors - Premium Custom WooCommerce Theme

A full custom, premium WordPress/WooCommerce theme built from scratch for
**Rabeya Furniture and Doors** - a furniture, door and home decor store in Bangladesh.

No page builder. No parent theme. Everything is hand written and shared-hosting friendly.

---

## Feature overview

### Storefront
- Custom homepage: hero slider, trust strip, category grid, featured products,
  sale products, offer countdown, news strip, quote CTA
- Premium banner slider (4 slides, image + text + button, autoplay, dots, arrows, keyboard)
- Offer countdown strip with live day/hour/minute/second timer
- Product badges: Sale, New, Hot
- Wishlist (localStorage + drawer) with live count
- Quick view modal with add-to-cart
- WhatsApp order button (floating + per product)
- Sticky add-to-cart bar on mobile product pages
- Back-to-top button and scroll progress bar
- Scroll reveal animations (respects prefers-reduced-motion)

### Shop
- Custom category banner with image + description + breadcrumb
- Subcategory chip navigation with counts
- Custom sort/count toolbar, 3 column grid, styled pagination

### Product
- Specifications table built from attributes (Wood Type, Finish, Size, Door Hand)
- Custom "Delivery & Warranty" tab and trust badges
- Custom size notice before add-to-cart
- Premium review cards with verified purchase badge and rating summary

### Content
- Custom notice bar under the header
- Blog / notice archive and single post layout
- Latest notices strip on the homepage

### Payments
- Full guide for bKash, SSLCommerz, Nagad and Cash on Delivery in `docs/payment-gateways.md`

---

## Requirements

- WordPress 6.0+
- PHP 7.4+
- WooCommerce (latest)
- Shared hosting friendly - no build step, no Node, no Composer

---

## Installation

1. Download this repository as a ZIP.
2. WordPress admin -> **Appearance -> Themes -> Add New -> Upload Theme**.
3. Select the ZIP, **Install Now**, then **Activate**.
4. Install and activate the **WooCommerce** plugin.
5. Run the WooCommerce setup wizard, set currency to **BDT (Taka)**.

---

## Setup checklist

| Step | Where |
|------|-------|
| Logo + site title | Appearance -> Customize -> Site Identity |
| Banner slides (4) | Appearance -> Customize -> **Rabeya Slider** |
| Notice bar text | Appearance -> Customize -> **Rabeya Notice Bar** |
| WhatsApp number | Appearance -> Customize -> **Rabeya Premium** |
| Offer countdown | Appearance -> Customize -> **Rabeya Premium** |
| Menus | Appearance -> Menus (Primary + Footer) |
| Bengali language | Settings -> General -> Site Language |
| Payment gateways | `docs/payment-gateways.md` |

---

## Recommended catalog setup

**Product categories**

- Living Room Furniture
- Bedroom Furniture
- Dining & Kitchen
- Doors (Main, Bedroom, Bathroom)
- Windows & Frames
- Office Furniture

**Attributes**

- `Wood Type` - Teak, Mahogany, Garjan, Oak, Plywood
- `Finish` - Natural, Walnut, Dark Brown, White
- `Size` - custom (width x height)
- `Door Hand` - Left, Right

---

## File structure

```
rabeya-furniture-doors/
├── style.css                 Theme header
├── functions.php             Setup, assets, helpers
├── header.php                Topbar, sticky header, nav, cart
├── footer.php                4 column footer + widgets
├── front-page.php            Homepage sections
├── index.php  archive.php  single.php  page.php
├── woocommerce.php           WooCommerce wrapper
├── theme.json                Color palette + typography
├── assets/
│   ├── css/  main, slider, product, shop, blog, reviews, premium
│   └── js/   main, slider, premium, offer-timer
├── inc/
│   ├── customizer.php        Slider customizer
│   ├── product-specs.php     Specs table, tabs, badges
│   ├── shop.php              Shop / category archive
│   ├── notice.php            Notice bar + homepage notices
│   ├── reviews.php           Review cards + summary
│   └── premium.php           Wishlist, quick view, WhatsApp, floats
├── template-parts/
│   ├── slider.php
│   └── offer-strip.php
├── languages/
│   ├── bn_BD.po              Bengali translation
│   └── README.txt
├── docs/
│   └── payment-gateways.md
└── README.md
```

---

## Customization

- **Colors** - edit the CSS variables at the top of `assets/css/main.css`
  (`--wood`, `--wood-dark`, `--ink`, `--ink-soft`, `--cream`, `--line`).
- **Logo** - Appearance -> Customize -> Site Identity.
- **Contact info** - footer section in `footer.php`.
- **Hero text** - Appearance -> Customize -> Rabeya Slider.
- **WhatsApp number** - Appearance -> Customize -> Rabeya Premium.

---

## Bengali translation

The theme ships with `languages/bn_BD.po`. WordPress needs the compiled `.mo`
file - see `languages/README.txt` for three ways to generate it (Poedit is easiest).

---

## License

GPL v2 or later.
