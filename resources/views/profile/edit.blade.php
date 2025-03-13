@extends('layouts.user')

@section('content')
    <div class="dx-main">
        <div class="dx-separator"></div>
        <div class="dx-box-5 pb-100 bg-grey-6">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7">
                        <div class="dx-box dx-box-decorated">
                            <div class="dx-box-content">
                                <h2 class="h6 mb-6">Edit Profile</h2>
                            </div>
                            <div class="dx-box-content">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <div class="dx-box-content">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
