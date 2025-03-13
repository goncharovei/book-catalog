<?php

namespace App\Front\Publisher\Http\Controllers\Auth;

use App\Common\Models\Publisher;
use App\Front\Publisher\Http\Controllers\Controller;
use App\Front\Publisher\Jobs\PublisherTokenCreateJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     */
    use AuthRedirect;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'throttle:10,1', 'anti-spam']);
    }

    public function showRegistrationForm(): View
    {
        return view('publisher.auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = null;
        DB::transaction(function () use ($request, &$user)
        {
            event(new Registered($user = $this->create($request->all())));
            $this->guard()->login($user);
        });

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:publishers'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Publisher
     */
    protected function create(array $data): Publisher
    {
        return Publisher::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //
    }
}
