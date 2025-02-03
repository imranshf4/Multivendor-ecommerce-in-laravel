@extends('vendor.vendor_dashboard')
@section('vendor')

<div class="row" style="margin-top: 100px;">
    <div class="col-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="row g-0">
                <div class="col-lg-5 border-end">
                    <div class="card-body">
                        <div class="p-5">
                            <div class="text-start">
                                <img src="{{ asset('adminbackend/assets/images/logo-img.png') }}"
                                    width="180" alt="">
                            </div>
                            <form method="post" action="{{ route('update.password') }}">
                                @csrf

                                <h4 class="mt-3 font-weight-bold">Vendor Change Password</h4>
                                @if(session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="mb-3 mt-3">
                                    <label class="form-label" style="font-size: 16px;">Current Password</label>
                                    <input type="password" name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        id="current_password" placeholder="Old Password" />

                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 16px;">New Password</label>
                                    <input type="password" name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        id="new_password" placeholder="New Password" />

                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 16px;">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control"
                                        id="new_password_confirmation" placeholder="Confirm New Password" />
                                </div>

                                <div class="d-grid gap-2">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" /><a
                                        href="authentication-login.html" class="btn btn-light"><i
                                            class='bx bx-arrow-back mr-1'></i>Back to Login</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <img src="{{ asset('adminbackend/assets/images/login-images/forgot-password-frent-img.jpg') }}"
                        class="card-img login-img h-100" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
