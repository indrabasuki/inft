<?php

namespace App\Repositories;

use DB;
use App\Models\Referral;

class ReferralRepository
{
    public function show($id)
    {
        return Referral::find($id);
    }

    public function showAll()
    {
        return Referral::all();
    }

    public function searchData(
        $referral_code,
        $page = 1,
        $limit = 10,
        $sortField = "created_at",
        $sortBy = "asc"
    ) {
        $data   = array();
        $query  = Referral::selectRaw("
            referrals.id,
            referrals.referral_code,
            referrals.referral_description,
            referrals.created_at,
            referral_types.type_name,
            users.name
            ")
            ->join("users", "referrals.user_id", "=", "users.id")
            ->join("referral_types", "referrals.referral_type_id", "=", "referral_types.id");

        if (!empty($referral_code)) {
            $query->where("referral_code", "like", "%" . $referral_code . "%");
        }
        $dataQuery          = clone $query;
        $data['data']       = $dataQuery->limit($limit)->offset(($page - 1) * $limit)->get();
        $data['pagination'] =  [
            "total_found"   => $query->count(),
            "current_page"  => $page,
            "limit"         => $limit
        ];
        $data['count'] = Referral::count();
        $data['pagination']["total_page"] = ($data['pagination']["total_found"] > 0) ? ceil($data['pagination']["total_found"] / $limit) : 1;

        return $data;
    }

    public function delete($id)
    {
        $referral_type = $this->show($id);
        if ($referral_type != null) {
            return $referral_type->delete();
        } else {
            return false;
        }
    }

    public function paginate($page = 1, $perPage = 10)
    {
    }

    public function update($id, array $data)
    {
        $referral_type = $this->show($id);
        if ($referral_type != null) {
            return $referral_type->update($data);
        } else {
            return false;
        }
    }

    public function store(array $data)
    {
        return Referral::create($data);
    }
}
