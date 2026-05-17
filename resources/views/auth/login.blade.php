<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - JemuranKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f0f4f3] font-sans antialiased min-h-screen flex items-center justify-center p-6">
    
    <div class="bg-white rounded-[20px] shadow-[0_8px_40px_rgba(0,0,0,0.08)] flex overflow-hidden w-full max-w-[780px] min-h-[480px] animate-[fadeIn_0.35s_ease_both]">
        
        <!-- Panel Kiri (Visual) -->
        <div class="hidden md:flex flex-col justify-end w-[320px] shrink-0 p-8 relative bg-primary-dark">
            <div class="absolute inset-0 bg-gradient-to-b from-[#094839]/30 to-[#094839]/90 z-10"></div>
            <div class="relative z-20 text-white">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center mb-3 text-lg shadow-sm">🌿</div>
                <div class="font-serif text-[28px] mb-2 leading-tight">JemuranKu</div>
                <p class="text-[12.5px] text-white/75 leading-relaxed mb-4">Menghadirkan kesegaran alami untuk pakaian Anda melalui sistem penjadwalan yang presisi dan estetis.</p>
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-full">
                    <span class="text-[10px] text-white/80 font-bold tracking-widest">◎ LAYANAN RAMAH LINGKUNGAN</span>
                </div>
            </div>
        </div>

        <!-- Panel Kanan (Form) -->
        <div class="flex-1 p-8 md:p-10 flex flex-col justify-center">
            <div class="flex items-center gap-2.5 mb-6 md:hidden">
                <div class="w-8 h-8 bg-primary rounded-md flex items-center justify-center text-sm text-white">🌿</div>
                <span class="font-serif text-lg text-primary font-bold">JemuranKu</span>
            </div>
            
            <h2 class="font-serif text-[26px] text-gray-900 mb-1.5 font-bold">Selamat Datang</h2>
            <p class="text-[13px] text-gray-500 mb-7">Silakan masuk untuk mengelola reservasi jemuran Anda.</p>

            <!-- Error Bawaan Laravel -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                @csrf
                
                <div>
                    <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase mb-1.5">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[14px] focus:border-primary focus:ring-0">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[12px] text-primary font-semibold hover:underline">Lupa kata sandi?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2.5 text-[14px] focus:border-primary focus:ring-0">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                </div>
                
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary border-gray-300">
                    <span class="text-[13px] text-gray-500">Ingat saya di perangkat ini</span>
                </div>
                
                <button type="submit" class="btn-primary mt-2">Masuk ke Dashboard <span>→</span></button>
            </form>

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                <span class="text-[13px] text-gray-500">Belum memiliki akun?</span>
                <a href="{{ route('register') }}" class="btn-outline !w-auto !py-2 !px-4 !text-[12px]">Daftar Sekarang</a>
            </div>
        </div>
    </div>
    
    <!-- Footer Kecil -->
    <p class="absolute bottom-6 text-[10px] text-gray-400 tracking-[0.06em] font-bold uppercase">© {{ date('Y') }} JEMURANKU • RAMAH LINGKUNGAN & PRESISI</p>
    
</body>
</html>