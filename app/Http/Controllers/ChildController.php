<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Mail\AccountCreation;
use App\Models\Sponsor;
use App\Models\Transaction;
use App\Models\User;
use App\Payments\Pesapal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $children = Children::where('is_sponsored', false)->paginate(10);
        // Pass the data to the view
        return view('child.child', compact('children'));
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
        // dd($request->all());
        try {
            $validatedData = [];
            $is_individual = $request->input('is_individual');

            if ($is_individual == "is_individual") {
                $validatedData = $request->validate([
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'phone_number' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                ]);
            } else {
                $validatedData = $request->validate([
                    'organization_name' => 'required|string|max:255',
                    'organization_type' => 'required|string|max:255',
                    'primary_contact_first_name' => 'required|string|max:255',
                    'primary_contact_last_name' => 'required|string|max:255',
                    'primary_contact_email' => 'required|email|max:255',
                    'primary_contact_phone' => 'required|string|max:255',
                ]);
            }

            $sponsorData = [
                'first_name' => $is_individual == "is_individual" ? $request->input('first_name') : $request->input('primary_contact_first_name'),
                'last_name' => $is_individual == "is_individual" ? $request->input('last_name') : $request->input('primary_contact_last_name'),
                'phone_number' => $is_individual == "is_individual" ? $request->input('phone_number') : $request->input('primary_contact_phone'),
                'address' => $request->input('address', null),
                'city' => $request->input('city', null),
                'state' => $request->input('state', null),
                'country' => $request->input('country', null),
                'postal_code' => $request->input('postal_code', null),
                'sponsor_identifier' => Str::random(10),
                'type' => $is_individual == "is_individual" ? "individual" : "organization",
                'organization_name' => $request->input('organization_name', null),
                'organization_type' => $request->input('organization_type', null),
            ];

            // Check if the sponsor with the provided email already exists
            $sponsor = Sponsor::where('email', $request->input('email'))->first();
            if (!$sponsor) {
                $sponsor = Sponsor::create(['email' => $request->input('email')], $sponsorData);
            }

            // Check if the user with the provided email already exists
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $password = Str::random(8);
                $user = User::create([
                    'email' => $request->input('email'),
                    'name' => $sponsorData['first_name'] . ' ' . $sponsorData['last_name'],
                    'password' => $password
                ]);

                Mail::to($request->input('email'))->send(new AccountCreation($sponsorData['first_name'], $password));
            } else {
            }

            $status = config("status.payment_status.pending");
            $customer_email = $request->input('email');
            $customer_id = $sponsor->id;
            $phone_number = $is_individual == "is_individual" ? $request->input('phone_number') : $request->input('primary_contact_phone');
            $reference = Str::uuid();
            $amount = 500;
            $description = "Payment for rescue baby";

            Transaction::create([
                'reference' => $reference,
                'amount' => $amount,
                'sponsor_id' => $sponsor->id,
                'status' => $status,
                'description' => $description,
                'phone_number' => $phone_number,
                'payment_mode' => "pesapal",
                'OrderNotificationType' => "pesapal",
                'order_tracking_id' => $reference,
                'type' => "SponsorChild",
                'payment_method' => "Pesapal",
                'user_id' => $user->id,
                'child_id' => $request->child_id
            ]);

            $callback_url = "https://dummy.fountainofpeace.org.ug/finishPayment";
            $cancel_url = "https://dummy.fountainofpeace.org.ug/cancelPayment";

            $res = Pesapal::orderProcess($reference, $amount, $phone_number, $description, $callback_url, $sponsorData['first_name'], $sponsorData['last_name'], $customer_email, $customer_id, $cancel_url);

            if ($res->success) {
                return redirect($res->message->redirect_url);
            } else {
                return redirect()->back()->with('error', 'Payment Failed please try again');
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $child = Children::findOrFail($id);
        return view('contact', ['child' => $child]);
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
}
