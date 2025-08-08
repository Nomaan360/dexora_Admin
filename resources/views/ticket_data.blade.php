@extends('include/layout')
@section('title', 'Tickets')


@section('customcss')
                         


@endsection
@section('content')
<!-- Basic Bootstrap Table -->
 <style>
  input.remarksInput {
  margin: 0px 10px;
  padding: 10px !important;
  box-shadow: none !important;
  outline: none !important;
  border: 1px solid #cfd0d6 !important;
}
.remarksForm{
  display: flex; align-items: center;
}

.remarksForm i.btn.btn-outline-danger {
    padding: 0px;
    min-width: 90px;
}

.pagination-wrapper {
  margin-top: 20px;
}

.pagination-wrapper nav {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 0 15px;
    flex-wrap: wrap;
}

/* .pagination-wrapper nav > div {
    flex-shrink: 0;
} */

.pagination-wrapper nav svg {
    width: 20px;
}

.pagination-wrapper nav > div > a, .pagination-wrapper nav > div > span {
  display: inline-block;
  background: #eeeef0 !important;
  border: 0 !important;
  border-radius: .5625rem;
  color: #3b4056;
}

/* .pagination-wrapper nav > div:nth-child(2) {}

.pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) {} */

.pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) span {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    box-shadow: 0 0 !important;
    gap: 3px;
    flex-wrap: wrap;
}

.pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) span a, .pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) span span {width: 38px;height: 38px;background: #eeeef0;border-radius: 100%;display: flex;align-items: center;justify-content: center;color: #3b4056;flex-wrap: wrap;}
.pagination-wrapper nav > div:nth-child(2) > div:nth-child(2) span span {
  border-color: #666cff !important;
  background-color: #666cff !important;
  color: #fff;
}

.pagination-wrapper nav > div:nth-child(2) p.text-sm.text-gray-700.leading-5 {
    margin-bottom: 4px;
}

.layout-navbar.navbar-detached.container-xxl {
    max-width: calc(1920px - 1.5rem* 2);
}
@media (min-width: 1400px) {
    .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
        max-width: 1920px;
    }
}
 </style>
