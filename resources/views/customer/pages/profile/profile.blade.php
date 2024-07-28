@extends('layouts.app')

@section('content')
<div class="profile-page">
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-info-container">
                <div class="profile-pic-container">
                    <img src="{{ Auth::user()->profile_image }}" alt="Profile Picture" class="profile-pic" id="profile-pic">
                    <div class="profile-pic-overlay">
                        <i class="fas fa-camera"></i>
                        <span>Change Photo</span>
                    </div>
                </div>
                <div class="profile-info">
                    <h1 class="profile-name">{{ Auth::user()->customer->fname }} {{ Auth::user()->customer->lname }}</h1>
                    <p class="profile-email">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div class="button-group">
                <button type="submit" form="profile-form" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('customer.menu.dashboard') }}" class="btn btn-secondary">Return to Home</a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('api.customer.profile.update') }}" enctype="multipart/form-data" id="profile-form" class="pt-3">
            @csrf
            <div id="error-messages" class="alert alert-danger" style="display:none;"></div>
            <div class="form-group">
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="{{ Auth::user()->customer->fname }}">
                <span class="danger-text" id="error-fname"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="{{ Auth::user()->customer->lname }}" required>
                <span class="danger-text" id="error-lname"></span>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}" required>
                <span class="danger-text" id="error-email"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact" value="{{ Auth::user()->customer->contact }}" required>
                <span class="danger-text" id="error-contact"></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ Auth::user()->customer->address }}" required>
                <span class="danger-text" id="error-address"></span>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                <span class="danger-text" id="error-profile_image"></span>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const form = $('#profile-form');
    const errorMessages = $('#error-messages');
    const profilePicInput = $('#profile_image');
    const profilePic = $('#profile-pic');

    form.on('submit', function(e) {
        e.preventDefault();
        errorMessages.empty().hide();

        const formData = new FormData(this);
        let valid = true;

        // Validation
        const namePattern = /^[A-Za-z]+$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const contactPattern = /^\d{11}$/;

        if (!$('#fname').val().trim()) {
            valid = false;
            errorMessages.append('<p>First name is required.</p>');
            $('#error-fname').text('First name is required.');
        } else if (!namePattern.test($('#fname').val().trim())) {
            valid = false;
            errorMessages.append('<p>First name can only contain letters.</p>');
            $('#error-fname').text('First name can only contain letters.');
        } else {
            $('#error-fname').text('');
        }

        if (!$('#lname').val().trim()) {
            valid = false;
            errorMessages.append('<p>Last name is required.</p>');
            $('#error-lname').text('Last name is required.');
        } else if (!namePattern.test($('#lname').val().trim())) {
            valid = false;
            errorMessages.append('<p>Last name can only contain letters.</p>');
            $('#error-lname').text('Last name can only contain letters.');
        } else {
            $('#error-lname').text('');
        }

        if (!$('#email').val().trim()) {
            valid = false;
            errorMessages.append('<p>Email is required.</p>');
            $('#error-email').text('Email is required.');
        } else if (!emailPattern.test($('#email').val().trim())) {
            valid = false;
            errorMessages.append('<p>Please enter a valid email address.</p>');
            $('#error-email').text('Please enter a valid email address.');
        } else {
            $('#error-email').text('');
        }

        if (!$('#contact').val().trim()) {
            valid = false;
            errorMessages.append('<p>Contact is required.</p>');
            $('#error-contact').text('Contact is required.');
        } else if (!contactPattern.test($('#contact').val().trim())) {
            valid = false;
            errorMessages.append('<p>Contact must be exactly 11 digits.</p>');
            $('#error-contact').text('Contact must be exactly 11 digits.');
        } else {
            $('#error-contact').text('');
        }

        if (!$('#address').val().trim()) {
            valid = false;
            errorMessages.append('<p>Address is required.</p>');
            $('#error-address').text('Address is required.');
        } else {
            $('#error-address').text('');
        }

        if (valid) {
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert('Profile updated successfully');
                    window.location.reload();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    for (let key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessages.append('<p>' + errors[key][0] + '</p>');
                            $('#error-' + key).text(errors[key][0]);
                        }
                    }
                    errorMessages.show();
                }
            });
        } else {
            errorMessages.show();
        }
    });

    profilePicInput.on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePic.attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
