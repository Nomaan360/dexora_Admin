@extends('include/layout')
@section('title', 'Tasks')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Add Tasks</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      @if(isset($data['editData']))
      @php
      $editData = $data['editData'];
      @endphp
      <form action="{{ route('tasks.update', $editData['id']) }}" enctype="multipart/form-data" method="post">
        {{ method_field("PUT") }}
      @else
      <form action="{{ route('tasks.store') }}" enctype="multipart/form-data" method="POST">
        {{ method_field("POST") }}
      @endif 
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="title" id="inputName" @if(isset($editData['title'])) value="{{$editData['title']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Tasks title" data-column-index="0" required>
                  <label for="inputName">Tasks Title</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="description" id="inputdescription" @if(isset($editData['description'])) value="{{$editData['description']}}" @endif class="form-control dt-input dt-full-name" data-column="2" placeholder="Enter Tasks description" data-column-index="0" required>
                  <label for="inputdescription">Tasks description</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="url" id="inputurl" @if(isset($editData['url'])) value="{{$editData['url']}}" @endif class="form-control dt-input dt-full-name" data-column="3" placeholder="Enter Tasks url" data-column-index="0" required>
                  <label for="inputurl">Tasks Url</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="amount" id="inputReward" @if(isset($editData['amount'])) value="{{$editData['amount']}}" @endif class="form-control dt-input dt-full-name" data-column="1" placeholder="Enter Tasks Reward" data-column-index="0" required>
                  <label for="inputReward">Tasks Reward</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="form-select" id="floatingSocialMedia" name="social_media" aria-label="Floating label select example" required>
                      <option>Select Social Media</option>
                      <option value="Instagram" @if(isset($editData['social_media'])) @if($editData['social_media'] == "Instagram") selected="selected" @endif @endif>Instagram</option>
                      <option value="Facebook" @if(isset($editData['social_media'])) @if($editData['social_media'] == "Facebook") selected="selected" @endif @endif>Facebook</option>
                      <option value="Twitter" @if(isset($editData['social_media'])) @if($editData['social_media'] == "Twitter") selected="selected" @endif @endif>X</option>
                      <option value="YouTube" @if(isset($editData['social_media'])) @if($editData['social_media'] == "YouTube") selected="selected" @endif @endif>Youtube</option>
                      <option value="Telegram" @if(isset($editData['social_media'])) @if($editData['social_media'] == "Telegram") selected="selected" @endif @endif>Telegram</option>
                  </select>
                  <label for="floatingSocialMedia">Tasks Status</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="form-floating form-floating-outline">
                  <select class="form-select" id="floatingSelect" name="status" aria-label="Floating label select example" required>
                      <option>Select Status</option>
                      <option value="1" @if(isset($editData['status'])) @if($editData['status'] == 1) selected="selected" @endif @endif>Active</option>
                      <option value="0" @if(isset($editData['status'])) @if($editData['status'] == 0) selected="selected" @endif @endif>In-Active</option>
                  </select>
                  <label for="floatingSelect">Tasks Status</label>
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
        <h5 class="card-header">Ads List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Name</th>
              <th>Description</th>
              <th>Social Media</th>
              <th>Amount</th>
              <th>Url</th>
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
                        <td>{{$pvalue['title']}}</td>
                        <td>{{$pvalue['description']}}</td>
                        <td>{{$pvalue['social_media']}}</td>
                        <td>{{$pvalue['amount']}}</td>
                        <td>{{$pvalue['url']}}</td>
                        <td>{{$pvalue['status'] == 1 ? "Active" : "In-Active"}}</td>
                        <td>
                          <a href="{{ route('tasks.edit',$pvalue['id'])}}"><button style="float:left;" type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill delete-record waves-effect waves-light"><i class="ri-edit-circle-line ri-20px"></i></button></a>

                          <form action="{{ route('tasks.destroy', $pvalue['id'])}}" method="post">
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