# CartShare by Ansons

CartShare by Ansons is a WooCommerce plugin that allows specific user roles, such as salespersons, to create carts for customers and send SMS notifications via ClickSend. This plugin helps streamline the sales process by enabling sales personnel to prepare carts and share them directly with customers.

## Features

- Create and share carts with customers.
- Send SMS notifications with cart details using ClickSend.
- Manage user roles and permissions for cart sharing.

## Installation

1. Upload the `cartshare-by-ansons` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Configure the plugin settings in the WooCommerce settings panel.

## Usage

1. Ensure the user has the `create_cart` capability. This capability is typically assigned to salespersons.
2. On the WooCommerce cart page, the user will see a "Share Cart" button if they have the necessary permissions.
3. Click the "Share Cart" button to open the modal form.
4. Fill in the customer's phone number and branch, then click "Share Cart".
5. An order will be created from the current cart, and an SMS will be sent to the customer with the cart details.

## Hooks and Filters

### Actions

- `woocommerce_after_cart`: Adds the "Share Cart" button to the cart page.
- `wp_footer`: Adds the share cart modal to the footer.
- `wp_enqueue_scripts`: Enqueues the necessary JavaScript and CSS files.
- `wp_ajax_cartshare_share_cart`: Handles the AJAX request for sharing the cart.
- `wp_ajax_nopriv_cartshare_share_cart`: Handles the AJAX request for non-logged-in users.

### Filters

- `cartshare_sms_content`: Modify the content of the SMS sent to the customer.

## Contributing

1. Fork the repository on GitHub.
2. Create a new branch for your feature or bugfix.
3. Make your changes and commit them with a descriptive message.
4. Push your changes to your forked repository.
5. Create a pull request to the main repository.

## Changelog

### 1.3.6
- Initial release with basic cart sharing functionality.

## Credits

- Developed by KC Cheng.

## License

This plugin is licensed under the GPL-2.0+ License. See the LICENSE file for details.
