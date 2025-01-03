<?php

namespace App\Http\Controllers;

use App\Dtos\Customer\CustomerDto;
use App\Dtos\Customer\CustomerFilterDto;
use App\Http\Requests\CustomerRequest;
use App\Http\Services\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        $search = (string)$request->query('search');
        $customerFilterDto = new CustomerFilterDto(
            $search,
            $search
        );
        $customers = $this->customerService->getCustomers($customerFilterDto);

        return response()->json([
            'status_code' => 200,
            'data' => [
                'customers' => $customers,
            ]
        ]);
    }

    public function create()
    {
        //
    }

    public function store(CustomerRequest $request)
    {
        $customerDto = new CustomerDto(
            $request->get('fullname'),
            $request->get('birthdate'),
            $request->get('sex'),
            $request->get('phone'),
        );
        $customer = $this->customerService->createCustomer($customerDto);

        return response()->json([
            'status_code' => 200,
            'message' => 'Create new customer success',
        ]);
    }

    public function show(Customer $customer)
    {
        return response()->json([
            'status_code' => 200,
            'data' => $customer,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customerDto = new CustomerDto(
            $request->get('fullname'),
            $request->get('birthdate'),
            $request->get('sex'),
            $request->get('phone'),
        );
        $customer = $this->customerService->updateCustomer($customerDto, $customer);

        return response()->json([
            'status_code' => 200,
            'message' => 'Create new customer success',
        ]);
    }

    public function destroy(Customer $customer)
    {
        $deleteCustomer = $this->customerService->deleteCustomer($customer);

        return response()->json([
            'status_code' => 200,
            'message' => 'Delete customer success',
        ]); 
    }
}
