@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6 class="text-primary font-weight-bolder">Vehicle Type <span class="text-dark font-weight-normal">Input Form</span></h6>
        </div>
        <div class="card-body">
          <form action="{{ route('vehicletype.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
              <label class="text-sm font-weight-bolder">Vehicle Type</label>
              <select name="jenis" class="form-control" required>
                  <option value="motorcycle">Motorcycle</option>
                  <option value="car">Car</option>
                  <option value="other">Truck/Bus/Other</option>
              </select>
            </div>
            <div class="form-group mb-3">
              <label class="text-sm font-weight-bolder">First Hour Price</label>
              <input type="number" name="perjam_pertama" class="form-control" required placeholder="Contoh: 2000" min="0">
            </div>
            <div class="form-group mb-3">
              <label class="text-sm font-weight-bolder">Next Hour Price</label>
              <input type="number" name="perjam_berikutnya" class="form-control" required placeholder="Contoh: 1000" min="0">
            </div>
            <div class="form-group mb-4">
              <label class="text-sm font-weight-bolder">Max Per Day Price</label>
              <input type="number" name="max_perhari" class="form-control" required placeholder="Contoh: 10000" min="0">
            </div>
            <div class="d-flex justify-content-between mt-4">
              <a href="{{ route('vehicletype.index') }}" class="btn btn-dark w-50 me-2">CANCEL</a>
              <button type="submit" class="btn bg-gradient-primary w-50 ms-2">SAVE VEHICLE TYPE</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection