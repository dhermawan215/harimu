<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\User\UserInterface;
use App\Http\Controllers\Controller;
use App\Logs\HansLogging;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticateController extends Controller
{
    use HansLogging;
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(): View
    {
        return view('auth.login');
    }
    /**
     * method auth login process
     * @param Request $request
     */
    public function signIning(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->captureSystemLog(
                null,
                $request->email,
                'LOGIN',
                'Failed login to system',
                $request
            );
            throw ValidationException::withMessages([
                'email' => 'Please check your email and password.',
            ]);
        }

        if (! $request->user()->email_verified_at) {
            Auth::logout();

            $this->captureSystemLog(
                null,
                $request->email,
                'LOGIN',
                'Blocked login, email not verified',
                $request
            );

            return redirect()->route('verification.notice')
                ->with('email', $request->email)
                ->with('error', 'Email Anda belum diverifikasi. Cek email Anda atau kirim ulang tautan verifikasi di bawah.');
        }

        $request->session()->regenerate();

        $this->captureSystemLog(
            null,
            $request->email,
            'LOGIN',
            'Success login to system',
            $request
        );

        $redirectTo = $request->user()->role === 'admin'
            ? route('admin.dashboard')
            : route('dashboard');

        return redirect()->intended($redirectTo);
    }
    /**
     * method logout
     * @param Request $request
     */
    public function signOut(Request $request)
    {
        $user = Auth::user();
        $this->captureSystemLog(
            $user->id,
            $user->email,
            'LOGIN',
            'Success login to system',
            $request
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    /**
     * method register page
     * @return View
     */
    public function register(): View
    {
        return view('auth.register');
    }
    /**
     * method register process
     * @param Request $request
     * @return RedirectResponse
     */
    public function signUp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        $sent = $this->authService->createVerification($user);

        $this->captureSystemLog(
            $user->id,
            $user->email,
            'REGISTER',
            $sent ? 'Success register, verification email sent' : 'Success register, verification email failed',
            $request
        );

        return redirect()->route('verification.notice')
            ->with('email', $user->email)
            ->with(
                $sent ? 'success' : 'error',
                $sent
                    ? 'Registrasi berhasil. Kami telah mengirim tautan verifikasi ke email Anda.'
                    : 'Registrasi berhasil, tetapi email verifikasi gagal terkirim. Silakan kirim ulang di bawah.'
            );
    }
    /**
     * method forgot password page
     * @return View
     */
    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }
    /**
     * method send password reset link
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $this->authService->requestPasswordReset($validated['email'], (string) $request->ip());

        $this->captureSystemLog(
            null,
            $validated['email'],
            'FORGOT_PASSWORD',
            'Request password reset link',
            $request
        );

        return redirect()->route('password.request')
            ->with('success', 'Jika email terdaftar, tautan untuk mengatur ulang kata sandi telah dikirim.');
    }
    /**
     * method reset password page
     * @param string $token
     * @return View|RedirectResponse
     */
    public function resetPasswordForm(string $token): View|RedirectResponse
    {
        $result = $this->authService->checkResetToken($token);

        if ($result !== UserInterface::RESET_SUCCESS) {
            return $this->resetTokenRejected($result);
        }

        return view('auth.reset-password', ['token' => $token]);
    }
    /**
     * method reset password process
     * @param Request $request
     * @return RedirectResponse
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $result = $this->authService->resetPassword($validated['token'], $validated['password']);

        $this->captureSystemLog(
            null,
            null,
            'RESET_PASSWORD',
            'Password reset result: ' . $result,
            $request
        );

        if ($result !== UserInterface::RESET_SUCCESS) {
            return $this->resetTokenRejected($result);
        }

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah. Silakan masuk.');
    }
    /**
     * method redirect back to the forgot password page when the reset token is rejected
     * @param string $result
     * @return RedirectResponse
     */
    private function resetTokenRejected(string $result): RedirectResponse
    {
        return redirect()->route('password.request')->with(
            'error',
            $result === UserInterface::RESET_EXPIRED
                ? 'Tautan atur ulang kata sandi sudah kedaluwarsa. Masukkan email Anda untuk meminta tautan baru.'
                : 'Tautan atur ulang kata sandi tidak valid. Masukkan email Anda untuk meminta tautan baru.'
        );
    }
    /**
     * method email verification notice page (with resend form)
     * @return View
     */
    public function verificationNotice(): View
    {
        return view('auth.verify-email');
    }
    /**
     * method verify email by token
     * @param Request $request
     * @param string $token
     * @return RedirectResponse
     */
    public function verifyEmail(Request $request, string $token): RedirectResponse
    {
        $result = $this->authService->verifyEmail($token);

        $this->captureSystemLog(
            null,
            null,
            'EMAIL_VERIFICATION',
            'Email verification result: ' . $result,
            $request
        );

        if ($result === UserInterface::VERIFY_SUCCESS) {
            return redirect()
                ->route(Auth::check() ? 'dashboard' : 'login')
                ->with('success', 'Email berhasil diverifikasi.');
        }

        return redirect()->route('verification.notice')->with(
            'error',
            $result === UserInterface::VERIFY_EXPIRED
                ? 'Tautan verifikasi sudah kedaluwarsa. Masukkan email Anda untuk meminta tautan baru.'
                : 'Tautan verifikasi tidak valid. Masukkan email Anda untuk meminta tautan baru.'
        );
    }
    /**
     * method resend verification email
     * @param Request $request
     * @return RedirectResponse
     */
    public function resendVerification(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $this->authService->resendVerification($validated['email']);

        $this->captureSystemLog(
            null,
            $validated['email'],
            'RESEND_VERIFICATION',
            'Request resend verification email',
            $request
        );

        return redirect()->route('verification.notice')
            ->with('email', $validated['email'])
            ->with('success', 'Jika email terdaftar dan belum terverifikasi, tautan verifikasi baru telah dikirim.');
    }
}
