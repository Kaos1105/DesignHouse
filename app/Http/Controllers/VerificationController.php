<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('signed')->only('verify');
        $this->middleware('throttle: 6,1')->only('resend');
    }

    public function verify(Request $request, User $user): \Illuminate\Http\JsonResponse
    {
        // check if the url is a valid signed url
        if (!URL::hasValidSignature($request)) {
            return response()->json([
                "errors" => [
                    "message" => "Invalid verification link"
                ]
            ], 422);
        }

        // Check if user has already verified account
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "errors" => [
                    "message" => "Email address already verified"
                ]
            ], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([
            "message" => "Email address successfully verified"
        ], 201);
    }

    public function resend(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return response()->json([
                "errors" => [
                    "message" => "No user could be found with this email address"
                ]
            ], 422);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "errors" => [
                    "message" => "Email address already verified"
                ]
            ], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'status' => "Verification link resent"
        ], 422);
    }
}