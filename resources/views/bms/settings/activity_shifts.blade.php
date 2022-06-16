<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="2%">No</th>
            <th width="*">Nama</th>
            <th width="8%">Mulai</th>
            <th width="8%">Selesai</th>
            <th width="12%">Interval</th>
            <th width="5%">Urut</th>
            <th width="5%">Status</th>
        </tr>
        </thead>
        <tbody>
        @if(!$shifts->isEmpty())
            @foreach($shifts as $key => $r)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $r->name }}</td>
                    <td align="center">{{ $r->start }}</td>
                    <td align="center">{{ $r->end }}</td>
                    <td>{{ $masters['BKIV'][$r->interval_id] }}</td>
                    <td align="right">{{ $r->order }}</td>
                    <td>
                        @if($r->status == 't')
                            <div class="badge badge-success">Aktif</div>
                        @else
                            <div class="badge badge-danger">Tidak Aktif</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" align="center">-- Empty Data --</td>
            </tr>
        @endif
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>
