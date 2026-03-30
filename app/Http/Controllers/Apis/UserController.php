<?php

namespace App\Http\Controllers\Apis;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Set locale for API responses
    private function setLocale($req)
    {
        $locale = $req->header('lang', 'en'); // default English
        app()->setLocale($locale);
    }

    public function api_user_login(Request $req)
    {
        $this->setLocale($req);

        $validator = Validator::make($req->all(), [
            'login_email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('messages.validation_failed'), 422, $validator->errors());
        }

        $user = Customer::where('email', $req->login_email)->first();
        if (!$user) {
            return ApiResponse::error(__('messages.user_not_found'));
        }

        try {
            $domain = substr(strrchr($req->login_email, "@"), 1);
            if (!checkdnsrr($domain, 'MX')) {
                return ApiResponse::error(__('messages.email_invalid'));
            }

            $otp = random_int(1000, 9999);
            $user->otp = $otp;
            $user->save();

            Mail::send('emails.mail', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('OTP for Account Verification');
            });

            return ApiResponse::success(__('messages.otp_sent'), ['email' => $user->email]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('messages.error_sending_email'), 500);
        }
    }

    public function app_verify_otp(Request $req)
    {
        $this->setLocale($req);

        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'otp'   => 'required|min:4|max:4'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('messages.validation_failed'), 422, $validator->errors());
        }

        $user = Customer::where('email', $req->email)->first();
        if (!$user) {
            return ApiResponse::error(__('messages.user_not_found'));
        }

        if ($user->otp != $req->otp) {
            return ApiResponse::error(__('messages.invalid_otp'));
        }

        $token = $user->createToken('app_auth')->plainTextToken;

        return ApiResponse::success(__('messages.login_success'), [
            "token_type"   => "Bearer",
            "access_token" => $token,
            "user"         => $user
        ]);
    }

    public function api_register(Request $req)
    {
        $this->setLocale($req);

        $validator = Validator::make($req->all(), [
            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('messages.validation_failed'), 422, $validator->errors());
        }

        $email = strtolower($req->email);

        if (Customer::where('email', $email)->exists()) {
            return ApiResponse::error(__('messages.email_exists'));
        }

        try {
            $otp = random_int(1000, 9999);

            $user = Customer::create([
                'name'  => $req->name,
                'email' => $email,
                'phone' => $req->phone,
                'otp'   => $otp,
            ]);

            Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Account Opening');
            });

            return ApiResponse::success(__('messages.register_success'), [
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ApiResponse::error(__('messages.register_failed'), 500);
        }
    }

    public function api_user_update(Request $req)
    {
        $this->setLocale($req);

        $validator = Validator::make($req->all(), [
            'id'    => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(__('messages.validation_failed'), 422, $validator->errors());
        }

        $update = Customer::where('id', $req->id)->update($req->all());

        if (!$update) {
            return ApiResponse::error(__('messages.no_changes'));
        }

        return ApiResponse::success(__('messages.update_success'));
    }

    public function app_logout(Request $req)
    {
        $this->setLocale($req);

        $req->user()->currentAccessToken()->delete();

        return ApiResponse::success(__('messages.logout_success'));
    }

}
