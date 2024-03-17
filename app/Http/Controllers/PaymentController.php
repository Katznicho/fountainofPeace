<?php

namespace App\Http\Controllers;

use App\Mail\DonationNotification;
use App\Models\Baby;
use App\Models\Children;
use App\Models\Customer;
use App\Models\Sponsor;
use App\Models\Transaction;
use App\Models\User;
use App\Payments\Pesapal;
use App\Traits\MessageTrait;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use MessageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("payments.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function finishPayment(Request $request)
    {
        try {
            //code...
            $orderTrackingId = $request->input('OrderTrackingId');
            $reference = $request->input('OrderMerchantReference');

            Transaction::where("reference", $reference)->update([
                "order_tracking_id" => $orderTrackingId,

            ]);
            //get the actual transaction
            $transaction = Transaction::where("reference", $reference)->first();
            $customer = Sponsor::find($transaction->sponsor_id);
            $data = Pesapal::transactionStatus($orderTrackingId, $orderTrackingId);
            $payment_method = $data->message->payment_method;

            $name =  $customer->first_name . " " . $customer->last_name;
            $email = $customer->email;

            if ($data->message->payment_status_description == config("status.payment_status.completed")) {
                $message = "Hello {$name} your payment of {$transaction->amount} has been successfully completed.Thank you";
                $this->sendMessage($customer->phone_number, $message);
                //check if the transaction is already completed
                if ($transaction->status == config("status.payment_status.completed")) {
                    // Send donation email to existing user
                    if ($transaction->type == "RescueBaby") {
                        //update all babies to sponsored
                        Baby::update([
                            "is_sponsored" => 1
                        ]);
                    } else {
                        $child_id = $transaction->child_id;
                        //update child to sponsored
                        Children::where("id", $child_id)->update([
                            "is_sponsored" => 1
                        ]);
                    }
                    Mail::to($email)->send(new DonationNotification("Donation Successful", $name, $transaction->amount, $transaction->status));
                    return redirect()->route('login');
                } else {

                    $transaction->update([
                        "status" => config("status.payment_status.completed"),
                        "payment_method" => $payment_method
                    ]);


                    return redirect()->route('home');
                }


                // $this->sendMessage($)

            } else {

                $transaction->update([
                    "status" => config("status.payment_status.failed"),
                    "payment_method" => $payment_method
                ]);
                Mail::to($email)->send(new DonationNotification("Donation Failed", $name, $transaction->amount, $transaction->status));

                return redirect()->route('login');
            }
        } catch (\Throwable $th) {

            Mail::to($email)->send(new DonationNotification("Donation Successful", $name, $transaction->amount, $transaction->status));

            return redirect()->route('login');
        }
    }

    public function registerIPN(Request $request)
    {
        try {
            //add validation for url is registered
            $request->validate([
                'url' => 'required|string'
            ]);


            return Pesapal::pesapalRegisterIPN($request->url);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function listIPNS(Request $request)
    {
        try {
            $data = Pesapal::listIPNS();
            return response()->json(['success' => true, 'message' => 'Success', 'response' => $data]);
        } catch (\Throwable $th) {

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function cancelPayment(Request $request)
    {
        try {
            $payment_reference =  $request->input("payment_reference");
            $transaction = Transaction::where("reference", $payment_reference)->first();
            Transaction::where("reference", $payment_reference)->update([
                "status" => config("status.payment_status.canceled")
            ]);
            $customer = Sponsor::find($transaction->sponsor_id);
            $name =  $customer->first_name . " " . $customer->last_name;
            $email = $customer->email;

            Mail::to($email)->send(new DonationNotification("Donation Successful", $name, $transaction->amount, $transaction->status));
            return view("home");
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return view("home");
        }
    }

    public function completePayment(Request $request)
    {
        try {
            Log::info("===========The call back was called===================================");
            Log::info("Received Response Page");
            Log::info("============The call back was called==================================");
            // Get the parameters from the URL
            $orderTrackingId = $request->input('OrderTrackingId');
            $orderMerchantReference = $request->input('OrderMerchantReference');

            $orderNotificationType = $request->input('OrderNotificationType');
            Transaction::where("reference", $orderMerchantReference)->update([
                "order_tracking_id" => $orderTrackingId,
                "orderNotificationType" => $orderNotificationType
            ]);

            $transaction = Transaction::where("reference", $orderMerchantReference)->first();
            if (!$transaction) {
                return response()->json([
                    "status" => 500,
                    "message" => "Transaction not found"
                ]);
            }
            $customer = Sponsor::find($transaction->sponsor_id);
            $data = Pesapal::transactionStatus($orderTrackingId, $orderMerchantReference);
            // return $data;
            $payment_method = $data->message->payment_method;
            $name =  $customer->first_name . " " . $customer->last_name;
            $email = $customer->email;

            Log::info("=========================================call back executed=============================================================================================================");
            Log::info("Received Response Page - Order Tracking ID: $orderTrackingId, Merchant Reference: $orderMerchantReference, Notification Type: $orderNotificationType");
            Log::info("==========================================call back executed============================================================================================================");

            if ($data->message->payment_status_description == config("status.payment_status.completed")) {
                $message = "Hello {$name} your payment of {$transaction->amount} has been successfully completed.Thank you";
                $this->sendMessage($customer->phone_number, $message);

                //check if the transaction is already completed
                if ($transaction->status == config("status.payment_status.completed")) {
                    if ($transaction->type == "RescueBaby") {
                        //update all babies to sponsored
                        Baby::update([
                            "is_sponsored" => 1
                        ]);
                    } else {
                        $child_id = $transaction->child_id;
                        //update child to sponsored
                        Children::where("id", $child_id)->update([
                            "is_sponsored" => 1
                        ]);
                    }
                    Mail::to($email)->send(new DonationNotification("Donation Successful", $name, $transaction->amount, $transaction->status));
                    return response()->json([
                        "status" => 200,
                        "message" => "Transaction already completed"
                    ]);
                } else {

                    $transaction->update([
                        "status" => "completed",
                        "payment_method" => $payment_method
                    ]);
                    //update customer balance
                    $customer->account_balance += $transaction->amount;
                    $customer->save();
                    return response()->json([
                        "status" => 200,
                        "message" => "Transaction completed"
                    ]);
                }
            } else {
                Mail::to($email)->send(new DonationNotification("Donation Failed", $name, $transaction->amount, $transaction->status));
                return response()->json([
                    "status" => 500,
                    "message" => "Transaction failed"
                ]);
            }
        } catch (\Throwable $th) {

            Log::info("===========callback url==================================");
            Log::error($th->getMessage());
            Log::info("============call back url=================================");
            return response()->json(['success' => false, 'message' => $th->getMessage(), "status" => 500]);
        }
    }

    public function processOrder(Request $request)
    {
        try {
            //$amount, $phone, $callback
            $request->validate([
                'amount' => 'required|numeric',
                'phone_number' => 'required|string',
                'callback' => 'required|string',
                'payment_phone_number' => 'required|string',
                'cancel_url' => 'required|string'
            ]);
            $getCustomer =  User::where('phone', $request->phone_number)->first();
            if (!$getCustomer) {
                return response()->json(['success' => false, 'message' => 'Customer not found']);
            }
            $amount = $request->input('amount');
            $phone = $request->input('phone_number');
            $callback = $request->input('callback');
            $reference = Str::uuid();
            $description = $request->input('description') ?? "Depositing on my wallet";
            $first_name = $getCustomer->name;
            $last_name = $getCustomer->last_name;
            $email =  $getCustomer->email;
            $customer_id = $getCustomer->id;
            $cancel_url = $request->input('cancel_url');
            //add the payment reference to cancel url
            $cancel_url = $cancel_url . "?payment_reference=" . $reference;
            // return $amount;
            $data = Pesapal::orderProcess($reference, $amount, $phone, $description, $callback, $first_name, $last_name, $email, $customer_id, $cancel_url);
            return response()->json(['success' => true, 'message' => 'Order processed successfully', 'response' => $data]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function checkTransactionStatus(Request $request)
    {

        try {
            //code...
            $request->validate([
                'orderTrackingId' => 'required|string',
                'merchantReference' => 'required|string'
            ]);
            $orderTrackingId = $request->input('orderTrackingId');
            $merchantReference = $request->input('merchantReference');
            $data = Pesapal::transactionStatus($orderTrackingId, $merchantReference);

            return response()->json(['success' => true, 'message' => 'Success', 'response' => $data->message->payment_status_description]);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function testSendingMessages(Request $request)
    {
        try {
            //code...
            $message = "Testing sending messages";
            $phoneNumber = "+256759983853";
            $res = $this->sendMessage($phoneNumber, $message);

            return response()->json(['success' => true, 'message' => 'Success', 'response' => $res]);

            return "success";
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
