<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function signInForm(): View
    {
        return view("frontend.auth.signin_form");
    }

    public function signIn(SignInRequest $request): RedirectResponse
    {
        $credentials = $request->only(["email", "password"]);
        $rememberMe = $request->get("remember-me", false);

        if (Auth::attempt($credentials, $rememberMe)) {
            return redirect("/");
        } else {
            return redirect()->back()->withErrors(
                [
                    "email" => "Lütfen epostanızı kontrol ediniz.",
                    "password" => "Lütfen şifrenizi kontrol ediniz.",
                ]);
        }
    }

    public function signUpForm(): View
    {
        return view("frontend.auth.signup_form");
    }

    public function signUp(SignUpRequest $request): RedirectResponse
    {
        $user = new User();
        $data = $this->prepare($request, $user->getFillable());
        $data["is_active"] = true;
        $user->fill($data);
        $user->save();

        return Redirect::to("/giris");
    }

    public function logOut() {
        Auth::logout();
        return redirect("/");
    }


}
