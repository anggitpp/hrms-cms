@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-2 mb-2 mb-md-0">
            <ul class="nav nav-pills flex-column nav-left">
                <li class="nav-item">
                    <a class="nav-link active" id="profile" data-toggle="pill" href="#tab-profile" aria-expanded="true">
                        <i data-feather="user" class="font-medium-3 mr-1"></i>
                        <span class="font-weight-bold">Identitas</span>
                    </a>
                </li>
                @if(isset($access['contact']))
                    <li class="nav-item">
                        <a class="nav-link" id="contact" data-toggle="pill" href="#tab-contact" aria-expanded="false">
                            <i class="fas fa-address-book"></i>
                            <span class="font-weight-bold">Kontak</span>
                        </a>
                    </li>
                @endif
                @if(isset($access['family']))
                <li class="nav-item">
                    <a class="nav-link" id="family" data-toggle="pill" href="#tab-family" aria-expanded="false">
                        <i class="fa fa-users"></i>
                        <span class="font-weight-bold">Keluarga</span>
                    </a>
                </li>
                @endif
                @if(isset($access['education']))
                    <li class="nav-item">
                        <a class="nav-link" id="education" data-toggle="pill" href="#tab-education" aria-expanded="false">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="font-weight-bold">Pendidikan</span>
                        </a>
                    </li>
                @endif
                @if(isset($access['work']))
                    <li class="nav-item">
                        <a class="nav-link" id="work" data-toggle="pill" href="#tab-work" aria-expanded="false">
                            <i class="fas fa-briefcase"></i>
                            <span class="font-weight-bold">Riwayat Kerja</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!--/ left menu section -->

        <!-- right content section -->
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- general tab -->
                        <div role="tabpanel" class="tab-pane active" id="tab-profile" aria-labelledby="profile" aria-expanded="true">
                            @include('recruitments.applicants.identity')
                        </div>
                        <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact" aria-expanded="false">
                            @include('recruitments.applicants.contact')
                        </div>
                        <div class="tab-pane fade" id="tab-family" role="tabpanel" aria-labelledby="family" aria-expanded="false">
                            @include('recruitments.applicants.family')
                        </div>
                        <div class="tab-pane fade" id="tab-education" role="tabpanel" aria-labelledby="education" aria-expanded="false">
                            @include('recruitments.applicants.education')
                        </div>
                        <div class="tab-pane fade" id="tab-work" role="tabpanel" aria-labelledby="work" aria-expanded="false">
                            @include('recruitments.applicants.work')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-side-modal-form title="Form Data"/>
    <x-modal-form title="Form Contract" size="modal-lg"/>
@endsection
