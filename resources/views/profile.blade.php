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
      <h1 class="font-semibold text-gray-800 underline">FirzaAnanda.</h1>
    </section>

    <section class="flex gap-3 underline text-gray-500">
      <a href="{{ url('/') }}">Home</a>
      <a href="{{ url('/katalog') }}">Katalog</a>
      <a href="{{ url('/bantuan') }}">Bantuan</a>
      <a href="{{ url('/profile') }}">Profile</a>
    </section>
  </header>
  <main>
    <section class="mt-24">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh4rfYWKasIPC3js5zIz8l2yYH1mgTHum3WHveq71lNMAbPgQC1OgnqXAZRU6MuAP23Qx29BFTQo1vr2aJ6gAFZZf28ssGsqLe3uaB3bk&s=10" alt="" class="w-[12%] h-[12%] rounded-md">
      <p class="mt-3 font-semibold text-gray-800">Ahmad Firza Ananda</p>
      <p class="font-semibold text-gray-600">Fullstack Developer</p>
    </section>

    <section class="space-y-5 mt-6 leading-loose">
      <p>
        I’m Firza Ananda, a 23-year-old currently exploring the world of entrepreneurship and business.
      </p>

      <p>
        I’m passionate about learning how to build and grow ideas, especially in the digital space. I also love solving problems through code and creating clean, functional web applications.
      </p>

      <p>
        Along the way, I enjoy experimenting, tackling challenges, and sharing what I discover.
      </p>

      <p>
        On this personal website, I write about my journey—what I’m learning about business, how I approach problems, the tools and setups I use, and my thoughts on applying minimalism to the digital world.
      </p>
    </section>

    <section class="mt-10">
      <h1 class="mb-4 font-semibold text-gray-600">Let's connect</h1>
      <div class="flex gap-6 underline">
        <a>Instagram</a>
        <a>Email</a>
        <a>Github</a>
        <a>Facebook</a>
      </div>
    </section>
  </main>
</body>
</html>