<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="max-w-[58%] mx-auto mt-5">
  <header class="flex justify-between items-center">
    <section>
      <h1 class="font-semibold text-gray-800 underline">AmikomEvents.</h1>
    </section>

    <section class="flex gap-3 underline text-gray-500">
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/katalog') }}">Katalog</a>
      <a href="{{ url('/bantuan') }}">Bantuan</a>
      <a href="{{ url('/profile') }}">Profile</a>
    </section>
  </header>
  <!-- Title -->
    <h1 class="text-2xl font-semibold mb-6 mt-16">Bantuan (FAQ)</h1>

    <!-- FAQ -->
    <div class="space-y-4">

        <!-- Item -->
        <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm p-5">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center">
                <span class="font-medium">Bagaimana cara membeli tiket?</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-3 text-gray-600 text-sm leading-relaxed">
                Pilih event di halaman katalog, lalu klik dan ikuti proses pembayaran hingga selesai.
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm p-5">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center">
                <span class="font-medium">Metode pembayaran apa saja?</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-3 text-gray-600 text-sm">
                Transfer bank, e-wallet, dan kartu debit tersedia.
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm p-5">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center">
                <span class="font-medium">Apakah tiket bisa direfund?</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-3 text-gray-600 text-sm">
                Tidak bisa, kecuali event dibatalkan oleh penyelenggara.
            </div>
        </div>

        <div x-data="{ open: false }" class="bg-white rounded-xl shadow-sm p-5">
            <button @click="open = !open" class="w-full text-left flex justify-between items-center">
                <span class="font-medium">Bagaimana cara menghubungi admin?</span>
                <span x-text="open ? '-' : '+'"></span>
            </button>
            <div x-show="open" x-transition class="mt-3 text-gray-600 text-sm">
                Bisa melalui email atau halaman profile.
            </div>
        </div>

    </div>

</div>

<!-- AlpineJS (untuk accordion) -->
<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>