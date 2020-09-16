<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($request->phone_number, "sms");
    }

    protected function verify(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone_number']));
        if ($verification->valid) {
            $user = User::first();
            $user->update(['phone_verified_at' => now(), 'phone_number' => $data['phone_number']]);
            return response(['msg' => $data['phone_number']." validated successfully"]);
            // $user = tap(User::where('phone_number', $data['phone_number']))->update(['isVerified' => true]);
            /* Authenticate user */
            // Auth::login($user->first());
            // return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        // return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
        return response(['msg' => $data['phone_number'] . " validation failed"]);
    }
}
