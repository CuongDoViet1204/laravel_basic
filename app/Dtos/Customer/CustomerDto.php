<?php

namespace App\Dtos\Customer;

class CustomerDto
{
    public string $fullname;
    public string $birthdate;
    public int $sex;
    public string $phone;

    public function __construct(string $fullname, string $birthdate, int $sex, string $phone)
    {
        $this->fullname = $fullname;
        $this->birthdate = $birthdate;
        $this->sex = $sex;
        $this->phone = $phone;
    }
}
 