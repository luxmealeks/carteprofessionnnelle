<div class="max-w-md mx-auto bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden p-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-2">{{ __('Log in to your account') }}</h2>
        <p class="text-zinc-600 dark:text-zinc-400">{{ __('Enter your credentials to access your dashboard') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 text-center px-4 py-3 rounded-lg bg-primary-50 dark:bg-primary-900/50 text-primary-600 dark:text-primary-300" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Field -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300" for="email">
                {{ __('Email address') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                </div>
                <input wire:model="email" id="email" name="email" type="email" autocomplete="email" required
                    class="block w-full pl-10 pr-3 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700/50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500/50 dark:focus:border-primary-500 placeholder-zinc-400 dark:placeholder-zinc-500 text-zinc-900 dark:text-white transition duration-150 ease-in-out"
                    placeholder="email@example.com">
            </div>
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300" for="password">
                    {{ __('Password') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 transition duration-150 ease-in-out">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required
                    class="block w-full pl-10 pr-3 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700/50 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-500/50 dark:focus:border-primary-500 placeholder-zinc-400 dark:placeholder-zinc-500 text-zinc-900 dark:text-white transition duration-150 ease-in-out"
                    placeholder="••••••••">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" x-data="{ show: false }" @click="show = !show">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!show">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                    <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="show" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="remember" id="remember" name="remember" type="checkbox"
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700/50">
            <label for="remember" class="ml-2 block text-sm text-zinc-700 dark:text-zinc-300">
                {{ __('Remember me') }}
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-zinc-800 transition duration-150 ease-in-out">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <!-- Sign Up Link -->
    @if (Route::has('register'))
        <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 transition duration-150 ease-in-out">
                {{ __('Sign up') }}
            </a>
        </div>
    @endif

    <!-- Social Login -->
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-zinc-300 dark:border-zinc-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400">
                    {{ __('Or continue with') }}
                </span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-500 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition duration-150 ease-in-out">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0110 4.844c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.933.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.163 20 14.418 20 10c0-5.523-4.477-10-10-10z" clip-rule="evenodd"></path>
                </svg>
            </a>
            <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-zinc-300 dark:border-zinc-600 rounded-lg shadow-sm bg-white dark:bg-zinc-700 text-sm font-medium text-zinc-500 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition duration-150 ease-in-out">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 5.523 4.477 10 10 10 5.523 0 10-4.477 10-10 0-5.523-4.477-10-10-10zm5.655 14.905c-1.33 1.332-3.11 2.065-5.655 2.065-2.545 0-4.325-.733-5.655-2.065-1.332-1.33-2.065-3.11-2.065-5.655 0-2.545.733-4.325 2.065-5.655C5.675 1.733 7.455 1 10 1c2.545 0 4.325.733 5.655 2.065 1.332 1.33 2.065 3.11 2.065 5.655 0 2.545-.733 4.325-2.065 5.655zM10 4.5c-3.038 0-5.5 2.462-5.5 5.5s2.462 5.5 5.5 5.5 5.5-2.462 5.5-5.5-2.462-5.5-5.5-5.5zm0 9.167c-2.022 0-3.667-1.645-3.667-3.667S7.978 6.333 10 6.333s3.667 1.645 3.667 3.667-1.645 3.667-3.667 3.667z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
