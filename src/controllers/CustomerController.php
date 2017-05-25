<?php

namespace controllers;

use models\PDOCustomerRepository;


/**
 * @author Maurits Seelen (25/05/2017)
 * Class CustomerController
 */
class CustomerController
{
    private $customerRepository;
    private $view;

    /**
     * @author Maurits Seelen (25/05/2017)
     * CustomerController constructor.
     * @param PDOCustomerRepository $customerRepository
     * @param View $view
     */
    public function __construct(PDOCustomerRepository $customerRepository, View $view)
    {
        $this->customerRepository = $customerRepository;
        $this->view = $view;
    }

    public function handleFindById(int $id = null)
    {
        $customer = $this->customerRepository->findCustomerById($id);
        $this->view->show(['toShow' => $customer]);
    }

    public function handleFindAll()
    {
        $customers = $this->customerRepository->findAllCustomers();
        $this->view->show(['toShow' => $customers]);
    }

    public function handleDeleteCustomer($id)
    {
        $this->customerRepository->deleteCustomer($id);
    }
}