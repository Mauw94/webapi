<?php
/**
 * Created by PhpStorm.
 * User: Maurits
 * Date: 25-5-2017
 * Time: 14:10
 */

namespace models;


interface CustomerRepository
{
    public function findCustomerById(int $id);

    public function findAllCustomers();
}