@extends('include/layout')
@section('title', 'Validation')


@section('customcss')
                         
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-select/bootstrap-select.css') }}" /> 
<link rel="stylesheet" href="{{ asset('vendor/libs/tagify/tagify.css') }}" /> 

@endsection
@section('content')
 
<div class="row mb-6">
  <!-- Bootstrap Validation -->
  <div class="col-md">
    <div class="card">
      <h5 class="card-header">Bootstrap Validation</h5>
      <div class="card-body">
        <form class="needs-validation" novalidate>
          <div class="form-floating form-floating-outline mb-6">
            <input type="text" class="form-control" id="bs-validation-name" placeholder="John Doe" required />
            <label for="bs-validation-name">Name</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please enter your name. </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="email" id="bs-validation-email" class="form-control" placeholder="john.doe" aria-label="john.doe" required />
            <label for="bs-validation-email">Email</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please enter a valid email </div>
          </div>
          <div class="mb-6 form-password-toggle">
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <input type="password" id="bs-validation-password" class="form-control" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                <label for="bs-validation-password">Password</label>
              </div>
              <span class="input-group-text rounded-end cursor-pointer" id="basic-default-password4"><i class="ri-eye-off-line"></i></span>
              <div class="valid-feedback"> Looks good! </div>
              <div class="invalid-feedback"> Please enter your password. </div>
            </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select" id="bs-validation-country" required>
              <option value="">Select Country</option>
              <option value="usa">USA</option>
              <option value="uk">UK</option>
              <option value="france">France</option>
              <option value="australia">Australia</option>
              <option value="spain">Spain</option>
            </select>
            <label class="form-label" for="bs-validation-country">Country</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please select your country </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="text" class="form-control flatpickr-validation" placeholder="YYYY-MM-DD" id="bs-validation-dob" required />
            <label for="bs-validation-dob">DOB</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please Enter Your DOB </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="file" class="form-control" id="bs-validation-upload-file" required />
            <label for="bs-validation-upload-file">Profile pic</label>
          </div>
          <div class="mb-6">
            <label class="d-block form-label">Gender</label>
            <div class="form-check mb-2">
              <input type="radio" id="bs-validation-radio-male" name="bs-validation-radio" class="form-check-input" required checked />
              <label class="form-check-label" for="bs-validation-radio-male">Male</label>
            </div>
            <div class="form-check">
              <input type="radio" id="bs-validation-radio-female" name="bs-validation-radio" class="form-check-input" required />
              <label class="form-check-label" for="bs-validation-radio-female">Female</label>
            </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-75" id="bs-validation-bio" name="bs-validation-bio" rows="3" placeholder="My name is john" required></textarea>
            <label for="bs-validation-bio">Bio</label>
          </div>
          <div class="mb-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="bs-validation-checkbox" required />
              <label class="form-check-label" for="bs-validation-checkbox">Agree to our terms and conditions</label>
              <div class="invalid-feedback"> You must agree before submitting. </div>
            </div>
          </div>
          <div class="mb-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="bootstrapValidationSwitch" required />
              <label class="form-check-label" for="bootstrapValidationSwitch">Send me related emails</label>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /Bootstrap Validation -->
</div>




@endsection
@section('customjs')

<script src="{{ asset('vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('vendor/libs/tagify/tagify.js') }}"></script>

<script src="{{ asset('js/form-validation.js') }}"></script>

@endsection 