<?php
/**
 * Created by PhpStorm.
 * User: Habibi
 * Date: 2/2/2017
 * Time: 10:40 AM
 */
if (!defined('ABSPATH')) exit; // No direct access allowed
@session_start();
// add accepted payment shetab
function edd_accepted_payment_icons_shetab($array)
{
    $shetab = plugins_url('/inc/template/images/shetab.png', edd_saman_bank_path);
    $array[$shetab] = __('All credit cards Shetab', 'edd-saman-bank');
    return $array;
}

add_filter("edd_accepted_payment_icons", 'edd_accepted_payment_icons_shetab', 10, 1);

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (!function_exists('edd_saman_bank_error')) {
    function edd_saman_bank_error($error)
    {
        switch ($error) {
            case '-1':
                return __('saman bank error -1', 'edd-saman-bank');
                break;
            case '-3':
                return __('saman bank error -3', 'edd-saman-bank');
                break;
            case '-4':
                return __('saman bank error -4', 'edd-saman-bank');
                break;
            case '-6':
                return __('saman bank error -6', 'edd-saman-bank');
                break;
            case '-7':
                return __('saman bank error -7', 'edd-saman-bank');
                break;
            case '-8':
                return __('saman bank error -8', 'edd-saman-bank');
                break;
            case '-9':
                return __('saman bank error -9', 'edd-saman-bank');
                break;
            case '-10':
                return __('saman bank error -10', 'edd-saman-bank');
                break;
            case '-11':
                return __('saman bank error -11', 'edd-saman-bank');
                break;
            case '-12':
                return __('saman bank error -12', 'edd-saman-bank');
                break;
            case '-13':
                return __('saman bank error -13', 'edd-saman-bank');
                break;
            case '-14':
                return __('saman bank error -14', 'edd-saman-bank');
                break;
            case '-15':
                return __('saman bank error -15', 'edd-saman-bank');
                break;
            case '-16':
                return __('saman bank error -16', 'edd-saman-bank');
                break;
            case '-17':
                return __('saman bank error -17', 'edd-saman-bank');
                break;
            case '-18':
                return __('saman bank error -18', 'edd-saman-bank');
                break;
            case '-19':
                return __('saman bank error exist', 'edd-saman-bank');
                break;
            default:
                return $error;
                break;
        }
    }
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if (!function_exists('edd_rial')) {
    function edd_rial($formatted, $currency, $price)
    {
        return $price . __('RIAL', 'edd-saman-bank');
    }

    add_filter('edd_rial_currency_filter_after', 'edd_rial', 10, 3);
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function saman_bank_cc_form_edd()
{
    do_action('saman_bank_cc_form_action');
}

add_filter('edd_saman-bank_cc_form', 'saman_bank_cc_form_edd');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function edd_settings_sections_gateways_saman_bank($array)
{
    $array['saman-bank'] = __('Setting Saman Bank', 'edd-saman-bank');
    return $array;
}

add_filter('edd_settings_sections_gateways', 'edd_settings_sections_gateways_saman_bank');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function edd_register_saman_bank_gateway_settings($gateway_settings)
{
    $saman_settings = array(
        array(
            'id' => 'saman_settings',
            'name' => __('<strong>Saman Bank Setting</strong>', 'edd-saman-bank'),
            'desc' => __('Setting Saman Bank', 'edd-saman-bank'),
            'type' => 'header'
        ),
        array(
            'id' => 'merchant-saman-bank',
            'name' => __('Merchant code', 'edd-saman-bank'),
            'desc' => '',
            'type' => 'text',
            'size' => 'regular'
        ),
        array(
            'id' => 'password-saman-bank',
            'name' => __('Merchant pass', 'edd-saman-bank'),
            'desc' => '',
            'type' => 'text',
            'size' => 'regular'
        )
    );

    $saman_settings = apply_filters('edd_saman-bank_settings', $saman_settings);
    $gateway_settings['saman-bank'] = $saman_settings;

    return $gateway_settings;

}

add_filter('edd_settings_gateways', 'edd_register_saman_bank_gateway_settings');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function saman_bank_process_payment_edd($purchase_data)
{
    global $edd_options;
    $payment_data = array(
        'price' => $purchase_data['price'],
        'date' => $purchase_data['date'],
        'user_email' => $purchase_data['post_data']['edd_email'],
        'purchase_key' => $purchase_data['purchase_key'],
        'currency' => $edd_options['currency'],
        'downloads' => $purchase_data['downloads'],
        'cart_details' => $purchase_data['cart_details'],
        'user_info' => $purchase_data['user_info'],
        'status' => 'pending'
    );
    $payment = edd_insert_payment($payment_data);
    if ($payment) {
        $merchant = $edd_options['merchant-saman-bank'];
        $password = $edd_options['password-saman-bank'];
        unset($_SESSION['saman_payment']);
        $amount = str_replace(".00", "", $purchase_data['price']);
        $_SESSION['saman_payment'] = $amount;
        $callBackUrl = add_query_arg('order', 'saman', get_permalink($edd_options['success_page']));
        echo '
            <link href="' . plugins_url('/inc/template/css/style.css', edd_saman_bank_path) . '?ver=' . edd_saman_bank_ver . '" rel="stylesheet">
        <form id="checkout_confirmation"  method="post" action="https://sep.shaparak.ir/Payment.aspx" style="margin:0px"  >
		<input type="hidden" id="Amount" name="Amount" value="' . esc_attr($amount) . '">
		<input type="hidden" id="MID" name="MID" value="' . esc_attr($merchant) . '">
		<input type="hidden" id="ResNum" name="ResNum" value="' . esc_attr($payment) . '">
		<input type="hidden" id="RedirectURL" name="RedirectURL" value="' . esc_attr($callBackUrl) . '">
		<div class="payment-mess">
                    ' . __('Transitioning to a payment gateway', 'edd-saman-bank') . '<br>
                    <div class="spinner">
                        <div class="rect1"></div>
                        <div class="rect2"></div>
                        <div class="rect3"></div>
                        <div class="rect4"></div>
                        <div class="rect5"></div>
                    </div>
                    <input type="submit" value="' . __('If the payment was not transferred to the port, click here.', 'edd-saman-bank') . '" id="submit">
                </div>
		</form>
		<script type="text/javascript">
		    var l = document.getElementById("submit");
                window.setTimeout(function () {
                    l.click();
                }, 3000);
            </script>
            ';
        exit;
    } else {
        edd_send_back_to_checkout('?payment-mode=' . $purchase_data['post_data']['edd-gateway']);
    }
}

add_action('edd_gateway_saman-bank', 'saman_bank_process_payment_edd');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

function saman_bank_verify_edd()
{
    global $edd_options, $output, $amount, $res;
    if (isset($_GET['order']) and $_GET['order'] == 'saman') {
        if (!$_POST['ResNum'] OR !$_POST['RefNum'] OR !$_POST['State']) {
            $output['status'] = 0;
        } else {
            $ResNum = sanitize_text_field($_POST['ResNum']);
            $RefNum = sanitize_text_field($_POST['RefNum']);
            $State = sanitize_text_field($_POST['State']);

            if (isset($RefNum) & check_exis_transaction_saman_edd($RefNum) == 0) {
                if (!class_exists('nusoap_client')) {
                    require_once(plugin_dir_path(edd_saman_bank_path) . "/inc/lib/nusoap.php");
                }
                $merchantID = trim($edd_options['merchant-saman-bank']);
                $password = $edd_options['password-saman-bank'];
                $soapclient = new nusoap_client('https://sep.shaparak.ir/payments/referencepayment1.asmx?WSDL', 'wsdl');
                $soapProxy = $soapclient->getProxy();
                $amount = $soapProxy->VerifyTransaction($RefNum, $merchantID);
                if ($amount > 0 & $State == 'OK') {
                    if ($amount == $_SESSION['saman_payment']) {
                        unset($_SESSION['saman_payment']);
                        edd_update_payment_status($ResNum, 'publish');
                        add_post_meta($ResNum, 'ref-num-saman-bank', $RefNum, false);
                        edd_send_to_success_page();
                    } else {
                        $res = $soapProxy->ReverseTransaction($RefNum, $merchantID, $password, $amount);
                        $output['status'] = 0;
                    }
                } else {
                    $output['status'] = 0;
                }
            } else {
                if (check_exis_transaction_saman_edd($RefNum) != 0) {
                    $res = '-19';
                }
                $output['status'] = 0;
            }
        }
        if ($output['status'] == 0) {
            unset($_SESSION['saman_payment_error_cod']);
            $_SESSION['saman_payment_error_cod'] = $res;
            edd_update_payment_status(sanitize_text_field($_POST['ResNum']), 'failed');
            $failed_page = get_permalink($edd_options['failure_page']);
            wp_redirect($failed_page);
            exit;
        }
    }
}

add_action('init', 'saman_bank_verify_edd');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// define the edd_is_failure_page callback
function edd_saman_bank_echo($content)
{
    global $edd_options;
    if (is_page($edd_options['failure_page']) & isset($_SESSION['saman_payment_error_cod'])) {
        $content .= '
                       <style>
                           .payment-mess-error {
                                margin: 50px;
                                text-align: center;
                                padding: 10px;
                                border: 1px solid #cdcdcd;
                                direction: rtl;
                                color: red;
                                font-size: 19px;
                                background-color: #fff8c9;
                            }
                        </style>
                    <div class="payment-mess-error">' . edd_saman_bank_error($_SESSION['saman_payment_error_cod']) . '</div>';
        unset($_SESSION['saman_payment_error_cod']);


    }
    return $content;
}

add_filter('the_content', 'edd_saman_bank_echo');

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

// add Saman bank payment gateway for edd
function saman_bank_add_payment_edd($gateways)
{
    $gateways['saman-bank'] = array('admin_label' => __('Saman Bank Gateway', 'edd-saman-bank'), 'checkout_label' => __('Pay with saman Bank gateway', 'edd-saman-bank'));
    return $gateways;
}

add_filter('edd_payment_gateways', 'saman_bank_add_payment_edd');

//----------------------------------------------------------------------------------------------------------------

function check_exis_transaction_saman_edd($cod)
{
    global $wpdb;
    $c = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->postmeta . " WHERE meta_key = 'ref-num-saman-bank' AND meta_value = '" . $cod . "'");
    return $c;

}