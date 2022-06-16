<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\ComponentRequest;
use App\Models\Payroll\PayrollComponent;
use App\Models\Payroll\PayrollType;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $componentStatus = $this->menu()->target == "allowances" ? "t" : "f";
        $data['filter'] = $request->get('filter');
        $data['types'] = PayrollType::where('status', 't')->pluck('name', 'id')->toArray();
        $data['filterType'] = $request->get('filterType') ?? array_key_first($data['types']);
        $sql = PayrollComponent::where('type_id', $data['filterType'])->where('type', $componentStatus);
        if (!empty($data['filter'])){
            $sql->where(function ($query) use ($data) {
                $query->orWhere('name', 'like', '%' . $data['filter'] . '%');
                $query->orWhere('code', 'like', '%' . $data['filter'] . '%');
            });
        }


        $data['components'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('payrolls.components.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['id'] = $id;
        $data['type'] = PayrollType::find($id);
        $data['componentType'] = $this->menu()->target == "allowances" ? "Penerimaan" : "Potongan";
        $componentStatus = $this->menu()->target == "allowances" ? "t" : "f";
        $data['status'] = defaultStatus();
        $data['methods'] = array("1" => "Formula", "2" => "Tabel", "3" => "Fixed");
        $data['lastOrder'] = PayrollComponent::where('type_id',$id)->where('type', $componentStatus)
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST CATEGORY

        return !empty(access('create')) ? view('payrolls.components.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComponentRequest $request, $id)
    {
        PayrollComponent::create([
            'type_id' => $id,
            'type' => $this->menu()->target == "allowances" ? "t" : "f",
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'order' => $request->order,
            'method' => $request->component_method,
            'status' => $request->status,
            'method_value' => $request->method_value,
        ]);

        Alert::success('Success', 'Data Komponen berhasil disimpan');

        return redirect()->route('payrolls.'.$this->menu()->target.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['component'] = PayrollComponent::find($id);
        $data['type'] = PayrollType::find($data['component']->type_id);
        $data['componentType'] = $this->menu()->target == "allowances" ? "Penerimaan" : "Potongan";
        $data['status'] = defaultStatus();
        $data['methods'] = array("1" => "Formula", "2" => "Tabel", "3" => "Fixed");

        return !empty(access('edit')) ? view('payrolls.components.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComponentRequest $request, $id)
    {
        $component = PayrollComponent::find($id);

        $component->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'order' => $request->order,
            'method' => $request->component_method,
            'status' => $request->status,
            'method_value' => $request->method_value,
        ]);

        Alert::success('Success', 'Data Komponen berhasil disimpan');

        return redirect()->route('payrolls.'.$this->menu()->target.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PayrollComponent::find($id)->delete();

        Alert::success('Success', 'Data Komponen berhasil dihapus');

        return redirect()->back();
    }
}
