@extends('layouts.app')

@section('title', 'Transaction')

@section('header_action')
    <div class="d-flex align-items-center gap-2">
        @foreach($vehicleTypes as $vt)
            <button class="btn btn-vehicle-type {{ $selectedVehicle == $vt->id ? 'bg-gradient-primary' : '' }}" onclick="window.location.href='?vehicle_id={{ $vt->id }}'">
                <i class="fa-solid @if(Str::contains(strtolower($vt->jenis), 'motor')) fa-motorcycle @elseif(Str::contains(strtolower($vt->jenis), 'car')) fa-car @else fa-truck @endif me-1"></i> 
                {{ strtoupper($vt->jenis) }}
            </button>
        @endforeach
        <button type="button" class="btn btn-enter-vehicle me-1" onclick="submitEnterForm()">
            <i class="fa-solid fa-plus me-1"></i> ENTER VEHICLE
        </button>
    </div>
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    html, body {
        width: 100%;
        max-width: 100vw;
        overflow-x: clip !important; 
        position: relative;
    }
    .g-sidenav-show,
    .main-content,
    .container-fluid {
        max-width: 100% !important;
        overflow-x: clip !important;
    }
    .row {
        margin-right: 0 !important;
        margin-left: 0 !important;
        --bs-gutter-x: 0 !important; 
    }
    .row > * {
        padding-right: 15px !important;
        padding-left: 15px !important;
    }
    .locations-col {
        flex: 1;
        min-width: 0;
    }
    .ticket-list-wrapper {
        max-height: 380px;   
        overflow-y: auto;
        overflow-x: hidden;  
        padding-right: 5px;  
    }
    .ticket-list-wrapper::-webkit-scrollbar {
        width: 6px;
    }
    .ticket-list-wrapper::-webkit-scrollbar-thumb {
        background: #cb0c9f; 
        border-radius: 10px;
    }
    .ticket-list-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    body, .content-area { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f6fb; }
    .btn-vehicle-type { background-color: #1e2a45; color: #ffffff; font-weight: 700; font-size: 0.78rem; padding: 8px 16px; border-radius: 8px; border: none; letter-spacing: 0.5px; transition: background 0.2s, transform 0.1s; }
    .btn-vehicle-type:hover { background-color: #2d3e60; color: #fff; transform: translateY(-1px); }
    .btn-enter-vehicle { background-color: #c026d3; color: #ffffff; font-weight: 700; font-size: 0.78rem; padding: 8px 18px; border-radius: 8px; border: none; letter-spacing: 0.5px; box-shadow: 0 4px 14px rgba(192, 38, 211, 0.4); transition: background 0.2s, box-shadow 0.2s, transform 0.1s; }
    .btn-enter-vehicle:hover { background-color: #a21caf; color: #fff; box-shadow: 0 6px 18px rgba(192, 38, 211, 0.55); transform: translateY(-1px); }
    
    .clock-card { position: relative; border-radius: 16px; color: #fff; padding: 24px 20px; text-align: center; height: 100%; box-shadow: 0 8px 24px rgba(30, 60, 114, 0.35); display: flex; flex-direction: column; align-items: center; justify-content: center; background-image: url("{{ asset('assets/img/curved-images/curved-11.jpg') }}"); background-size: cover; background-position: center; overflow: hidden; }
    .clock-card::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.35); z-index: 0; }
    .clock-card > * { position: relative; z-index: 1; }
    .clock-card .day-name { font-size: 1.15rem; font-weight: 600; margin-bottom: 2px; }
    .clock-card .date-full { font-size: 0.78rem; opacity: 0.9; }
    .clock-card .clock-time { font-size: 2.1rem; font-weight: 800; margin-top: 14px; letter-spacing: 2px; }

    .location-card { border: 2px solid #c026d3; border-radius: 16px; padding: 16px 14px; text-align: center; min-width: 148px; background: #fff; box-shadow: 0 4px 16px rgba(192, 38, 211, 0.1); transition: all 0.2s; flex-shrink: 0; cursor: pointer; }
    .location-icon-wrap { width: 50px; height: 50px; border-radius: 50%; background-color: #c026d3; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; box-shadow: 0 4px 12px rgba(192, 38, 211, 0.35); }
    .location-icon-wrap i { color: #fff; font-size: 1.2rem; }
    .location-name { font-size: 0.9rem; font-weight: 700; color: #1e2a45; margin-bottom: 10px; }
    .location-capacity { display: flex; justify-content: space-around; font-size: 0.8rem; font-weight: 600; }
    .locations-scroll { display: flex; gap: 14px; overflow-x: auto; padding-bottom: 4px; }

    .form-card { 
        background: #ffffff; 
        border-radius: 16px; 
        padding: 32px 28px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.07); 
        border: none;
        min-height: 280px; 
    }    .form-card .form-title { font-size: 1.15rem; font-weight: 800; color: #c026d3; }
    .form-card .form-control { background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 1.35rem; font-weight: 600; color: #1e2a45; padding: 12px 16px; }
    .btn-exit-vehicle { background-color: #1e2a45; color: #fff; font-weight: 700; font-size: 0.82rem; padding: 10px 20px; border-radius: 10px; border: none; display: flex; align-items: center; gap: 8px; }

    .tickets-card { 
        background: #ffffff; 
        border-radius: 16px; 
        padding: 24px 20px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.07); 
        height: 100%; 
        min-height: 450px; 
        display: flex;
        flex-direction: column;
    }    
    .tickets-card .tickets-header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 12px; border-bottom: 1.5px solid #f3f4f6; margin-bottom: 16px; }
    .btn-view-all { font-size: 0.75rem; font-weight: 700; color: #c026d3; border: 1.5px solid #c026d3; border-radius: 8px; padding: 4px 14px; background: transparent; }
    .ticket-item { display: flex; justify-content: space-between; align-items: center; background: #f9fafb; border: 1.5px solid #f0f0f5; border-radius: 12px; padding: 12px 14px; margin-bottom: 10px; cursor: pointer; }
    .ticket-plate { font-size: 0.72rem; font-weight: 600; background: #6b7280; color: #fff; border-radius: 5px; padding: 2px 8px; }
    .pdf-link { color: #ef4444; font-size: 1.5rem; }
    .top-row-wrapper { display: flex; gap: 16px; align-items: stretch; margin-bottom: 20px; }
    .clock-col { flex: 0 0 200px; }
    .locations-col { flex: 1; overflow: hidden; }
    .page-footer { text-align: center; font-size: 0.75rem; color: #adb5bd; margin-top: 24px; }
</style>

<script>
    function showSwal({title, text=null, html=null, icon, confirmText='OK', confirmColor='#c026d3', redirectUrl=null}) {
        Swal.fire({ title, text: html ? undefined : text, html, icon, confirmButtonText: confirmText, confirmButtonColor: confirmColor, backdrop: 'rgba(0,0,0,0.45)' }).then((result) => {
            if (redirectUrl && result.isConfirmed) window.open(redirectUrl, '_blank');
        });
    }

    @if(session('masuk_success'))
        showSwal({ title: 'Success!', text: 'Kendaraan berhasil masuk.', icon: 'success', confirmText: 'Lihat Tiket', redirectUrl: '/transactions/ticket/{{ session("masuk_success") }}' });
    @endif

    @if(session('error'))
        showSwal({ title: 'Error!', text: '{{ session("error") }}', icon: 'error' });
    @endif

    @if(session('keluar_success'))
        showSwal({ title: 'Transaction Success', html: '<div style="font-size:14px;text-align:center;">Total Bayar : <b>Rp {{ number_format(session("keluar_success")->total_bayar, 0, ",", ".") }}</b><br>Durasi: {{ session("keluar_success")->total_jam }} Menit</div>', icon: 'success', confirmText: 'Selesai' });
    @endif
</script>

<form id="hidden-enter-form" action="/transactions/enter" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="id_jenis" value="{{ $selectedVehicle }}">
    <input type="hidden" name="id_lokasi" id="hidden-id-lokasi">
</form>

<div class="row g-4">
    <div class="col-md-8">
        <div class="top-row-wrapper">
            <div class="clock-col">
                <div class="clock-card">
                    <img src="{{ asset('assets/img/parkir.png') }}" alt="Logo Parkir" style="max-height: 45px; margin-bottom: 10px;" />
                    <div class="day-name" id="dayName">Loading...</div>
                    <div class="date-full" id="dateFull">Loading...</div>
                    <div class="clock-time" id="clock">00:00:00</div>
                </div>
            </div>
            <div class="locations-col">
                <div class="locations-scroll h-100 align-items-stretch">
                    @foreach($locations as $loc)
                    @php
                        $sisaMotor = $loc->getSisaSlot(1); $sisaCar = $loc->getSisaSlot(2); $sisaOther = $loc->getSisaSlot(3);
                    @endphp
                    <div class="location-card" id="card-loc-{{ $loc->id }}" onclick="selectBuildingCard({{ $loc->id }}, this)">
                        <div class="location-icon-wrap"><i class="fa-solid fa-building"></i></div>
                        <div class="location-name">{{ $loc->location_name }}</div>
                        
                        <div class="location-capacity border-bottom pb-1 mb-1 text-muted" style="font-size:0.68rem; opacity:0.7;">
                            <span>Mtr:{{ $loc->max_motorcycle }}</span> <span>Mbl:{{ $loc->max_car }}</span> <span>Trk:{{ $loc->max_other }}</span>
                        </div>
                        <div class="location-capacity">
                            <span style="color: {{ $sisaMotor <= 0 ? '#dc2626' : '#2dce89' }};"><i class="fa-solid fa-motorcycle"></i> {{ $sisaMotor }}</span>
                            <span style="color: {{ $sisaCar <= 0 ? '#dc2626' : '#2dce89' }};"><i class="fa-solid fa-car"></i> {{ $sisaCar }}</span>
                            <span style="color: {{ $sisaOther <= 0 ? '#dc2626' : '#2dce89' }};"><i class="fa-solid fa-truck"></i> {{ $sisaOther }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-card">
            <form action="/transactions/exit" method="POST">
                @csrf
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="form-title">Transaction <span>Input Form</span></h5>
                    <button type="submit" class="btn-exit-vehicle"><i class="fa-solid fa-arrow-right-from-bracket"></i> EXIT VEHICLE</button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs font-weight-bold text-muted">Ticket Number</label>
                        <input type="text" class="form-control text-uppercase" name="no_tiket" id="exit-ticket-no" placeholder="Ticket Number" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-xs font-weight-bold text-muted">Police Number</label>
                        <input type="text" class="form-control text-uppercase" name="no_polisi" id="exit-police-no" placeholder="Police Number" required>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="tickets-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="text-dark font-weight-bold mb-0">Active Tickets</h6>
                <button type="button" class="btn btn-outline-primary btn-xs mb-0 px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewAllModal">
                    View All
                </button>
            </div>
            <div class="ticket-list-wrapper">
                @forelse($tickets as $t)
                
                <div class="ticket-item" 
                     @if($t->keluar == null) onclick="populateExitFields('{{ $t->no_tiket }}')" @endif
                     style="display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 12px 10px; {{ $t->keluar != null ? 'background-color: #f8f9fa; opacity: 0.85; cursor: default;' : 'cursor: pointer;' }}">
                    
                    <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px;">
                        <div style="font-size: 0.72rem; color: #8392ab; font-weight: 600;">
                            {{ date('Y-m-d H:i:s', strtotime($t->masuk)) }}
                        </div>
                        
                        <div class="ticket-no" style="font-size: 0.78rem; font-weight: bold; color: #344767;">
                            #{{ $t->no_tiket }}
                        </div>
                        
                        <div class="mt-1">
                            <span class="badge bg-gradient-dark text-uppercase" style="font-size: 0.65rem; padding: 4px 8px;">
                                {{ strtolower($t->jenisKendaraan->jenis ?? '') == 'other' ? 'truck/bus/other' : ($t->jenisKendaraan->jenis ?? 'Vehicle') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-end d-flex align-items-center gap-2" style="white-space: nowrap;">
                        @if($t->keluar == null)
                            <span class="ticket-price text-nowrap d-inline-flex align-items-center" style="color:#e91e63; font-size:0.75rem; font-weight: bold;">
                                <i class="fa-solid fa-circle shadow-sm me-1" style="font-size: 0.5rem;"></i>Parked
                            </span>
                        @else
                            <span class="text-nowrap d-inline-flex align-items-center font-weight-bold" style="color:#2dce89; font-size:0.75rem;">
                                Rp{{ number_format($t->total_bayar, 0, ',', '.') }}
                            </span>
                        @endif
                        
                        <a href="/transactions/ticket/{{ $t->id }}" target="_blank" class="pdf-link ms-1"><i class="fa-solid fa-file-pdf"></i></a>
                    </div>

                </div>
                @empty
                <div class="text-center my-4 py-3">
                    <i class="fa-solid fa-ticket-simple text-muted mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                    <p class="text-sm text-muted font-weight-bold mb-0">No Transactions Today</p>
                </div>
                @endforelse
            </div>
        </div>
</div>

<div class="modal fade" id="viewAllModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-white p-3">
        <h5 class="modal-title text-dark font-weight-bold" id="viewAllModalLabel">All Transactions</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive">
          <table class="table align-items-center mb-0">
            <thead class="bg-light">
              <tr>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">No</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Ticket</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Ticket Number</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">Police Number</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Location Name</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Vehicle Type</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Time In</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Time Out</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">First Hours Charges</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Next Hourly Charges</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Max Cost Per Day</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Total Hours</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Total Days</th>
                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 text-center">Total Pays</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tickets as $key => $t)
              <tr class="text-sm font-weight-bold text-dark">
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">
                    <a href="/transactions/ticket/{{ $t->id }}" target="_blank" class="text-danger" style="font-size: 1.3rem; transition: transform 0.15s; display: inline-block;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                </td>
                <td>#{{ $t->no_tiket }}</td>
                <td class="text-uppercase">{{ $t->no_polisi }}</td>
                <td class="text-center">{{ $t->lokasi->location_name ?? '-' }}</td>
                <td class="text-center text-uppercase">{{ $t->jenisKendaraan->jenis ?? '-' }}</td>
                <td class="text-center text-secondary">{{ $t->masuk }}</td>
                <td class="text-center text-secondary">{{ $t->keluar ?? '-' }}</td>
                <td class="text-center">Rp {{ number_format($t->perjam_pertama ?? ($t->jenisKendaraan->perjam_pertama ?? 0), 0, ',', '.') }}</td>
                <td class="text-center">Rp {{ number_format($t->perjam_berikutnya ?? ($t->jenisKendaraan->perjam_berikutnya ?? 0), 0, ',', '.') }}</td>
                <td class="text-center">Rp {{ number_format($t->max_perhari ?? ($t->jenisKendaraan->max_perhari ?? 0), 0, ',', '.') }}</td>
                <td class="text-center text-primary">{{ $t->total_jam ?? 0 }} Min</td>
                <td class="text-center">{{ $t->keluar ? '1' : '0' }}</td>
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

<div class="page-footer">© 2026, made with ❤️ by <a href="#">Coding Lover</a> for ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.</div>

<div class="row g-4">
<form id="hidden-enter-form" action="/transactions/enter" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="id_jenis" value="{{ $selectedVehicle }}">
    <input type="hidden" name="id_lokasi" id="hidden-id-lokasi">
</form>

<div class="container-fluid py-4        ">
    
    <div class="row g-4">
        <div class="col-md-8">
            </div>

        <div class="col-md-4">
            </div>
    </div>

</div> {{-- MODAL POP-UP VIEW ALL TICKETS --}}
<div class="modal fade" id="viewAllModal" tabindex="-1" aria-hidden="true">
<script>
    function selectBuildingCard(locId, element) {
        document.querySelectorAll('.location-card').forEach(card => {
            card.style.border = '2px solid #c026d3';
            card.style.boxShadow = '0 4px 16px rgba(192, 38, 211, 0.1)';
        });
        element.style.border = '3px solid #1e2a45';
        element.style.boxShadow = '0 6px 20px rgba(30, 42, 69, 0.35)';
        document.getElementById('hidden-id-lokasi').value = locId;
    }

    function submitEnterForm() {
        const locId = document.getElementById('hidden-id-lokasi').value;
        if (!locId) {
            Swal.fire({ title: 'Peringatan!', text: 'Silakan pilih/klik salah satu kartu gedung terlebih dahulu!', icon: 'warning', confirmButtonColor: '#c026d3' });
            return;
        }
        document.getElementById('hidden-enter-form').submit();
    }

    function populateExitFields(ticketNo) {
        document.getElementById('exit-ticket-no').value = ticketNo;
        document.getElementById('exit-police-no').value = '';
        document.getElementById('exit-police-no').focus();
    }

    function updateCibinongTime() {
        const now = new Date();
        const timeOptions = { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        document.getElementById('clock').textContent = new Intl.DateTimeFormat('en-US', timeOptions).format(now).replace(/\./g, ':');
        document.getElementById('dayName').textContent = new Intl.DateTimeFormat('en-US', { timeZone: 'Asia/Jakarta', weekday: 'long' }).format(now);
        document.getElementById('dateFull').textContent = new Intl.DateTimeFormat('en-US', { timeZone: 'Asia/Jakarta', day: '2-digit', month: 'long', year: 'numeric' }).format(now);
    }
    setInterval(updateCibinongTime, 1000);
    updateCibinongTime();
</script>
</div>
@endsection