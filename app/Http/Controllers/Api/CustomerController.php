<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return CustomerResource::collection($customers);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = $this->customerService->createCustomer($request->validated());
        return (new CustomerResource($customer))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        return new CustomerResource($customer);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerService->updateCustomer($id, $request->validated());
        return new CustomerResource($customer);
    }

    public function destroy($id)
    {
        $this->customerService->deleteCustomer($id);
        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
