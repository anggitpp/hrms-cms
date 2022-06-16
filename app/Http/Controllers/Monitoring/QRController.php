<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use App\Models\BMS\Area;
use App\Models\BMS\Building;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['locations'] = Master::where('category', 'ELK')->get();

        return view('monitorings.qr.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateQR()
    {
        $locations = Master::where('category', 'ELK')->get();
        foreach ($locations as $r){
            Storage::disk('public')->delete('/uploads/monitoring/qr/'.$r->id.'.png');
            QrCode::format('png')->size(500)->errorCorrection('H')->generate($r->code, storage_path('app/public/uploads/monitoring/qr/').$r->id.'.svg');
            $image = new \Imagick();
            $image->readImageBlob(file_get_contents(storage_path('app/public/uploads/monitoring/qr/').$r->id.'.svg'));
            $image->setImageFormat("png24");
            $image->writeImage(storage_path('app/public/uploads/monitoring/qr/').$r->id.'.png');
//            $r->qr_file = '/uploads/monitoring/qr/'.$r->id.'.png';
//            $r->save();

            Storage::disk('public')->delete('uploads/monitoring/qr/'.$r->id.'.svg');
        }

        Alert::success('Success', 'QR berhasil di generate');

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
