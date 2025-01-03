<?php

namespace App\Dtos\Customer;

class CustomerFilterDto
{
    public string $fullname;
    public string $phone;

    public function __construct(string $fullname, string $phone)
    {
        $this->fullname = $fullname;
        $this->phone = $phone;
    }
}
 