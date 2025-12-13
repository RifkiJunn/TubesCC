<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Redirect user to Google OAuth provider.
     */
    public function redirect(): RedirectResponse
    {
        try {
            // Ensure we have the correct redirect URL
            $redirectUrl = url('/auth/google/callback');
            
            // Check if credentials are set
            if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
                return redirect()->route('login')
                    ->with('error', 'Google OAuth credentials belum dikonfigurasi. Silakan hubungi administrator.');
            }
            
            // Configure HTTP client to disable SSL verification for development
            $httpClient = null;
            if (config('app.env') === 'local' || config('app.debug')) {
                $httpClient = new \GuzzleHttp\Client([
                    'verify' => false, // Disable SSL verification for development
                ]);
            }
            
            $socialite = Socialite::driver('google')
                ->redirectUrl($redirectUrl);
            
            if ($httpClient) {
                $socialite->setHttpClient($httpClient);
            }
            
            return $socialite->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal menginisialisasi Google login: ' . $e->getMessage());
        }
    }

    /**
     * Handle Google OAuth callback.
     */
    public function callback(): RedirectResponse
    {
        try {
            // Configure HTTP client to disable SSL verification for development
            $httpClient = null;
            if (config('app.env') === 'local' || config('app.debug')) {
                $httpClient = new \GuzzleHttp\Client([
                    'verify' => false, // Disable SSL verification for development
                ]);
            }
            
            $socialite = Socialite::driver('google');
            
            if ($httpClient) {
                $socialite->setHttpClient($httpClient);
            }
            
            $googleUser = $socialite->user();

            // Check if user exists with this Google ID
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Check if user exists with same email
                $user = User::where('email', $googleUser->getEmail())->first();
                
                if ($user) {
                    // Link Google account to existing user
                    $user->google_id = $googleUser->getId();
                    $user->avatar = $googleUser->getAvatar();
                    if (!$user->email_verified_at) {
                        $user->email_verified_at = now();
                    }
                    $user->save();
                }
            }

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => null, // No password for Google users
                ]);
            }

            Auth::login($user, true);

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Google OAuth callback error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            // Show detailed error in development, generic message in production
            $errorMessage = config('app.debug') 
                ? 'Gagal login dengan Google: ' . $e->getMessage() 
                : 'Gagal login dengan Google. Silakan coba lagi atau gunakan email/password.';
            
            return redirect()->route('login')
                ->with('error', $errorMessage);
        }
    }
}
