<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="2%">No</th>
            <th width="*">Aktifitass</th>
            <th width="10%">Kategori</th>
            <th width="10%">Model</th>
        </tr>
        </thead>
        <tbody>
        @if(!$targets->isEmpty())
            @foreach($targets as $key => $r)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $r->name }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @if(!$r->masters->isEmpty())
                    @foreach($r->masters as $k => $master)
                        <tr>
                            <td></td>
                            <td><span style="margin-left: 20px;">{{ strtolower(numToAlpha($k)).". ". $master->name }}</span></td>
                            <td>{{ $masters['AKKA'][$master->category_id] ?? '' }}</td>
                            <td>{{ $controlType[$master->control_type] ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
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
