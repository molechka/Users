<?php
namespace tasks\models;
class WrapperSoapServer
{
    /**
     * @WebMethod
     * @param wrapper $user @className=User
     * @param int $id
     * @return string $nameWithAge
     */
    public function getUserString($user, $id)
    {
        return '[#' . $id . ']Your name is: ' . $user->name . ' and you have ' . $user->age . ' years old with payment ' . $user->payment;
    }

    /**
     * @WebMethod
     * @param string $name
     * @param string $age
     * @param string $payment
     * @return wrapper $userReturn @className=User
     */
    public function getUser($name, $age, $payment)
    {
        $user = new User();
        $user->name = $name;
        $user->age = $age;
        $user->payment = $payment;
        return $user;
    }

    /**
     * @WebMethod
     * @return wrapper[] $employees @className=Employee
     */
    public function getEmployees()
    {
        $employees = array();
        $departments = array('IT', 'Logistics', 'Management');
        for ($i = 0; $i < 3; $i++) {
            $employee = new Employee();
            $employee->id = 2 + $i + 1;
            $employee->department = $departments[$i];
            $employees[] = $employee;
        }
        return $employees;
    }

    /**
     * @WebMethod
     * @param wrapper[] $employeesList @className=Employee
     * @return string $str
     */
    public function getEmployeesDepartments($employeesList)
    {
        //FIXME getting correct $employeesList
        $names = array();
        foreach ($employeesList as $employee) {
            $names[] = $employee->department;
        }
        return implode(', ', $names);
    }
}
