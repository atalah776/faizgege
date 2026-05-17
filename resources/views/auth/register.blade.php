<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - JemuranKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f0f4f3] font-sans antialiased min-h-screen flex items-center justify-center p-6">
    
    <div class="bg-white rounded-[20px] shadow-[0_8px_40px_rgba(0,0,0,0.08)] flex overflow-hidden w-full max-w-[780px] min-h-[520px] animate-[fadeIn_0.35s_ease_both]">
        
        <!-- Panel Kiri (Visual) -->
        <div class="hidden md:flex flex-col justify-end w-[320px] shrink-0 p-8 relative bg-primary-dark">
            <div class="absolute inset-0 bg-gradient-to-br from-[#0d5c4a]/80 to-[#094839]/95 z-10"></div>
            <div class="relative z-20 text-white">
                <div class="text-[11px] font-bold opacity-70 mb-3 tracking-widest uppercase">JemuranKu</div>
                <div class="font-serif text-[28px] mb-3 leading-tight">Di mana perawatan bertemu ketelitian</div>
                <p class="text-[13px] text-white/75 leading-relaxed">Bergabunglah dengan komunitas yang memperlakukan cucian sebagai bentuk seni. Dari deterjen botani hingga rak jemuran yang disinari matahari.</p>
            </div>
        </div>

        <!-- Panel Kanan (Form) -->
        <div class="flex-1 p-8 md:p-10 flex flex-col justify-center">
            <div class="inline-flex items-center px-3 py-1 bg-primary-light text-primary rounded-full text-[10px] font-bold tracking-widest uppercase mb-4 w-fit">Akun Baru</div>
            
            <h2 class="font-serif text-[26px] text-gray-900 mb-1.5 font-bold">Buat profil Anda</h2>
            <p class="text-[13px] text-gray-500 mb-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk di sini</a>
            </p>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-3">
                @csrf
                
                <div>
                    <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2 text-[14px] focus:border-primary focus:ring-0">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs" />
                </div>

                <div>
                    <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2 text-[14px] focus:border-primary focus:ring-0">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase mb-1">Kata Sandi</label>
                        <input type="password" name="password" required class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2 text-[14px] focus:border-primary focus:ring-0">
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold tracking-[0.06em] text-gray-400 uppercase mb-1">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" required class="w-full border-[1.5px] border-gray-200 rounded-lg px-3.5 py-2 text-[14px] focus:border-primary focus:ring-0">
                    </div>
                </div>
                
                <div class="flex items-start gap-2 mt-2">
                    <input type="checkbox" required class="rounded text-primary focus:ring-primary border-gray-300 mt-0.5">
                    <span class="text-[12px] text-gray-500">Saya setuju dengan <a href="#" class="text-primary font-semibold hover:underline">Ketentuan Layanan</a> dan Kebijakan Privasi.</span>
                </div>
                
                <button type="submit" class="btn-primary mt-2">Selesaikan Pendaftaran</button>
            </form>
            
        </div>
    </div>
    
</body>
</html>