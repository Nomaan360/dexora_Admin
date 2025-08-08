@extends('include/layout')
@section('title', 'Report Referral')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Filter Report Referral</h5>
  @if($data['message']=='Please Select Date with difference of 9 days')
  <div class="alert alert-warning mb-6 alert-dismissible" role="alert">
    <h5 class="alert-heading mb-1 d-flex align-items-center">
      <span class="alert-icon rounded-3"><i class="ri-alert-line ri-22px"></i></span>
      <span>Sorry!</span>
    </h5>
    <span class="ms-11 ps-1">{{$data['message']}}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
  </div>
  @endif
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      <form action="{{ route('reportFilter') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="date" name="from_date" id="inputFromDate" @if(isset($data['from_date'])) value="{{$data['from_date']}}" @endif class="form-control dt-input dt-date" data-column="1" placeholder="Enter From Date" data-column-index="0" required>
                  <label for="inputFromDate">From Date</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="date" name="to_date" id="inputToDate" @if(isset($data['to_date'])) value="{{$data['to_date']}}" @endif class="form-control dt-input dt-date" data-column="2" placeholder="Enter To Date" data-column-index="0" required>
                  <label for="inputToDate">To Date</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> Search</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="export-section">
          <a href="{{ url()->current() }}?export=yes&from_date={{ request('from_date') }}&to_date={{ request('to_date') }}">
              <button type="button" class="btn waves-effect waves-light btn-info">Export Excel</button>
          </a>
      </div>
      <div class="table-responsive">
        <h5 class="card-header">Filter Report List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Name</th>
              <th>Telegram Username</th>
              <th>Coin</th>
              <th>Pph</th>
              <th>My Direct</th>
              <th>Friends</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @php
                $j=1;
                @endphp
                @if(isset($data['data']))
                    @foreach($data['data'] as $pkey => $pvalue)
                    <tr>
                        <td>{{$j}}</td>
                        <td>{{$pvalue['name']}}</td>
                        <td>{{$pvalue['telegram_username']}}</td>
                        <td>{{$pvalue['coin']}}</td>
                        <td>{{$pvalue['pph']}}</td> 
                        <td>{{$pvalue['my_direct']}}</td>
                        <td>{{$pvalue['friend']}}</td>
                    </tr>
                @php
                $j++;
                @endphp
                    @endforeach
                @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->


@endsection
@section('customjs')
@endsection 
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatables').DataTable();
  });
</script> -->