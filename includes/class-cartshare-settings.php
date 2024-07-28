<?php
class CartShare_Settings {
    public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ) );
        add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
    }

    public static function add_settings_page() {
        add_options_page(
            'CartShare Settings',
            'CartShare',
            'manage_options',
            'cartshare',
            array( __CLASS__, 'settings_page_content' )
        );
    }

    public static function register_settings() {
        register_setting( 'cartshare_settings', 'clicksend_username' );
        register_setting( 'cartshare_settings', 'clicksend_api_key' );
        register_setting( 'cartshare_settings', 'sms_content' );
        register_setting( 'cartshare_settings', 'salesperson_role' );
    }

    public static function settings_page_content() {
        ?>
        <div class="wrap">
            <h1>CartShare Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'cartshare_settings' );
                do_settings_sections( 'cartshare_settings' );
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">ClickSend Username</th>
                        <td><input type="text" name="clicksend_username" value="<?php echo esc_attr( get_option('clicksend_username') ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">ClickSend API Key</th>
                        <td><input type="text" name="clicksend_api_key" value="<?php echo esc_attr( get_option('clicksend_api_key') ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">SMS Content</th>
                        <td><textarea name="sms_content"><?php echo esc_textarea( get_option('sms_content') ); ?></textarea></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Salesperson Role</th>
                        <td>
                            <select name="salesperson_role">
                                <?php wp_dropdown_roles( get_option('salesperson_role') ); ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
