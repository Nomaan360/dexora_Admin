@extends('include/layout')
@section('title', 'Combo')


@section('customcss')
<link rel="stylesheet" href="{{ asset('vendor/libs/select2/select2.css') }}" /> 
@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Add Combo</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      @if(isset($data['editData']))
      @php
      $editData = $data['editData'];
      @endphp
      <form action="{{ route('combo.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
        {{ method_field("PUT") }}
      @else
      <form action="{{ route('combo.store') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
      @endif 
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">
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
                  <select class="select2 form-select" id="floatingCardId1" name="card_1" aria-label="Floating label select example" required>
                      <option>Select Cards</option>
                      @foreach($data['cards'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['card_1'])) @if($editData['card_1'] == $value['id']) selected="selected" @endif @endif>{{$value['title']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingCardId1">Card 1</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="select2 form-select" id="floatingCardId2" name="card_2" aria-label="Floating label select example" required>
                      <option>Select Cards</option>
                      @foreach($data['cards'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['card_2'])) @if($editData['card_2'] == $value['id']) selected="selected" @endif @endif>{{$value['title']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingCardId2">Card 2</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="select2 form-select" id="floatingCardId3" name="card_3" aria-label="Floating label select example" required>
                      <option>Select Cards</option>
                      @foreach($data['cards'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['card_3'])) @if($editData['card_3'] == $value['id']) selected="selected" @endif @endif>{{$value['title']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingCardId3">Card 3</label>
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
        <h5 class="card-header">Combo List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Card 1</th>
              <th>Card 2</th>
              <th>Card 3</th>
              <th>Status</th>
              <th>Date</th>
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
                        <td>{{$pvalue['card_1']}}</td>
                        <td>{{$pvalue['card_2']}}</td>
                        <td>{{$pvalue['card_3']}}</td>
                        <td>{{$pvalue['status'] == 1 ? "Active" : "In-Active"}}</td>
                        <td>{{$pvalue['date']}}</td>
                        <td>
                          <a href="{{ route('combo.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-circle-line ri-20px"></i></button></a>

                          <form action="{{ route('combo.destroy', $pvalue['id'])}}" method="post">
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
<script src="{{ asset('vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('js/form-layouts.js') }}"></script>
@endsection 
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatables').DataTable();
  });
</script> -->