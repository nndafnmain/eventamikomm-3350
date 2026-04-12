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

  <main class="mt-12">
    <section class="flex gap-3">
      <article class="border rounded-md shadow-md border-none">
        <div>
          <img src="https://assets.loket.com/neo/production/images/banner/20260130193245_697ca4ed2c81a.jpg" alt="" class="object-cover rounded-md">
        </div>
        <div class="p-3 space-y-2">
          <p class="font-semibold text-gray-700">Event Musik Oke</p>
          <div class="flex gap-2 items-center">
            <x-fontisto-date class="w-[15px] h-[15px]"/>
            <p class="text-sm text-gray-500">03 Juli 2026</p>
          </div>
          <p class="text-sm text-gray-700 font-semibold">Rp. 149.000</p>
        </div>
      </article>

     <article class="border rounded-md shadow-md border-none">
        <div>
          <img src="https://assets.loket.com/neo/production/images/banner/20260130193245_697ca4ed2c81a.jpg" alt="" class="object-cover rounded-md">
        </div>
        <div class="p-3 space-y-2">
          <p class="font-semibold text-gray-700">Event Musik Oke</p>
          <div class="flex gap-2 items-center">
            <x-fontisto-date class="w-[15px] h-[15px]"/>
            <p class="text-sm text-gray-500">03 Juli 2026</p>
          </div>
          <p class="text-sm text-gray-700 font-semibold">Rp. 149.000</p>
        </div>
      </article>

    <article class="border rounded-md shadow-md border-none">
        <div>
          <img src="https://assets.loket.com/neo/production/images/banner/20260130193245_697ca4ed2c81a.jpg" alt="" class="object-cover rounded-md">
        </div>
        <div class="p-3 space-y-2">
          <p class="font-semibold text-gray-700">Event Musik Oke</p>
          <div class="flex gap-2 items-center">
            <x-fontisto-date class="w-[15px] h-[15px]"/>
            <p class="text-sm text-gray-500">03 Juli 2026</p>
          </div>
          <p class="text-sm text-gray-700 font-semibold">Rp. 149.000</p>
        </div>
      </article>
    </section>
  </main>
</body>
</html>