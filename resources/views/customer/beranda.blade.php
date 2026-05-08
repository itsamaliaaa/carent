@extends('layouts.customer')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-[#0B1F67]">
            Beranda
        </h1>
    </div>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit"
            class="flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium transition">
        <img src="{{ asset('images/icons/logout-04.svg') }}" alt="Logout" class="w-4 h-4">
        Logout
    </button>
</form>
@endsection