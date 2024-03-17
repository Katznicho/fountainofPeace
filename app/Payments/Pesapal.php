<?php

namespace App\Payments;

use App\Models\Transaction;
use Illuminate\Support\Facades\Config;

class Pesapal
{
    protected static $pesapalBaseUrl = "https://pay.pesapal.com/v3";
    protected static $body;
    protected static $headers;
    protected static $response;
    protected static $options;
    protected static $manager;

    protected static $consumerKey;
    protected static $consumerSecret;

    public static function loadConfig()
    {
        self::$consumerKey = Config::get('services.pesapal.consumer_key');
        self::$consumerSecret = Config::get('services.pesapal.consumer_secret');
    }

    public static function pesapalBaseUrl()
    {
        try {
            //code...
            return self::$pesapalBaseUrl;
        } catch (\Throwable $th) {
            //throw $th;

            return $th->getMessage();
        }
    }


    public static function pesapalAuth()
    {

        try {
            //code...
            self::loadConfig();
            $url = self::$pesapalBaseUrl . "/api/Auth/RequestToken";
            $headers = array("Content-Type" => "application/json", 'accept' => 'application/json');
            $body = json_encode(array(
                'consumer_key' => self::$consumerKey,
                'consumer_secret' => self::$consumerSecret,
            ));

            $data = Curl::PostToken($url, $headers, $body);
            $data = json_decode(json_encode($data));

            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    /**
     * Registers an IPN (Instant Payment Notification) URL with Pesapal.
     *
     * @param string $ipnUrl The URL to register for IPN notifications.
     * @throws \Throwable If an error occurs during the registration process.
     * @return mixed The response from the registration request.
     */
    public static function pesapalRegisterIPN(string $ipnUrl)
    {
        //return $url;
        try {

            //code...
            $token = self::pesapalAuth();

            if (!$token->success) {
                throw new \Exception("Failed to obtain Token");
            }

            $url = self::$pesapalBaseUrl . "/api/URLSetup/RegisterIPN";
            $headers = array("Content-Type" => "application/json", 'accept' => 'application/json', 'Authorization' => 'Bearer ' . $token->message->token);

            $body = json_encode(array(
                "url" => $ipnUrl,
                "ipn_notification_type" => 'POST',
            ));

            $data = Curl::Post($url, $headers, $body);
            $data = json_decode(json_encode($data));
            return $data;
        } catch (\Throwable $th) {
            //throw $th;

            return $th->getMessage();
        }
        //18213
    }

    /**
     * Retrieves the list of IPNs.
     *
     * @throws \Throwable if an error occurs during the process.
     * @return mixed the list of IPNs.
     */
    public static function listIPNS()
    {
        try {
            //code...
            $token = self::pesapalAuth();

            if (!$token->success) {
                throw new \Exception("Failed to obtain Token");
            }

            $url = self::$pesapalBaseUrl . "/api/URLSetup/GetIpnList";
            $headers = array("Content-Type" => "application/json", 'accept' => 'application/json', 'Authorization' => 'Bearer ' . $token->message->token);

            $data = Curl::Get($url, $headers);
            $data = json_decode(json_encode($data));

            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    /**
     * Processes an order.
     *
     * @param mixed $reference The order reference.
     * @param mixed $amount The order amount.
     * @param mixed $phone The phone number of the customer.
     * @param mixed $description The order description.
     * @param mixed $callback The callback URL.
     * @param mixed $customer_names The customer's names.
     * @param mixed $email The customer's email.
     * @param mixed $customer_id The customer ID.
     * @param mixed $cancel_url The cancel URL.
     * @throws \Throwable Exception if an error occurs during processing.
     * @return mixed The processed order data.
     */
    public static function orderProcess($reference, $amount, $phone, $description, $callback, $first_name, $last_name, $email, $customer_id, $cancel_url)
    {
        try {
            //code...
            $token = self::pesapalAuth();

            $payload = json_encode(array(
                'id' => $reference,
                'currency' => 'UGX',
                'amount' => $amount,
                'description' => $description,
                'redirect_mode' => 'TOP_WINDOW',
                'callback_url' => $callback,
                'call_back_url' => $cancel_url,
                'notification_id' => "88df68a5-aa0f-41b4-badf-dd7e551505d9",
                'billing_address' => array(
                    'phone_number' => $phone,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email

                )
            ));

            if (!$token->success) {
                throw new \Exception("Failed to obtain Token");
            }
            $url = self::$pesapalBaseUrl . "/api/Transactions/SubmitOrderRequest";
            $headers = array("Content-Type" => "application/json", 'accept' => 'application/json', 'Authorization' => 'Bearer ' . $token->message->token);
            $data = Curl::Post($url, $headers, $payload);


            $data = json_decode(json_encode($data));

            return $data;
        } catch (\Throwable $th) {

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public static function transactionStatus(string $oderTrackingId, string $oderMerchantReference)
    {

        try {
            //code...
            $transId = $oderTrackingId;
            // $merchant = $oderMerchantReference;
            if (!isset($transId) || empty($transId)) {

                throw new \Exception("Missing Transaction ID");
            }

            $token = self::pesapalAuth();
            if (!$token->success) {
                return response()->json(['success' => false, 'message' => 'Failed to obtain Token', 'response' => $token]);
            }

            $url = self::$pesapalBaseUrl . "/api/Transactions/GetTransactionStatus?orderTrackingId={$transId}";
            $headers = array("Content-Type" => "application/json", 'accept' => 'application/json', 'Authorization' => 'Bearer ' . $token->message->token);
            $data = Curl::Get($url, $headers);

            $data = json_decode(json_encode($data));

            return $data;
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
