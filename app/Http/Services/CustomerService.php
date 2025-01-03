<?php

namespace App\Http\Services;

use App\Dtos\Customer\CustomerDto;
use App\Dtos\Customer\CustomerFilterDto;
use App\Models\Customer;
use App\Repositories\Customer\CustomerRepository;

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getCustomers(CustomerFilterDto $customerFilterDto)
    {
        $customers = $this->customerRepository->getCustomers(get_object_vars($customerFilterDto));
        return $customers;
    }
    
    public function createCustomer(CustomerDto $customerDto)
    {
        $newCustomer = $this->customerRepository->create([
            'fullname' => $customerDto->fullname,
            'birthdate' => $customerDto->birthdate,
            'sex' => $customerDto->sex,
            'phone' => $customerDto->phone,
        ]);
        return $newCustomer;
    }

    public function updateCustomer(CustomerDto $customerDto, Customer $customer)
    {
        $updateCustomer = $this->customerRepository->update($customer, [
            'fullname' => $customerDto->fullname,
            'birthdate' => $customerDto->birthdate,
            'sex' => $customerDto->sex,
            'phone' => $customerDto->phone,
        ]);
        return $updateCustomer;
    }

    public function deleteCustomer(Customer $customer)
    {
        $deleteCustomer = $this->customerRepository->delete($customer);
        return $deleteCustomer;
    }
}
