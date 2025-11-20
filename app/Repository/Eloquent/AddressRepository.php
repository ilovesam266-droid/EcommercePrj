<?php

namespace App\Repository\Eloquent;

use App\Models\Address;
use App\Repository\Constracts\AddressRepositoryInterface;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    public function getModel()
    {
        return Address::class;
    }

    public function getFilteredAddress(array $filter = [], ?string $search = null)
    {
        return function ($query) use ($filter, $search) {
            if (!empty($filter['is_default'])) {
                $query->where('is_default', $filter['is_default']);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('recipient_name', 'like', "%{$search}%")
                        ->orWhere('recipient_phone', 'like', "%{$search}%")
                        ->orWhere('province', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%")
                        ->orWhere('ward', 'like', "%{$search}%")
                        ->orWhere('detailed_address', 'like', "%{$search}%");

                    $q->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', $search)
                            ->orWhere('last_name', $search)
                            ->orWhere('email', 'like', $search)
                            ->orWhere('username', 'like', "%{$search}%");
                    });
                });
            }
        };
    }

    public function getAllAddress($perPage, $sort, $search, $filter){
        return $this->all($this->getFilteredAddress(
            $filter, $search), ['created_at' => $sort], $perPage, ['*'], [], false);
    }
}
