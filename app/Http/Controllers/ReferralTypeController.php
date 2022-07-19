<?php

namespace App\Http\Controllers;

use App\Util\Util;
use Illuminate\Http\Request;
use App\Repositories\ReferralTypeRepository;

class ReferralTypeController extends Controller
{
    private $data = [];


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $referralTypeRepo        = new ReferralTypeRepository();
            $util                    = new Util();

            $name           = $util->checkInputString($request->input('name'));
            $page           = $util->checkNumber($request->input('page'), 1);
            $limit          = $util->checkNumber($request->input('limit'), 10);
            $sortField      = $util->checkInputString($request->input('sortBy'), 'areas.created_at');
            $sortBy         = $util->checkInputString($request->input('sort'), 'asc');
            $data           = $referralTypeRepo->searchData($name, $page, $limit, $sortField, $sortBy);

            $output['count']        = $data["count"];
            $output['item']         = view('referral_type.item', $data)->render();
            $output['ul']           = view('table.ul', $data)->render();
            $output['current_page'] = $data["pagination"]["current_page"];
            return response()->json($output);
        }

        return view('referral_type.index', $this->data);
    }

    public function store(Request $request)
    {
        $referralTypeRepo           = new ReferralTypeRepository();
        $data['type_name']          = $request->type_name;
        $data['type_description']   = $request->type_description;
        $referralTypeRepo->store($data);
        return response()->json(['success' => 'Referral Type Created Successfully']);
    }

    public function update(Request $request)
    {
        $referralTypeRepo           = new ReferralTypeRepository();
        $id                         = $request->id;
        $data['type_name']          = $request->type_name;
        $data['type_description']   = $request->type_description;
        $referralTypeRepo->update($id, $data);
        return response()->json(['success' => 'Referral Type Created Successfully']);
    }

    public function edit(Request $request)
    {
        $referralTypeRepo           = new ReferralTypeRepository();
        $data                       = $referralTypeRepo->show($request->id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $referralTypeRepo           = new ReferralTypeRepository();
        $data                       = $referralTypeRepo->delete($request->id);
        return response()->json([
            'data' => $data,
        ]);
    }
}
