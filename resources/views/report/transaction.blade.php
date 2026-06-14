@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-primary font-weight-bolder mb-0">Transactions Income <span class="text-dark font-weight-normal">Report</span></h6>
            <small class="text-muted text-xs font-weight-bold">All Time Data Log</small>
          </div>
        </div>
        
        <div class="card-body px-0 pt-0 pb-2 mt-3">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">No</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Ticket Number</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Police Number</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Location</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Vehicle Type</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Time In</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Time Out</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Duration</th>
                  <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Total Pays</th>
                </tr>
              </thead>
              <tbody>
                @foreach($tickets as $key => $t)
                <tr class="text-sm font-weight-bold text-dark">
                  <td class="text-center">{{ $key + 1 }}</td>
                  <td>#{{ $t->no_tiket }}</td>
                  <td class="text-uppercase">{{ $t->no_polisi }}</td>
                  <td class="text-center">{{ $t->lokasi->location_name ?? '-' }}</td>
                  <td class="text-center text-uppercase">{{ $t->jenisKendaraan->jenis ?? '-' }}</td>
                  <td class="text-center text-secondary">{{ $t->masuk }}</td>
                  <td class="text-center text-secondary">{{ $t->keluar ?? '-' }}</td>
                  <td class="text-center text-primary">{{ $t->total_jam ?? 0 }} Min</td>
                  <td class="text-center text-success">Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

</style>
<div class="page-footer">© 2026, made with ❤️ by <a href="#">Coding Lover</a> for ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.</div>
@endsection