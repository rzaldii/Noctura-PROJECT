@extends('components.layout_customer')
@section('title', 'Profil Customer')

@section('content')
<h1 class="text-4xl font-bold text-center mb-8">Profile</h1>
<div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow mt-8">

    <!-- BAGIAN ATAS -->
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">

        <!-- FOTO -->
        <div class="relative">
            <img src="{{ asset($customer->image_path) }}"
                 class="w-40 h-40 rounded-full object-cover border shadow">

        </div>

        <!-- INFO NAMA -->
        <div class="flex-1">

            <!-- TOP BAR -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $customer->full_name }}</h1>
                </div>

                <a href="{{ route('customer.profile.edit') }}"
                   class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 flex items-center gap-2">
                    Edit Profile
                </a>
            </div>

            <!-- DETAIL INFORMASI -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-3">

                <div>
                    <p class="text-gray-500">Email</p>
                    <p class="font-semibold">{{ $customer->email }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Username</p>
                    <p class="font-semibold">{{ $customer->username ?? '-' }}</p>
                </div>

            </div>

        </div>
    </div>

    <!-- LOGOUT -->
    <form action="{{ route('customer.logout') }}" method="POST" class="text-center mt-10">
        @csrf
        <button type="submit"
                class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Logout
        </button>
    </form>

</div>

@endsection
