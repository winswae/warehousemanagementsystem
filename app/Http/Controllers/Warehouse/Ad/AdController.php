<?php

namespace App\Http\Controllers\Warehouse\Ad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\WarehouseAd;
use App\Model\Warehouse;
use App\Model\AdImage;
use App\DataTables\AdDataTable;
use App\DataTables\WarehouseAdDataTable;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use DB;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WarehouseAdDataTable $dataTable)
    {
        return $dataTable->render('warehousead.index');    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouses = Warehouse::where('renter_id',Auth::user()->id)->pluck('name','id');
        
        return view('warehousead.create',compact('warehouses'));// uncomment this line and write your view name here
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();        
        
        $warehouse_ad = WarehouseAd::create($input);

        if($request->hasfile('images'))
        {
            foreach($request->file('images') as $image)
            {
                $imageName = time().'.'.$image->extension(); 
                $image->move(public_path('ad-images'), $imageName);
                $ad_image = AdImage::create([
                    'warehouse_ad_id' => $warehouse_ad->id,
                    'path'            => '/ad-images/'.$imageName
                ]);
            }
        }

        return redirect()->route('warehousead.index'); //return your ad index page here
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ad = WarehouseAd::find($id);
        //dd($ad);
        return view('warehousead.show',compact('ad'));// write name of your ad show page
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouses = Warehouse::where('renter_id',Auth::user()->id)->pluck('id');
        $admin = WarehouseAd::find($id);
        return view('warehousead.edit',compact('ad','warehouses'));// write your ad edit page name here
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
        $input = $request->all();
        WarehouseAd::find($id)->update($input);
        Alert::success('Warehouse Ad', 'Data successfully updated');
        return redirect()->route('warehousead.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try{
            $warehouse_ad = WarehouseAd::find($id)->delete();
            if($warehouse_ad)
            {
                return redirect()->route('warehousead.index');// write your warehouse ad index route here
                Alert::success('Warehouse Ad', 'Data successfully deleted');
            }
        } catch (QueryException $e){
            if($e->getCode() == "23000")
            {
                Alert::error('Warehouse Ad', 'Other data exist against this warehouse ad. Please delete other data first');
                 return redirect()->route('warehousead.index');// write your warehouse ad index route here
            }
        } catch (PDOException $e) {
            Alert::error('Warehouse ad', 'Something went wrong. Please contact admin');
            return redirect()->route('warehousead.index'); //write your warehouse ad index route here
        }
    }
    public function adIndex()
    {
        $ads=WarehouseAd::get();
         // $data  =DB::table('warehouse_ads')
        //     ->join('warehouses' , 'warehouse_ads.warehouse_id','=','warehouses.id')
        //     ->join('ad_images' , 'warehouse_ads.id','=','ad_images.warehouse_id')
        //     ->select('warehouse_ads.*','warehouses.location')->get();
        
        return view('website.index',compact('ads'));
    }

    public function showOnWeb(Request $request)
    {

        $ad = WarehouseAd::find($request->ad_id);
        // $ad = DB::table('warehouse_ads')
                // ->join('warehouses', 'warehouse_ads.warehouse_id', '=', 'warehouses.id')
                // ->get();
        return view('website.ad_detail',compact('ad'));
    }
}
