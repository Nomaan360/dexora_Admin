@extends('include/layout')
@section('title', 'Dexora Bundle')


@section('customcss')
                         
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap-select/bootstrap-select.css') }}" /> 
<link rel="stylesheet" href="{{ asset('vendor/libs/tagify/tagify.css') }}" /> 

@endsection
@section('content')
 
<div class="row mb-6">
  <!-- Bootstrap Validation -->
  <div class="col-md">
    <div class="card">
      <h5 class="card-header">Bundle</h5>
      <div class="card-body">
        <form id="bundleForm" class="needs-validation" method="post" action="{{ route('admin_process_bundle') }}" novalidate enctype="multipart/form-data">
          @csrf
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select" name="typeoftickets" id="bs-validation-types-of-tickets" required>
              <option value="">Select an option</option>
              <option value="Only Lottery">Only Lottery: 100 baht </option>
              <option value="Entry Pass">Entry Pass: 350 baht </option>
              <option value="Combo Entry">Combo Entry: 400 baht </option>
            </select>
            <label class="form-label" for="bs-validation-types-of-tickets">Types of tickets</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please select your ticket type </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="number" class="form-control" name="numoftickets" id="bs-validation-qty" min="1" max="150" placeholder="1" required />
            <label for="bs-validation-qty">Number of tickets</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please enter number of tickets. </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="email" id="bs-validation-email" name="usermail" class="form-control" placeholder="john.doe@gmail.com" aria-label="john.doe" required />
            <label for="bs-validation-email">Email</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please enter a valid email </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="text" class="form-control" name="reference_name" id="bs-validation-reference-name" placeholder="reference name" required />
            <label for="bs-validation-reference-name">Reference Name</label>
            <div class="valid-feedback"> Looks good! </div>
            <div class="invalid-feedback"> Please enter reference name. </div>
          </div>
          <div class="form-floating form-floating-outline mb-6">
            <input type="file" class="form-control" name="screenshot" id="bs-validation-upload-file" required />
            <label for="bs-validation-upload-file">Screenshot</label>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary" onclick="return confirmDelete();">Submit</button>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('bundleForm');
    var isSubmitting = false;

    form.addEventListener('submit', function (event) {
        if (isSubmitting) {
            event.preventDefault(); // Prevent form from being submitted multiple times
            return false;
        }

        isSubmitting = true;
        var submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = 'Submitting...'; // Optional: Change button text

        // Optionally, you can add a spinner or loading indicator here

        // You can use AJAX to submit the form if needed
        // $.ajax({
        //     type: 'POST',
        //     url: form.action,
        //     data: new FormData(form),
        //     processData: false,
        //     contentType: false,
        //     success: function (response) {
        //         // Handle success
        //     },
        //     error: function (error) {
        //         // Handle error
        //     }
        // });
    });
});
</script>
@endsection 