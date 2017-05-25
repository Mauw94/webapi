<?php

use \models\Customer;
use \models\PDOCustomerRepository;
use PHPUnit_Framework_TestCase;
/**
 * @author Maurits Seelen (25/05/2017)
 * Class CustomerControllerTests
 */
class CustomerControllerTests extends \PHPUnit\Framework\TestCase
{
    private $mockCustomerRepository;
    private $mockJsonView;

    public function setUp()
    {
        $this->mockCustomerRepository = $this->getMockBuilder('/models/PDOCustomerRepository')->getMock();
        $this->mockJsonView = $this->getMockBuilder('/views/JsonView')->getMock();
    }

    public function tearDown()
    {
        $this->mockCustomerRepository = null;
        $this->mockJsonView = null;
    }

    public function test_HandleFindCustomerById_clientFound_withFirstAndLastName()
    {
        $customer = new Customer(1, "test", "test2");
        $this->mockCustomerRepository->expects($this->atLeastOnce())
            ->method('findCustomerById')
            ->will($this->returnValue($customer));

        $this->mockJsonView->expects($this->atLeastOnce())
            ->method('show')
            ->will($this->returnCallBack(function ($object) {
                $customer = $object['toShow'];
                printf("%s", json_encode($customer));
            }));
        $customerController = new CustomerController($this->mockCustomerRepository, $this->mockJsonView);
        $customerController->handleFindById($customer->getId());
        $this->expectOutputString(sprintf("%s", json_encode($customer)));
    }
}