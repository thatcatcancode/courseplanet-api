<?php
require_once('../vendor/autoload.php');

$stripe = array(
  "secret_key"      => "sk_test_mA9xV23OSxKsGht69CZqTIjT",
  "publishable_key" => "pk_test_rXsgC4BbtscXpcomXlg7YYvo"
);

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
