<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Catering | Login</title>
    <!-- Favicon (Opsional) -->
    <link href="{{ $setting->logo ?? asset('niceadmin/img/laravel.png') }}" rel="icon">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            green: '#0f2818',
                            pink: '#FBEAF0',
                            accent: '#e83c74', // Pink agak tua untuk teks link
                            button: '#15803d', // Hijau tombol (emerald-700 atau green-700)
                            button_hover: '#166534',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-brand-button selection:text-white">

    <div class="min-h-screen flex">
        <!-- Kolom Kiri: Branding & Informasi -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-brand-green flex-col justify-between p-12 text-white">
            <!-- Top Branding -->
            <div class="flex items-center gap-3">
                <!-- Ikon Topi Chef -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-brand-pink" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.686 2 6 4.686 6 8c0 1.341.442 2.576 1.192 3.568.21.277.34.62.34.975v3.457A3.001 3.001 0 0010.5 19v1a1 1 0 001 1h1a1 1 0 001-1v-1a3.001 3.001 0 002.968-3l.032-.016v-3.441c0-.355.13-.698.34-.975C17.558 10.576 18 9.341 18 8c0-3.314-2.686-6-6-6z" />
                </svg>
                <span class="text-xl font-bold tracking-wider">Sistem Catering</span>
            </div>

            <!-- Main Title & Subtitle -->
            <div class="max-w-lg mt-auto mb-auto">
                <h1 class="text-5xl font-bold leading-tight mb-6">Kelola setiap acara dengan rasa yang selalu sempurna</h1>
                <p class="text-gray-300 text-lg leading-relaxed">Pesanan, jadwal antar, dan laporan bisnis catering kamu dalam satu tempat.</p>
            </div>

            <!-- Stats Bottom -->
            <div class="flex gap-12 border-t border-gray-600/50 pt-8 mt-8">
                <div>
                    <h3 class="text-3xl font-bold">1.200+</h3>
                    <p class="text-gray-400 text-sm mt-1">Acara terlayani</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold flex items-center gap-2">
                        4.9
                        <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </h3>
                    <p class="text-gray-400 text-sm mt-1">Rating klien</p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 md:p-16 bg-brand-pink z-10 relative">
            <div class="w-full max-w-md mt-10 lg:mt-0">
                
                <div class="mb-8 text-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                    <p class="text-gray-600">Masuk untuk kelola pesanan cateringmu</p>
                </div>

                <!-- Google Sign In Button -->
                <button type="button" class="w-full flex justify-center items-center gap-3 py-3 px-4 bg-white border border-gray-300 rounded-xl shadow-sm text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-button transition-all mb-6">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Lanjutkan dengan Google
                </button>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-brand-pink text-gray-500">atau dengan email</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-5">
                    @csrf
                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <input id="email" name="email" type="email" required
                                value="{{ old('email') ?? ($email ?? '') }}"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-button focus:border-brand-button outline-none transition-all shadow-sm"
                                placeholder="nama@caterindah.com">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required
                                class="w-full pl-4 pr-11 py-3 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-button focus:border-brand-button outline-none transition-all shadow-sm"
                                placeholder="Masukkan password">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="togglePassword" class="p-2 text-gray-400 hover:text-gray-600 focus:outline-none rounded-lg transition-colors">
                                    <!-- Eye Icon (hidden by default) -->
                                    <svg id="eyeIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" value="on"
                                {{ old('remember') ? 'checked' : (isset($remember) && $remember ? 'checked' : '') }}
                                class="h-4 w-4 text-brand-button focus:ring-brand-button border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-brand-accent hover:underline">Lupa password?</a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-brand-button hover:bg-brand-button_hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-button transition-all transform hover:-translate-y-0.5 duration-200">
                        Masuk
                    </button>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ Route::has('register') ? route('register') : '#' }}" class="font-semibold text-brand-accent hover:underline">Daftar sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 (Untuk flash message error/success bawaan template sebelumnya) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Logika Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            if (isPassword) {
                // Eye Slash Icon (Hide)
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            } else {
                // Eye Icon (Show)
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        });

        // Logika Notifikasi SweetAlert
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        let flashSuccess = "{{ session('success') ?? '' }}";
        if (flashSuccess) {
            Toast.fire({ icon: "success", title: flashSuccess });
        }

        let flashError = "{{ session('error') ?? '' }}";
        let errors = @json($errors->all());

        if (flashError) {
            Toast.fire({ icon: "error", title: flashError });
        } else if (errors.length > 0) {
            Toast.fire({ icon: "error", title: errors[0] });
        }
    </script>
</body>
</html>
