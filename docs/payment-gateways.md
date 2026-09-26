# Payment Gateways for Rabeya Furniture & Doors

Bangladeshi payment options for the WooCommerce store, ranked by how easy
they are to set up on shared hosting.

---

## 1. bKash (manual / plugin)

bKash does **not** ship an official free WooCommerce plugin. Two practical routes:

### Option A - Manual bKash (recommended for launch, 0 cost)

1. Install the free **"Direct Bank Transfer" / "Check payments"** style flow by
   using the built-in **Cash on delivery** gateway as a base.
2. Better: install the free plugin **"Custom Payment Method for WooCommerce"**
   (or "Payment Gateway Based Fees and Discounts" to clone COD).
3. Create a new gateway labelled **bKash** with these instructions shown at checkout:

   ```
   Send the total amount to our bKash Merchant/Personal number:
   01XXXXXXXXX (Personal)

   Then submit the bKash Transaction ID (TrxID) in the field below.
   Your order will be confirmed within 1 hour during business hours.
   ```

4. Add a required checkout field **"bKash TrxID"** with this snippet in
   `functions.php` (or a small site-specific plugin):

   ```php
   // Show a TrxID field when bKash is the chosen gateway.
   add_action( 'woocommerce_after_checkout_billing_form', function ( $checkout ) {
       woocommerce_form_field( 'bkash_trxid', array(
           'type'     => 'text',
           'required' => false,
           'label'    => __( 'bKash Transaction ID', 'rabeya' ),
           'placeholder' => 'e.g. 8N7A2K9LQ1',
       ), $checkout->get_value( 'bkash_trxid' ) );
   } );

   // Validate + save.
   add_action( 'woocommerce_checkout_process', function () {
       $chosen = WC()->session->get( 'chosen_payment_method' );
       if ( 'bkash' === $chosen && empty( $_POST['bkash_trxid'] ) ) {
           wc_add_notice( __( 'Please enter your bKash Transaction ID.', 'rabeya' ), 'error' );
       }
   } );

   add_action( 'woocommerce_checkout_update_order_meta', function ( $order_id ) {
       if ( ! empty( $_POST['bkash_trxid'] ) ) {
           update_post_meta( $order_id, '_bkash_trxid', sanitize_text_field( wp_unslash( $_POST['bkash_trxid'] ) ) );
       }
   } );

   // Show it on the admin order page and in emails.
   add_action( 'woocommerce_admin_order_data_after_billing_address', function ( $order ) {
       $trx = get_post_meta( $order->get_id(), '_bkash_trxid', true );
       if ( $trx ) {
           echo '<p><strong>bKash TrxID:</strong> ' . esc_html( $trx ) . '</p>';
       }
   } );
   ```

### Option B - bKash Merchant (Checkout API)

- Requires a **merchant account** (business documents, TIN, bank account).
- Apply at https://merchant.bkash.com
- Once approved you get: `app_key`, `app_secret`, `username`, `password`.
- Install a third-party plugin such as **"bKash for WooCommerce"** from the
  plugin directory, or a paid gateway plugin that supports the Checkout URL API.
- Enter the credentials in the plugin settings. Sandbox first, then live.

> Note: The bKash Checkout API needs the server to receive a callback from
> bKash. Shared hosting works, but the domain must have a **valid SSL
> certificate** (most cPanel hosts provide free Let's Encrypt SSL).

---

## 2. SSLCommerz (best all-in-one for Bangladesh)

SSLCommerz aggregates bKash, Nagad, Rocket, all cards and internet banking in
one gateway. This is usually the easiest single integration.

### Setup

1. Create a **sandbox** account: https://developer.sslcommerz.com/registration/
2. In the sandbox dashboard create a store and note:
   - Store ID
   - Store Password
3. Install the free plugin **"SSLCommerz for WooCommerce"**
   (search Plugins -> Add New -> "SSLCommerz").
4. WooCommerce -> Settings -> Payments -> **SSLCommerz** -> Manage:
   - Enable
   - Sandbox mode: ON (while testing)
   - Store ID / Store Password: paste the sandbox values
   - IPN URL: leave as shown by the plugin
5. Place a test order, pay with the sandbox test credentials, confirm the order
   status changes to **Processing**.
6. Apply for a **live** account at https://sslcommerz.com (needs trade licence,
   TIN, bank details). Replace the sandbox credentials with live ones and turn
   sandbox mode OFF.

### Sandbox test card

```
Card Number : 4111 1111 1111 1111
Expiry      : any future date
CVV         : 111
OTP         : 123456
```

---

## 3. Nagad

Same pattern as bKash: no official free plugin. Use the manual flow (Option A)
or use SSLCommerz, which already includes Nagad as a channel.

---

## 4. Cash on Delivery

WooCommerce ships this gateway for free and it is **essential** for furniture
in Bangladesh - customers want to inspect large items before paying.

WooCommerce -> Settings -> Payments -> **Cash on delivery** -> Enable.

Restrict it to inside Dhaka if you like:

```php
add_filter( 'woocommerce_available_payment_gateways', function ( $gateways ) {
    if ( ! is_admin() && isset( $gateways['cod'] ) ) {
        $city = WC()->customer ? WC()->customer->get_shipping_city() : '';
        if ( 'Dhaka' !== $city ) {
            unset( $gateways['cod'] );
        }
    }
    return $gateways;
} );
```

---

## Recommended launch stack

| Priority | Gateway | Why |
|----------|---------|-----|
| 1 | Cash on Delivery | Trust, large items |
| 2 | bKash (manual TrxID) | Almost everyone has bKash |
| 3 | SSLCommerz (live) | Cards + all mobile wallets in one |
| 4 | bKash Merchant API | Only after you have a merchant account |

---

## Checklist before going live

- [ ] SSL certificate installed (https on the whole site)
- [ ] WooCommerce currency set to **BDT (Taka)**
- [ ] bKash number and COD rules written in the checkout instructions
- [ ] Test order placed for every enabled gateway (use sandbox first)
- [ ] Order confirmation email checked (admin + customer)
- [ ] Refund and return policy page published
- [ ] bKash / SSLCommerz settlement account details verified

## Security notes

- Never store full card numbers in the WooCommerce database - gateway plugins
  handle this. Only store the bKash TrxID.
- Keep the SSLCommerz Store Password out of the theme repository; it belongs in
  the WordPress database (plugin settings), not in code.
- If you write custom gateway code later, verify the gateway's IPN signature
  before marking an order as paid. A WooCommerce order should only move to
  "Processing" after a verified IPN or a manually checked TrxID.
