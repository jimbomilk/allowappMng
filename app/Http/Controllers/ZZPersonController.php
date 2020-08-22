<?php

namespace App\Http\Controllers;
use App\ZZPerson;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class ZZPersonController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ZZPerson::query();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('BIRTHDATE',function($d){
                $bd = Carbon::parse($d->BIRTHDATE);
                return $bd->format('d-m-Y');
            })
            ->addColumn('action', function($row){

                   $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
        };
        
        $user = ZZPerson::first();
        
        return view('common.index', [ 'name' => 'zzperson', 'set' => $user->getVisible()]);

    }
}
