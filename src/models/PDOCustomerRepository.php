<?php

namespace models;
/**
 * @author Maurits Seelen (25/05/2017)
 * Class PDOCustomerRepository
 * @package models
 */

class PDOCustomerRepository implements CustomerRepository
{
    private $connection = null;

    /**
     * Maurits Seelen (25/05/2017)
     * PDOCustomerRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Maurits Seelen (25/05/2017)
     * @param int $id
     * @return Customer|null
     */
    public function findCustomerById(int $id)
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM Customers WHERE Id=?');
            $statement->bindParam(1, $id, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (count($results) > 0)
            {
                return new Customer($results[0]['Id'], $results[0]['firstName'], $results[0]['lastName']);
            } else
            {
                return null;
            }
        } catch (\PDOException $PDOException)
        {
            print($PDOException);
        }
    }

    /**
     * @author Maurits Seelen (25/05/2017)
     * @return array
     */
    public function findAllCustomers()
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM Customers');
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $customers = array();
            foreach ($results as $result)
            {
                array_push($customers, new Customer($results['Id'], $results['firstsName'], $results['lastName']));
            }
            return $customers;

        } catch (\PDOException $PDOException) {
            print($PDOException);
        }
    }
}