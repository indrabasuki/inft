<?php

namespace App\Http\Controllers;

use App\Util\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReferralRepository;

class ReferralController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $referralRepo        = new ReferralRepository();
            $util                = new Util();

            $name           = $util->checkInputString($request->input('name'));
            $page           = $util->checkNumber($request->input('page'), 1);
            $limit          = $util->checkNumber($request->input('limit'), 10);
            $sortField      = $util->checkInputString($request->input('sortBy'), 'areas.created_at');
            $sortBy         = $util->checkInputString($request->input('sort'), 'asc');
            $data           = $referralRepo->searchData($name, $page, $limit, $sortField, $sortBy);

            $output['count']        = $data["count"];
            $output['item']         = view('referral.item', $data)->render();
            $output['ul']           = view('table.ul', $data)->render();
            $output['current_page'] = $data["pagination"]["current_page"];

            return response()->json($output);
        }

        return view('referral.index', $this->data);
    }

    public function store(Request $request)
    {
        $referralRepo               = new ReferralRepository();
        $user_id                        = Auth::user()->id;
        $data['referral_type_id']       = $request->referral_type_id;
        $data['user_id']                =  $user_id;
        $data['referral_code']          = $request->referral_code;
        $data['referral_description']   = $request->referral_description;
        $result                         = $referralRepo->store($data);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $referralRepo               = new ReferralRepository();
        $id                             = $request->id;
        $data['referral_type_id']       = $request->referral_type_id;
        $data['referral_code']          = $request->referral_code;
        $data['referral_description']   = $request->referral_description;
        $result                         = $referralRepo->update($id, $data);
        return response()->json($result);
    }

    public function edit(Request $request)
    {
        $referralRepo           = new ReferralRepository();
        $data                    = $referralRepo->show($request->id);

        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $referralRepo           = new ReferralRepository();
        $data                       = $referralRepo->delete($request->id);
        return response()->json($data);
    }
}
