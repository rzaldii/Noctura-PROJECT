@extends('components.layout_customer')

@section('title', 'Profil Customer')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow mt-8 text-center">

    <h2 class="text-4xl font-bold mb-6">Profile</h2>
    <img src="{{ asset($customer->image_path) }}"
         class="w-36 h-36 rounded-full object-cover border mx-auto"
         alt="Foto Profil">

    <div>
        <h1 class="text-2xl font-bold pt-3 pb-6">{{ $customer->full_name }}</h1>
    </div>

    <div class="space-y-3 text-center">
        <p><strong>Username:</strong> {{ $customer->username }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
    </div>

    <form action="{{ route('customer.logout') }}" method="POST" class="mt-8">
        @csrf
        <button type="submit"
                class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
            Logout
        </button>
    </form>

</div>

@endsection
