<?php
$datetime=date_default_timezone_set("Asia/Kolkata");
$dt = date('Y-m-d H:i:s');
define('DATETIME', $dt);

/************************* All function below here ***************/
function test()
{
    echo "helper test";
}


/************************* Payment Gateways functions ***************/

require (getcwd().'/public/stripe/Stripe.php');


/********** Creadetial define here *****************/
    $params = array(
    "testmode"   => "on",
    "private_live_key" => "pk_live_xxxxxxxxxxxxxxxxxxxxx",//sk_live_xxxxxxxxxxxxxxxxxxxxx
    "public_live_key"  => "pk_live_xxxxxxxxxxxxxxxxxxxxx",//pk_live_xxxxxxxxxxxxxxxxxxxxx
    "private_test_key" => "sk_test_qaZiHi8sYrSA8Bg26Oim9Vx9",
    "public_test_key"  => "pk_test_NLgUesdX4gq4fhma2Ed8JwXA"
    );

    if ($params['testmode'] == "on") 
    {
        Stripe::setApiKey($params['private_test_key']);
        $pubkey = $params['public_test_key'];
    } 
    else 
    {
        Stripe::setApiKey($params['private_live_key']);
        $pubkey = $params['public_live_key'];
    }
    Define("pubkey",$pubkey);
    function MerchantConnectVerify($merchant_stripe_verify_code)
    {
        
        $pubkey=pubkey;
        $ch = curl_init();
        $curlConfig = array(
        CURLOPT_URL            => "https://connect.stripe.com/oauth/token",
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => array(
            'client_secret' => 'sk_test_qaZiHi8sYrSA8Bg26Oim9Vx9',
            'code' => $merchant_stripe_verify_code,
            'grant_type' =>'authorization_code'
        )
    );
    curl_setopt_array($ch, $curlConfig);
    $result = curl_exec($ch);
    curl_close($ch);
    return ($result);
    } // end of function MerchantConnectVerify


    function chargeuser($paytoken,$amount,$order_ref)
    {
        $amount_cents = $amount*100;
        $pubkey=pubkey;
        try{
            $charge = Stripe_Charge::create([
                'amount' => $amount_cents,
                'currency' => 'usd',
                'description' => 'Order id'.$order_ref,
                'source' => $paytoken,
            ]);
            $data = array();
            $data =  array("chargeid"=>$charge->id, "transactionid"=>$charge->balance_transaction);

            return $data;
        }
        catch(Stripe_CardError $e) {
           return $error1 = $e->getMessage();
          } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
           return $error2 = $e->getMessage();
          } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
           return  $error3 = $e->getMessage();
          } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            return $error4 = $e->getMessage();
          } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return $error5 = $e->getMessage();
          } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return $error6 = $e->getMessage();
          }

    }


