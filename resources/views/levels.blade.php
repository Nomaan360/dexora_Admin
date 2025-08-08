@extends('include/layout')
@section('title', 'Levels')


@section('customcss')
<link rel="stylesheet" href="{{ asset('vendor/libs/select2/select2.css') }}" /> 
@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Add Levels</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      @if(isset($data['editData']))
      @php
      $editData = $data['editData'];
      @endphp
      <form action="{{ route('levels.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
        {{ method_field("PUT") }}
      @else
      <form action="{{ route('levels.store') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
      @endif 
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">              
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="select2 form-select" id="floatingCategoryId" name="category_id" aria-label="Floating label select example" required>
                      <option>Select Category</option>
                      @foreach($data['category'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['category_id'])) @if($editData['category_id'] == $value['id']) selected="selected" @endif @endif>{{$value['name']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingCategoryId">Catregory</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="select2 form-select" id="floatingCardId" name="card_id" aria-label="Floating label select example" required>
                      <option>Select Cards</option>
                      @foreach($data['cards'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['card_id'])) @if($editData['card_id'] == $value['id']) selected="selected" @endif @endif>{{$value['title']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingCardId">Card</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="level" id="inputlevel" @if(isset($editData['level'])) value="{{$editData['level']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Card level" data-column-index="0" required>
                  <label for="inputlevel">Card Level</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="income" id="inputincome" @if(isset($editData['income'])) value="{{$editData['income']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Card Income" data-column-index="0" required>
                  <label for="inputincome">Card Level Income</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="amount" id="inputamount" @if(isset($editData['amount'])) value="{{$editData['amount']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Card amount" data-column-index="0" required>
                  <label for="inputamount">Card Level Amount</label>
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
                  <select class="form-select" id="floatingConditionId" name="condition_id" aria-label="Floating label select example" required>
                      <option value="NULL" @if(isset($editData['condition_id'])) @if($editData['condition_id'] == NULL) selected="selected" @endif @endif>None</option>
                      <option value="0" @if(isset($editData['condition_id'])) @if($editData['condition_id'] == 0) selected="selected" @endif @endif>Referral</option>
                      @foreach($data['cards'] as $key => $value)
                        <option value="{{$value['id']}}" @if(isset($editData['condition_id'])) @if($editData['condition_id'] == $value['id']) selected="selected" @endif @endif>{{$value['title']}}</option>
                      @endforeach
                  </select>
                  <label for="floatingConditionId">Condition</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="open" id="inputopen" @if(isset($editData['open'])) value="{{$editData['open']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Open Number" data-column-index="0" required>
                  <label for="inputopen">Open Level</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="time" id="inputtime" @if(isset($editData['time'])) value="{{$editData['time']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Time in Seconds" data-column-index="0" required>
                  <label for="inputtime">Time (Seconds)</label>
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
        <h5 class="card-header">Category List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>level</th>
              <th>Card</th>
              <th>Amount</th>
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
                        <td>{{$pvalue['level']}}</td>
                        <td>{{$pvalue['title']}}</td>
                        <td>{{$pvalue['amount']}}</td>
                        <td>{{$pvalue['status'] == 1 ? "Active" : "In-Active"}}</td>
                        <td>
                          <a href="{{ route('levels.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-circle-line ri-20px"></i></button></a>

                          <form action="{{ route('levels.destroy', $pvalue['id'])}}" method="post">
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