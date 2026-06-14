@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      @if(session('success'))
        <div class="alert alert-success text-white">
          {{ session('success') }}
        </div>
      @endif

      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="text-primary font-weight-bolder">Vehicle Type <span class="text-dark font-weight-normal">Data Table</span></h6>
          <a href="{{ route('vehicletype.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+ ADD NEW VEHICLE TYPE</a>
        </div>
        <div class="card-body px-0 pt-0 pb-2 mt-3">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">NO</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">VEHICLE TYPE</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">FIRST HOUR</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">NEXT HOUR</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">MAX PER DAY</th>
                </tr>
              </thead>
              <tbody>
                @foreach($vehicleTypes as $key => $vt)
                <tr>
                  <td class="align-middle text-center"><span class="text-sm font-weight-bold">{{ $key + 1 }}</span></td>
                  <td><span class="text-sm font-weight-bold text-uppercase">{{ $vt->jenis }}</span></td>
                  <td class="align-middle text-center"><span class="text-sm font-weight-bold">{{ $vt->perjam_pertama }}</span></td>
                  <td class="align-middle text-center"><span class="text-sm font-weight-bold">{{ $vt->perjam_berikutnya }}</span></td>
                  <td class="align-middle text-center"><span class="text-sm font-weight-bold">{{ $vt->max_perhari }}</span></td>
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
<div class="page-footer">© 2026, made with ❤️ by <a href="#">Coding Lover</a> for ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.</div>
@endsection