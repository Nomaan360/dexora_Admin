@extends('include/layout')
@section('title', 'Winners')
@section('customcss')
<link rel="stylesheet" href="{{ asset('vendor/libs/select2/select2.css') }}" /> 
@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Add Winners</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      @if(isset($data['editData']))
      @php
      $editData = $data['editData'];
      @endphp
      <form action="{{ route('winner.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
        {{ method_field("PUT") }}
      @else
      <form action="{{ route('winner.store') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
      @endif 
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="select2 form-select" id="floatingUserId" name="user_id" aria-label="Floating label select example" required data-allow-clear="true">
                      <option>Select Winning User</option>
                      @foreach($data['users'] as $key => $value)
                        <option value="{{$value['chat_id']}}" @if(isset($editData['user_id'])) @if($editData['user_id'] == $value['id']) selected="selected" @endif @endif>{{$value['name']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingUserId">Winning User</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="amount" id="inputamount" @if(isset($editData['amount'])) value="{{$editData['amount']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Amount" data-column-index="0" required>
                  <label for="inputamount">Amount</label>
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
        <h5 class="card-header">Winner List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Name</th>
              <th>Amount</th>
              <th>Facbook Story</th>
              <th>Instagram Story</th>
              <th>X Post</th>
              <th>BEP WA</th>
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
                        <td>{{$pvalue['name']}}</td>
                        <td>{{$pvalue['amount']}}</td>
                        <td><a target="_blank" href="{{$pvalue['facebook_story']}}">View</a></td>
                        <td><a target="_blank" href="{{$pvalue['instagram_story']}}">View</a></td>
                        <td><a target="_blank" href="{{$pvalue['x_post']}}">View</a></td>
                        <td>{{$pvalue['wallet_address']}}</td>
                        <td>
                          <a href="{{ route('winner.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-circle-line ri-20px"></i></button></a>

                          <form action="{{ route('winner.destroy', $pvalue['id'])}}" method="post">
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