@extends('include/layout')
@section('title', 'Cipher')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Add Cipher</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      @if(isset($data['editData']))
      @php
      $editData = $data['editData'];
      @endphp
      <form action="{{ route('cipher.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
        {{ method_field("PUT") }}
      @else
      <form action="{{ route('cipher.store') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
      @endif 
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="cipher_code" id="inputCipher" @if(isset($editData['cipher_code'])) value="{{$editData['cipher_code']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Cipher Code" data-column-index="0" required>
                  <label for="inputCipher">Cipher Code</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="date" id="inputCipherDate" @if(isset($editData['date'])) value="{{$editData['date']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Date YYYY-mm-dd" data-column-index="0" required>
                  <label for="inputCipherDate">Date</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="amount" id="inputamount" @if(isset($editData['amount'])) value="{{$editData['amount']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter amount" data-column-index="0" required>
                  <label for="inputamount">Amount</label>
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
                @if(isset($data['editData']))
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> Update</button>
                @else
                  <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> Save</button>
                @endif
              </div>
            </div>
          </div>
        </div>
      </form>
      <div class="table-responsive">
        <h5 class="card-header">Cipher List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Code</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
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
                        <td>{{$pvalue['cipher_code']}}</td>
                        <td>{{$pvalue['date']}}</td>
                        <td>{{$pvalue['status'] == 1 ? "Active" : "In-Active"}}</td>
                        <td>
                          <a href="{{ route('cipher.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-circle-line ri-20px"></i></button></a>

                          <form action="{{ route('cipher.destroy', $pvalue['id'])}}" method="post">
                          @csrf
                          @method('DELETE')<button type="submit" onclick="return confirmDelete();" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-delete-bin-7-line ri-20px"></i></button></a>
                          </form>
                        </td>
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