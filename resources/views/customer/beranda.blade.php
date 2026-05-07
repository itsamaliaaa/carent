@extends('layouts.customer')

@section('content')
    <h1>Halo ini beranda</h1>
    <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit"
            class="flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium transition">
        <img src="{{ asset('images/icons/logout.svg') }}" alt="Logout" class="w-4 h-4">
        Logout
    </button>
</form>
@endsection