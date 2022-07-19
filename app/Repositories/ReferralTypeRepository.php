<?php

namespace App\Repositories;

use App\Models\ReferralType;
use DB;

class ReferralTypeRepository
{
    public function show($id)
    {
        return ReferralType::find($id);
    }

    public function showAll()
    {
        return ReferralType::all();
    }

    public function searchData(
        $name,
        $page = 1,
        $limit = 10,
        $sortField = "created_at",
        $sortBy = "asc"
    ) {
        $data   = array();
        $query  = ReferralType::selectRaw("id, type_name, type_description,created_at");

        if (!empty($name)) {
            $query->where("type_name", "like", "%" . $name . "%");
        }


        $dataQuery          = clone $query;
        $data['data']       = $dataQuery->limit($limit)->offset(($page - 1) * $limit)->get();
        $data['pagination'] =  [
            "total_found"   => $query->count(),
            "current_page"  => $page,
            "limit"         => $limit
        ];
        $data['count'] = ReferralType::count();

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
        return ReferralType::create($data);
    }
}
