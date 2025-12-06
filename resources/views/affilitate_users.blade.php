@extends('include/layout')
@section('title', 'Affiliate Users')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Affiliate User List</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      <div class="table-responsive">
        <h5 class="card-header">Affiliate User List</h5>
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Chat Id </th>
              <th>Wallet Address</th>
              <th>Telegram </th>
              <th>Phone</th>
              <th>Email</th>
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
                        <td>{{$pvalue->chat_id}}</td>
                        <td>{{$pvalue->wallet_address}}</td>
                        <td>{{$pvalue->telegram}}</td>
                        <td>{{$pvalue->countryCode}} {{$pvalue->phone}}</td>
                        <td>{{$pvalue->email}}</td>
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
@endsection
@section('customjs')
@endsection 
