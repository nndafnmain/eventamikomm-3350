@extends('layouts.admin', ['title' => 'Kelola Partner'])

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Partner</h1>
        <p class="text-slate-500 font-medium">
            Atur partner dan sponsor platform event Anda.
        </p>
    </div>
</header>

@if(session('success'))
    <div class="mb-6 px-5 py-4 rounded-2xl bg-emerald-50 text-emerald-600 font-semibold border border-emerald-100">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

    {{-- TOP BAR --}}
    <div class="p-8 border-b border-slate-100 flex flex-col lg:flex-row gap-4 justify-between">

        {{-- SEARCH --}}
        <form method="GET" class="flex gap-3">

            <input 
                type="text"
                name="search"
                placeholder="Cari partner..."
                value="{{ request('search') }}"
                class="px-5 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-72"
            >

            <button 
                type="submit"
                class="px-5 py-3 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-700 transition"
            >
                Cari
            </button>

        </form>

        {{-- TAMBAH --}}
        <form 
            action="{{ route('admin.partners.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex gap-3"
        >

            @csrf

            <input 
                type="text"
                name="name"
                placeholder="Nama partner"
                class="px-5 py-3 rounded-2xl border border-slate-200"
            >

            <input 
                type="file"
                name="logo_url"
                class="px-5 py-3 rounded-2xl border border-slate-200"
            >

            <button 
                type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg"
            >
                + Tambah
            </button>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">

        <table class="w-full text-left border-collapse">

            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">ID</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Partner</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y border-t">

                @forelse($partners as $partner)

                <tr class="hover:bg-slate-50/50 transition">

                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $partner->id }}
                    </td>

                    <td class="px-8 py-6">
                        <img 
                          src="{{ asset('storage/' . $partner->logo_url) }}"
                          class="w-16 h-16 object-cover rounded-2xl border"
                      >
                    </td>

                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">
                            {{ $partner->name }}
                        </p>
                    </td>

                    <td class="px-8 py-6 flex gap-2">

                        {{-- EDIT --}}
                        <form 
                          action="{{ route('admin.partners.update', $partner->id) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="flex gap-2"
                      >

                            @csrf
                            @method('PUT')

                            <input 
                                type="text"
                                name="name"
                                value="{{ $partner->name }}"
                                class="px-4 py-2 rounded-xl border border-slate-200"
                            >

                            <input 
                              type="file"
                              name="logo_url"
                              class="px-4 py-2 rounded-xl border border-slate-200"
                          >

                            <button 
                                type="submit"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                            >
                                Edit
                            </button>

                        </form>

                        {{-- DELETE --}}
                        <form 
                            action="{{ route('admin.partners.destroy', $partner->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus partner ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button 
                                type="submit"
                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                            >
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-medium">
                        Belum ada partner.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection