@extends('user.layouts.master');

@section('title')
    Contact Us
@endsection

@section('content')

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
    @endif
    <form action="{{ route('user#contact#create') }}" class="w-75 d-flex flex-column justify-content-center align-items-center gap-3"
        style="margin: 20px auto" method="POST">
        @csrf
        <input type="hidden" value="{{ Auth::user()->name }}" name="contactName">
        <input type="hidden" value="{{ Auth::user()->email }}" name="contactEmail">

        <div class="w-100">
            <label for="">What you wanna tell us..</label>
            <textarea name="contactMessage" id="" cols="30" rows="10" placeholder="Message" class="form-control @error('contactMessage') is-invalid @enderror">{{old('contactMessage')}}</textarea>
            @error('contactMessage')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-dark">
            Send
        </button>
    </form>
@endsection

@section('scriptSource')
    <script></script>
@endsection
