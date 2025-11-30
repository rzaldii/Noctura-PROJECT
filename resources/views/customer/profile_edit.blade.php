@extends('components.layout_customer')
@section('title', 'Edit Profil')
@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow mt-8">

    <h2 class="text-4xl font-bold mb-6 text-center">Edit Profil</h2>

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- FULLNAME -->
        <div>
            <label class="block font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="full_name" class="w-full border rounded p-2"
                   value="{{ old('full_name', $customer->full_name) }}" required>
        </div>

        <!-- USERNAME -->
        <div>
            <label class="block font-medium mb-1">Username</label>
            <input type="text" name="username" class="w-full border rounded p-2"
                   value="{{ old('username', $customer->username) }}" required>
        </div>

        <!-- IMAGE -->  
        <div>
            <label class="block font-medium mb-1">Foto Profil</label>

            <div class="flex items-center gap-4">
                <img src="{{ asset($customer->image_path) }}"
                     class="w-20 h-20 rounded-full object-cover border">

                <input type="file" name="image_path" class="border rounded p-2">
            </div>
        </div>

        <div class="flex justify-center mt-6 gap-2">
            <a href="{{ route('customer.profile') }}"
                class="bg-white text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-200 border-2 border-gray-800 transition">
                Batal
            </a>
            <button type="submit"
                class="bg-gray-700 text-white px-5 py-2 rounded-lg hover:bg-gray-800 transition">
                Simpan
            </button>
        </div>
    </form>

</div>

@endsection
