<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="user-avatar-section">
                    <div class="d-flex align-items-center flex-column">
                        <img class="img-fluid rounded mt-1 mb-2" src="{{ asset('storage'.$emp->photo) }}" height="110" width="110" alt="User avatar">
                        <div class="user-info text-center">
                            <h4>{{ $emp->name }}</h4>
                            <span class="badge bg-light-secondary">{{ $masters['EJP'][$emp->contract->position_id] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h4 class="fw-bolder border-bottom pb-50 mb-1">Detail Pegawai</h4>
                <div class="info-container">
                    <table style="width: 100%">
                        <thead>
                        <tr>
                            <th width="20%"></th>
                            <th width="80%"></th>
                        </tr>
                        </thead>
                        <tr>
                            <td><b>NIK</b></td>
                            <td>{{ $emp->emp_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Tipe Pegawai</b></td>
                            <td>{{ $masters['ETP'][$emp->contract->type_id] }}</td>
                        </tr>
                        <tr>
                            <td><b>Pangkat</b></td>
                            <td>{{ $masters['EP'][$emp->contract->rank_id] }}</td>
                        </tr>
                        <tr>
                            <td><b>Lokasi Kerja</b></td>
                            <td>{{ $masters['ELK'][$emp->contract->location_id] }}</td>
                        </tr>
                        <tr>
                            <td><b>Penempatan</b></td>
                            <td>{{ $placement[$emp->contract->placement_id] }}</td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Masuk</b></td>
                            <td>{{ setDate($emp->join_date, 't') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>