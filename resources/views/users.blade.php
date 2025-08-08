@extends('include/layout')
@section('title', 'User List')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
        {{-- <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="name" id="inputName" @if(isset($editData['name'])) value="{{$editData['name']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Category Name" data-column-index="0" required>
                  <label for="inputName">Category Name</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="form-select" id="floatingSelect" name="status" aria-label="Floating label select example" required>
                      <option>Select Status</option>
                      <option value="1" @if(isset($editData['status'])) @if($editData['status'] == 1) selected="selected" @endif @endif>Active</option>
                      <option value="0" @if(isset($editData['status'])) @if($editData['status'] == 0) selected="selected" @endif @endif>In-Active</option>
                  </select>
                  <label for="floatingSelect">Catregory Status</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                <!-- <label for="formFile" class="form-label">Default file input example</label> -->
                  <input class="form-control" type="file" name="image" id="formFile">
                  <label for="formFile">Category Image</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                @if(isset($data['editData']))
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> Update</button>
                @else
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> Save</button>
                @endif
              </div>
            </div>
          </div>
        </div> --}}
      <form action="{{ route('allusers') }}" enctype="multipart/form-data" method="POST">
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
        <h5 class="card-header">User List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Telegram Username</th>
              <th>Wallet Address</th>
              <th>Coin</th>
              <th>Pph</th>
              <th>Character</th>
              <th>Mydirect</th>
              <th>My team</th>
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
                        <td>{{$pvalue['email']}}</td>
                        <td>{{$pvalue['telegram_username']}}</td>
                        <td>{{$pvalue['wallet_address']}}</td>
                        <td>{{$pvalue['coin']}}</td>
                        <td>{{$pvalue['pph']}}</td> 
                        <td>{{$pvalue['character']}}</td>
                        <td>{{$pvalue['my_direct']}}</td>
                        <td>{{$pvalue['my_team']}}</td>
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