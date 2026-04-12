<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="max-w-[58%] mx-auto mt-5">

  <!-- HEADER (tetap sama) -->
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

  <!-- MAIN (CENTERED TEXT) -->
  <main class="flex justify-center items-center min-h-[80vh]">
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-700 text-center">
      Hello, welcome to amikom events center
    </h1>
  </main>

</body>
</html>