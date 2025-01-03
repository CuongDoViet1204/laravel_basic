<?php
namespace App\Repositories\Customer;

use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Customer::class;
    }

    public function getCustomers(array $filter)
    {
        $query = $this->model->query();
        foreach ($filter as $attribute => $value) {
            $query->orWhere($attribute, 'LIKE', '%' . $value . '%');
        }
        $customers = $query->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'ASC')
            ->paginate(10);

        return $customers;
    }
}
