@include('...header')
<?php
session_start();
$_SESSION['amount']=$posted['amount'];
$_SESSION['first_name']=$posted['firstname'];
$_SESSION['item_name']=$posted['amount'];
$_SESSION['invoice']=$posted['invoice'];

if(isset($_POST['paypal']))
{
    $payment_mode = Setting::param('payment','mode')['value'];
    $transaction_mode = Setting::param('payment','type')['value'];
    $gateway_params = PaymentGatewaySetting::select('key','value')->where('gateway_id','=',$payment_mode)->get();
    $settings = [];
    foreach($gateway_params as $params){
        $settings[$params->key] = $params->value;
    }
    $paypal_location  = ($transaction_mode == 'LIVE') ? $settings['paypal_live_url'] : $settings['paypal_sandbox_url'];
    $query = array();
    $query['cmd'] = '_xclick';
    $query['business'] = $settings['business_email'];
    $query['first_name'] = $_SESSION['first_name'];
    $query['email'] = $_POST['email'];
    $query['item_name'] = $_SESSION['invoice'];
    $query['quantity'] = 1;
    $query['amount'] = $_SESSION['amount'];
    $query['currency_code'] = $settings['paypal_currency'];
    $transaction_id=abs(crc32($_SESSION['invoice']));
    $query['txn_id'] = $transaction_id;

    $query['cancel_return'] = URL."/medicine/paypal-fail?status=cancel";
    $query['return'] = URL."/medicine/paypal-success?status=success&pay_id=" . $_SESSION['invoice']."&transaction_id=".$transaction_id;
    // Prepare query string
    $query_string = http_build_query($query);
    header('Location: '.$paypal_location. $query_string);
    exit;
}
?>
    <div class="contact-container" style="min-height: 760px">
        <div class="prescription-inner container">
             <h2>Payment Details</h2>
                <form action="" method="post" name="paypalForm">
                  <table class="table">
                    <tr>
                      <td>Amount: </td>
                      <td><input type="text" name="amount1" value="<?php echo (empty($posted['amount'])) ? '' : Setting::currencyFormat($posted['amount']) ?>" class="form-control" readonly />
                     <input type="hidden" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" class="form-control"/></td>
                      <td>First Name: </td>
                      <td><input type="text" name="first_name" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" class="form-control"/></td>
                    </tr>
                    <tr>
                      <td>Email: </td>
                      <td><input type="text" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" class="form-control"/></td>
                      <td>Phone: </td>
                      <td><input type="text" name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" class="form-control"/>
                      </td>
                    </tr>
                    <tr>
                      <td>Product Info: </td>
                      <td colspan="3"><textarea readonly="readonly" name="productinfo1" class="form-control"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea>
                      <textarea style="display: none" name="productinfo" class="form-control"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea>
                      </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="3"><input type="submit" value="Pay Now" name="paypal" class="btn-success" style="height: 40px; width: 100px"/></td>
                      </tr>
                  </table>
                </form>
        </div>
        <!-- prescription-cont -->
    </div>
    <footer>
        <div class="container innerBtm">
@include('...footer')