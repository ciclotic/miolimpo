@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('account/account-menu')
        <div class="col-md-9 mt-3">
            <h4>{{ __('ctic_shop.my_data') }}</h4>
            <form action="{{ route('account.save-data') }}" method="post" class="mb-4">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">{{ __('ctic_shop.name') }}</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->name }}">
                            @error('name')
                            <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="surname">{{ __('ctic_shop.surname') }}</label>
                            <input type="text" class="form-control" name="surname" id="surname" value="{{ auth()->user()->surname }}">
                            @error('surname')
                            <small id="surnameHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('ctic_shop.email') }}</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->email }}">
                            @error('email')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('ctic_shop.phone') }}</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ auth()->user()->phone }}">
                            @error('phone')
                            <small id="phoneHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" @if(auth()->user()->newsletter) checked @endif name="newsletter" id="newsletter" value="1">
                            <label class="form-check-label" for="newsletter">{{ __('ctic_shop.newsletter') }}</label>
                            @error('newsletter')
                            <small id="newsletterHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="current_password">{{ __('ctic_shop.current_password') }}</label>
                            <input type="password" class="form-control" name="current_password" id="current_password">
                            @error('current_password')
                            <small id="current_passwordHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('ctic_shop.password') }}</label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password')
                            <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="repeat_password">{{ __('ctic_shop.repeat_password') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" id="repeat_password">
                            @error('password_confirmation')
                            <small id="password_confirmationHelp" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('ctic_shop.save_data') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
