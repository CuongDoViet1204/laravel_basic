<?php

namespace App\Http\Controllers;

use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = '';
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $customers = $this->customerRepo->searchCustomer($search);
        } else {
            $customers = $this->customerRepo->getCustomerPaginate();
        }
        return response()->json([
            'status_code' => 200,
            'data' => [
                'customers' => $customers,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => array('required', 'max:50'),
            'sex' => array('required', 'numeric', 'in:0,1'),
            'birthdate' => array('required', 'date'),
            'phone' => array('required', 'regex:/^[0-9]{10,15}$/')
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => $validator->errors(),
            ]);
        }
        $customer = $this->customerRepo->create($request->all());
        return response()->json([
            'status_code' => 200,
            'message' => 'Create new customer success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = $this->customerRepo->find($id);
        if ($customer) {
            return response()->json([
                'status_code' => 200,
                'data' => $customer,
            ]);
        }
        return response()->json([
            'status_code' => 400,
            'message' => 'Not found customer',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => array('required', 'max:50'),
            'sex' => array('required', 'numeric', 'in:0,1'),
            'birthdate' => array('required', 'date'),
            'phone' => array('required', 'regex:/^[0-9]{10,15}$/')
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'message' => $validator->errors(),
            ]);
        }
        $customer = $this->customerRepo->update($id, $request->all());
        if ($customer) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Update customer success',
            ]); 
        }
        return response()->json([
            'status_code' => 400,
            'message' => 'Not found customer',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteCustomer = $this->customerRepo->delete($id);
        if ($deleteCustomer) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Delete customer success',
            ]); 
        }
        return response()->json([
            'status_code' => 400,
            'message' => 'Not found customer',
        ]);
    }
}
