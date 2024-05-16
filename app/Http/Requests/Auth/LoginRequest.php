<?php

namespace App\Http\Requests\Auth;

use App\Models\Branch;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ci' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('ci', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'ci' => trans('auth.failed'),
            ]);
        }
        // Obtén el usuario autenticado
        $user = Auth::user();
        $rol = Auth::user()->roles->first()->name ?? 'default';
        $branch = Branch::where('user_id', $user->id)->first();

        // Verifica el estado del usuario
        if ($user && $user->state == false) {
            Auth::logout();  // Cierra la sesión si el estado es falso
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'ci' => trans('auth.not_allowed'),
            ]);
        }   

        // Verifica si el usuario tiene una sucursal asignada
        if ($rol !='Administrador') {           
            if ($branch == null) {
                Auth::logout();  // Cierra la sesión si el estado es falso
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'ci' => trans('auth.not_branch'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
