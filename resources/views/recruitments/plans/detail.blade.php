<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="25%">Name</th>
                <th width="10%">Date</th>
                <th width="10%">Status</th>
            </tr>
            </thead>
            <tbody>
            @php
                $arrSelection = array("verification" => "Verification", "psychological" => "Psychological", "hr" => "Interview HR",
                "user" => "Interview User", "mcu" => "MCU", "final" => "Passed");
            @endphp
            @if(!$applicants->isEmpty())
                @foreach($applicants as $key => $r)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td>
                            {{ $r->name }}<br>
                            <i><b>{{ $r->applicant_number }}</b></i>
                        </td>
                        <td>{{ setDate($r->input_date) }}</td>
                        <td>
                            @if($r->selection_result == 't')
                                <div class="badge badge-success">{{ $arrSelection[$r->selection_step] }}</div>
                            @else
                                <div class="badge badge-danger">{{ $arrSelection[$r->selection_step] }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" align="center">-- Empty Data --</td>
                </tr>
            @endif
            </tbody>
            <tfoot>

            </tfoot>
        </table>
{{--        {{ generatePagination($applicants) }}--}}
        <form action="" id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" style="display: none">
        </form>
    </div>
</div>
