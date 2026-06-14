@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="text-primary font-weight-bolder">Location & Capacity <span class="text-dark font-weight-normal">Report</span></h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2 mt-3">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr class="bg-light">
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Location Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Max Motorcycle</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Max Car</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Max Other/Truck</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Available Motor</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Available Car</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Available Truck</th>
                </tr>
              </thead>
              <tbody>
                @foreach($locations as $key => $loc)
                <tr class="text-sm font-weight-bold text-dark">
                  <td class="text-center">{{ $key + 1 }}</td>
                  <td><i class="fa-solid fa-building text-primary me-2"></i>{{ $loc->location_name }}</td>
                  <td class="text-center text-secondary">{{ $loc->max_motorcycle }} Slots</td>
                  <td class="text-center text-secondary">{{ $loc->max_car }} Slots</td>
                  <td class="text-center text-secondary">{{ $loc->max_other }} Slots</td>
                  <td class="text-center text-success">{{ $loc->getSisaSlot(1) }} Left</td>
                  <td class="text-center text-success">{{ $loc->getSisaSlot(2) }} Left</td>
                  <td class="text-center text-success">{{ $loc->getSisaSlot(3) }} Left</td>
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