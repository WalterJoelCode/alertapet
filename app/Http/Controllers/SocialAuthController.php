<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    private const PROVIDERS = ['google', 'facebook', 'microsoft'];

    public function redirect(Request $request, string $provider): RedirectResponse
    {
        $this->ensureSupportedProvider($provider);

        $credentials = config("services.{$provider}");

        if (blank($credentials['client_id'] ?? null) || blank($credentials['client_secret'] ?? null)) {
            return to_route('login')->withErrors([
                'social' => 'El acceso con '.Str::title($provider).' estará disponible cuando se completen sus credenciales OAuth.',
            ]);
        }

        $state = Str::random(40);
        $request->session()->put("social_auth_state_{$provider}", $state);

        return redirect()->away($this->authorizationUrl($provider, $state));
    }

    public function callback(Request $request, string $provider): RedirectResponse
    {
        $this->ensureSupportedProvider($provider);

        $expectedState = $request->session()->pull("social_auth_state_{$provider}");

        if (! is_string($expectedState) || ! hash_equals($expectedState, (string) $request->query('state'))) {
            return $this->failedLogin('No pudimos verificar la solicitud de acceso. Inténtalo de nuevo.');
        }

        if ($request->filled('error') || ! $request->filled('code')) {
            return $this->failedLogin('El acceso con la red social fue cancelado o no se pudo completar.');
        }

        try {
            $profile = $this->profile($provider, $request->string('code')->toString());
        } catch (RequestException) {
            return $this->failedLogin('No pudimos completar el acceso con la red social. Inténtalo de nuevo.');
        }

        $email = $profile['email'] ?? null;

        if (! is_string($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->failedLogin('La red social no compartió un correo electrónico válido para crear tu cuenta.');
        }

        $user = User::firstOrCreate(
            ['email' => Str::lower($email)],
            [
                'name' => $profile['name'] ?? Str::before($email, '@'),
                'password' => Hash::make(Str::random(40)),
                'role_id' => Role::general()->id,
            ],
        );

        Auth::login($user, true);
        $request->session()->regenerate();

        return to_route('inicio');
    }

    private function authorizationUrl(string $provider, string $state): string
    {
        $credentials = config("services.{$provider}");

        return match ($provider) {
            'google' => 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
                'client_id' => $credentials['client_id'], 'redirect_uri' => route('social.callback', $provider),
                'response_type' => 'code', 'scope' => 'openid email profile', 'state' => $state, 'prompt' => 'select_account',
            ]),
            'facebook' => 'https://www.facebook.com/v20.0/dialog/oauth?'.http_build_query([
                'client_id' => $credentials['client_id'], 'redirect_uri' => route('social.callback', $provider),
                'response_type' => 'code', 'scope' => 'email public_profile', 'state' => $state,
            ]),
            'microsoft' => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize?'.http_build_query([
                'client_id' => $credentials['client_id'], 'redirect_uri' => route('social.callback', $provider),
                'response_type' => 'code', 'scope' => 'openid profile email User.Read', 'state' => $state,
            ]),
        };
    }

    /** @return array{name?: string, email?: string} */
    private function profile(string $provider, string $code): array
    {
        $credentials = config("services.{$provider}");
        $tokenUrl = match ($provider) {
            'google' => 'https://oauth2.googleapis.com/token',
            'facebook' => 'https://graph.facebook.com/v20.0/oauth/access_token',
            'microsoft' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
        };

        $token = Http::asForm()->acceptJson()->post($tokenUrl, [
            'client_id' => $credentials['client_id'],
            'client_secret' => $credentials['client_secret'],
            'redirect_uri' => route('social.callback', $provider),
            'grant_type' => 'authorization_code',
            'code' => $code,
        ])->throw()->json('access_token');

        $profile = match ($provider) {
            'google' => Http::acceptJson()->withToken($token)->get('https://openidconnect.googleapis.com/v1/userinfo')->throw()->json(),
            'facebook' => Http::acceptJson()->get('https://graph.facebook.com/me', ['fields' => 'name,email', 'access_token' => $token])->throw()->json(),
            'microsoft' => Http::acceptJson()->withToken($token)->get('https://graph.microsoft.com/v1.0/me')->throw()->json(),
        };

        return [
            'name' => $profile['name'] ?? null,
            'email' => $profile['email'] ?? $profile['mail'] ?? $profile['userPrincipalName'] ?? null,
        ];
    }

    private function ensureSupportedProvider(string $provider): void
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);
    }

    private function failedLogin(string $message): RedirectResponse
    {
        return to_route('login')->withErrors(['social' => $message]);
    }
}
