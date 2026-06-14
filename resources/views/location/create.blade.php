@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
    <div class="col-12">
        <div class="card mb-4">
        <div class="card-header pb-0">
            <h6 class="text-primary font-weight-bolder">Location <span class="text-dark font-weight-normal">Input Form</span></h6>
        </div>
        <div class="card-body">
            <form action="{{ route('location.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label class="text-sm font-weight-bolder">Location Name</label>
                <input type="text" name="location_name" class="form-control" required placeholder="Gedung A">
            </div>
            <div class="form-group mb-3">
                <label class="text-sm font-weight-bolder">Max Motorcycle</label>
                <input type="number" name="max_motorcycle" class="form-control" required placeholder="3" min="0">
            </div>
            <div class="form-group mb-3">
                <label class="text-sm font-weight-bolder">Max Car</label>
                <input type="number" name="max_car" class="form-control" required placeholder="0" min="0">
            </div>
            <div class="form-group mb-4">
                <label class="text-sm font-weight-bolder">Max Truck/Bus/Other</label>
                <input type="number" name="max_other" class="form-control" required placeholder="0" min="0">
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('location.index') }}" class="btn btn-dark w-50 me-2">CANCEL</a>
                <button type="submit" class="btn btn-primary w-50 ms-2">SAVE LOCATION</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection