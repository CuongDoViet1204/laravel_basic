<?php
namespace App\Repositories\Customer;

use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Customer::class;
    }

    public function getCustomerPaginate()
    {
        $customers = $this->model->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'ASC')
            ->paginate(10);
        return $customers;
    }

    public function searchCustomer(string $text)
    {
        $customer = $this->model->where('fullname', 'LIKE', '%' . $text . '%')
            ->orWhere('phone', 'LIKE', '%' . $text . '%')
            ->orderBy('updated_at', 'DESC')
            ->orderBy('id', 'ASC')
            ->paginate(10);
        return $customer;
    }

}