<div class="card">
  <h5 class="card-header">Ticket Data</h5>
  <div class="card-datatable text-nowrap">
    <div class="dataTables_wrapper">
      <form action="{{ route('ticket_data') }}" method="GET">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="srno" class="form-control dt-input dt-full-name" @if(isset($srno)) value="{{$srno}}" @endif data-column="1" placeholder="101,102" data-column-index="0">
                  <label>Sr Number</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-4 mb-3">
                <div class="form-floating form-floating-outline">
                  <input type="text" name="email" class="form-control dt-input" @if(isset($email)) value="{{$email}}" @endif data-column="2" placeholder="demo@example.com" data-column-index="1">
                  <label>Email</label>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"><span class="tf-icons ri-search-line ri-16px me-2"></span> Search</button>
              </div>
            </div>
          </div>
        </div>
          <div class="row">
            <div class="col-sm-12 col-md-6 mt-5 mt-md-0">
              <div class="dataTables_length">
                <label for="rows" class="">
                  <span class="flex-shrink-0">Rows per page:</span>
                  <select name="rows" id="rows" onchange="this.form.submit()" class="form-select form-select-sm">
                      <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                      <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                      <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                      <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                      <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                      <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                      <option value="250" {{ $perPage == 250 ? 'selected' : '' }}>250</option>
                  </select>
                </label>
              </div>
            </div>
            <!-- <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">
              <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>Search:
                  <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="DataTables_Table_0">
                </label>
              </div>
            </div> -->
          </div>
      </form>
      <div class="table-responsive">
        <table class="datatables-basic table table-bordered" id="datatables">
          <thead>
            <tr>
              <th>Sr NO.</th>
              <th>Username</th>
              <th>Usermail</th>
              <th>Reference Name</th>
              <th>No. of tickets</th>
              <th>Types of tickets</th>
              <th>Line Id</th>
              <th>Reference Number</th>
              <th>screenshot</th>
              <th colspan="2">Action</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @foreach ($tickets as $ticket )
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->username }}</td>
                <td>{{ $ticket->usermail }}</td>
                <td>{{ $ticket->reference_name }}</td>
                <td>{{ $ticket->numoftickets }}</td>
                <td>{{ $ticket->typeoftickets }}</td>
                <td>{{ $ticket->lineid }}</td>
                <td>{{ $ticket->id }}{{ $ticket->reference_number }}</td>
                <td><a href="{{ asset('storage/'.$ticket->screenshot) }}" target="_blank">View</a></td>
                @if($ticket->status==0)
                <td class="">
                  <div class="d-flex flex-column">
                    <!-- <a class="btn btn-outline-success" href="{{ url(route('ticket_approve', ['id' => $ticket->id])) }}" onclick="return confirmDelete();">Approve</a> -->
                    <form method="post" action="{{route('ticket_approve', ['id' => $ticket->id])}}" class="remarksForm flex-shrink-0 mb-3">
                      @csrf
                      <input type="text" name="numoftickets" value="{{$ticket->numoftickets}}" placeholder="Enter Number Of Tickets" class="w-100 form-control remarksInput mx-0 flex-grow-1" required>
                      <input type="hidden" name="id" value="{{$ticket->id}}">
                      <button type="submit" class="btn btn-outline-success flex-shrink-0 ms-2" value="Approve" name="submit" onclick="return confirmDelete();">Approve</button>
                    </form>
                    <form method="post" action="{{route('ticket_reject')}}" class="remarksForm flex-shrink-0">
                      @csrf
                      <input type="text" name="remarks" placeholder="Enter your remarks" class="w-100 form-control remarksInput mx-0 flex-grow-1">
                      <input type="hidden" name="id" value="{{$ticket->id}}">
                      <button type="submit" class="btn btn-outline-danger flex-shrink-0 ms-2" value="Reject" name="submit" onclick="return confirmDelete();">Reject</button>
                    </form>
                  </div>
                </td>
                @elseif($ticket->status==2)
                <td><a class="btn btn-outline-danger">Rejected</a></td>
                @else
                
                  <td class="text-nowrap">
                    @if($ticket->mail_status == 0)
                      <a class="btn btn-outline-success" href="{{ url(route('ticket_sendmail', ['id' => $ticket->id, 'ticketType' => $ticket->typeoftickets])) }}">SEND MAIL {{$ticket->typeoftickets}}</a>
                    @else
                      <a class="btn btn-outline-success" href="{{ url(route('ticket_sendmail', ['id' => $ticket->id, 'ticketType' => $ticket->typeoftickets])) }}">RE-SEND MAIL {{$ticket->typeoftickets}}</a>
                    @endif
                    <a class="btn btn-outline-success" href="{{asset('storage/tickets/ticket_'.$ticket->id.'.pdf')}}" download="download">DOWNLOAD {{$ticket->typeoftickets}}</a>
                  </td>
                  <!-- @if($ticket->mail_status == 0)
                  <td class="text-nowrap">
                    <a class="btn btn-outline-success" href="{{ url(route('ticket_sendmail', ['id' => $ticket->id, 'ticketType' => 'Only Lottery'])) }}">SEND MAIL (Only Lottery)</a>
                    <a class="btn btn-outline-success" href="{{ url(route('ticket_sendmail', ['id' => $ticket->id, 'ticketType' => 'Entry Pass'])) }}">SEND MAIL (Entry Pass)</a>
                    <a class="btn btn-outline-success" href="{{ url(route('ticket_sendmail', ['id' => $ticket->id, 'ticketType' => 'Combo Entry'])) }}">SEND MAIL (Combo Entry)</a>
                  </td>
                @else
                @endif -->
    
                @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="pagination-wrapper">
          {{ $tickets->appends(['rows' => $perPage])->links() }}        
      </div>
    </div>
  </div>
</div>
<!--/ Basic Bootstrap Table -->


@endsection
@section('customjs')

<script>
    // Store the scroll position before the page reloads
    window.onbeforeunload = function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    };

    // Restore the scroll position after the page reloads
    window.onload = function() {
        const scrollPosition = localStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, scrollPosition);
            localStorage.removeItem('scrollPosition'); // Clean up
        }
    };
</script>

@endsection 
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#datatables').DataTable();
  });
</script> -->