<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function getAllCustomers()
    {
        return Customer::paginate(10);
    }

    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    public function getCustomerById($id)
    {
        return Customer::findOrFail($id);
    }

    public function updateCustomer($id, array $data)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return $customer->delete();
    }
}
