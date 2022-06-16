<form id="form-edit" method="POST" class="form-validation"
      action="{{ route('payrolls.'.$arrMenu['target'].'.importData', [$month, $year]) }}"
      enctype="multipart/form-data" data-remote="true">
    @csrf
    <div id="formImport">
        <div class="row">
            <div class="col-md-12">
                <x-form.file label="File" name="filename" value="{{ $contract->filename ?? '' }}" />
            </div>
        </div>
        <a href="{{ asset('storage/templates/Format Template Payroll.xls') }}">
            <span class="float-right"><b>download template.xls</b></span>
        </a>
        <br clear="all"/>
        <br clear="all"/>
        <button type="button" class="btn btn-primary" style="width: 100%" id="btnSubmit">Simpan</button>
    </div>
    <div class="d-flex justify-content-center">
        <div id="loading" class="spinner-border" style="width: 5rem; height: 5rem" role="status">
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        $('#loading').hide();
    });
    $('#btnSubmit').click(function (){
        $('#formImport').hide();
        $('#loading').show();
    })

</script>
