<?php
require_once("Subscription.php");
class Operations
{
    private $conn;
    public function __construct()
    {
        $this->openConnection();
    }
    public function openConnection()
    {
        // Database configuration (match your docker-compose.yml)
        $host = 'mysql';          // The service name in docker-compose (not 'localhost')
        $db = 'app';        // Database name
        $user = 'app';        // MySQL username
        $pass = 'app_password';    // MySQL password
        $charset = 'utf8mb4';

        // DSN (Data Source Name)
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        // PDO options for better error handling and performance
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES => false,                  // Use real prepared statements
        ];

        // Create a PDO instance (connect to the database)
        $this->conn = new PDO($dsn, $user, $pass, $options);
    }
    public function closeConnection()
    {
        $this->conn = null;
    }
    public function getAllMySubscription()
    {
        $sqlString = "select id, service_name, monthly_cost,billing_day, status from subscriptions;";
        $query = $this->conn->prepare($sqlString);
        $query->execute(); // It executes the sql sentence
        $mySubscriptionList = array(); //Create an empty list
        while ($rowMySubscription = $query->fetch()) {
            //Create an object of MyGuest with the contents of the table row
            $obx = new Subscription();
            $obx->setId($rowMySubscription["id"]);
            $obx->setService_name($rowMySubscription["service_name"]);
            $obx->setMonthly_cost($rowMySubscription["monthly_cost"]);
            $obx->setBilling_day($rowMySubscription["billing_day"]);
            $obx->setStatus($rowMySubscription["status"]);
            $mySubscriptionList[] = $obx;
        }
        return $mySubscriptionList;
    }

    public function getPaidSubscription($status)
    {
        $sqlString = "select id, service_name, monthly_cost,billing_day, status from subscriptions where status = ?;";
        $query = $this->conn->prepare($sqlString);
        $query->execute([$status]); // It executes the sql sentence
        $myPaidSubscriptionList = array(); //Create an empty list
        while ($rowMySubscription = $query->fetch()) {
            //Create an object of MyGuest with the contents of the table row
            $obx = new Subscription();
            $obx->setId($rowMySubscription["id"]);
            $obx->setService_name($rowMySubscription["service_name"]);
            $obx->setMonthly_cost($rowMySubscription["monthly_cost"]);
            $obx->setBilling_day($rowMySubscription["billing_day"]);
            $obx->setStatus($rowMySubscription["status"]);
            $myPaidSubscriptionList[] = $obx;
        }
        return $myPaidSubscriptionList;
    }
    public function getUnpaidSubscription($status)
    {
        $sqlString = "select id, service_name, monthly_cost,billing_day, status from subscriptions where status = ?;";
        $query = $this->conn->prepare($sqlString);
        $query->execute([$status]); // It executes the sql sentence
        $myUnpaidSubscriptionList = array(); //Create an empty list
        while ($rowMySubscription = $query->fetch()) {
            //Create an object of MyGuest with the contents of the table row
            $obx = new Subscription();
            $obx->setId($rowMySubscription["id"]);
            $obx->setService_name($rowMySubscription["service_name"]);
            $obx->setMonthly_cost($rowMySubscription["monthly_cost"]);
            $obx->setBilling_day($rowMySubscription["billing_day"]);
            $obx->setStatus($rowMySubscription["status"]);
            $myUnpaidSubscriptionList[] = $obx;
        }
        return $myUnpaidSubscriptionList;
    }
    public function getPausedSubscription($status)
    {
        $sqlString = "select id, service_name, monthly_cost,billing_day, status from subscriptions where status = ?;";
        $query = $this->conn->prepare($sqlString);
        $query->execute([$status]); // It executes the sql sentence
        $rowPausedSubscriptions = $query->fetch(); // It accesses the first row of data
        //Create an object of MyGuest with the contents of the table row
        $obx = new Subscription();
        $obx->setId($rowPausedSubscriptions["id"]);
        $obx->setService_name($rowPausedSubscriptions["service_name"]);
        $obx->setMonthly_cost($rowPausedSubscriptions["monthly_cost"]);
        $obx->setBilling_day($rowPausedSubscriptions["billing_day"]);
        $obx->setStatus($rowPausedSubscriptions["status"]);
        return $obx;
    }

    public function addSubscription(Subscription $subscription)
    { //It receives an object of the class MyGuests
        try {
            $this->conn->beginTransaction();
            $sqlString = "insert into subscriptions( service_name, monthly_cost,billing_day,status) values ( ?, ?, ?,?);";
            $query = $this->conn->prepare($sqlString);
            $query->execute([$subscription->getService_name(), $subscription->getMonthly_cost(), $subscription->getBilling_day(), $subscription->getStatus()]); // It executes the sql sentence
            if ($query->rowCount() > 0) {
                $this->conn->commit(); //Commit the transaction if everything went well
                return true;
            } else return false;
        } catch (PDOException $erro) {
            // Roll back the transaction if somthing failed
            $this->conn->rollback();
            throw $erro;
        }
    }

    public function updateSubscription(Subscription $subscription)
    {
        try {
            $sqlString = "update subscriptions set service_name=?, monthly_cost=? ,billing_day=?,status=? where id=?";
            $this->conn->beginTransaction();
            $query = $this->conn->prepare($sqlString);
            $query->execute([$subscription->getService_name(), $subscription->getMonthly_cost(), $subscription->getBilling_day(), $subscription->getStatus(), $subscription->getId()]); // It executes the sql sentence
            if ($query->rowCount() > 0) {
                $this->conn->commit(); //Commit the transaction if everything went well
                return true;
            } else return false;
        } catch (PDOException $erro) {
            // Roll back the transaction if somthing failed
            $this->conn->rollback();
            throw $erro;
        }
    }

    public function deleteSubscription($id)
    {
        try {
            $this->conn->beginTransaction();
            $sqlString = "delete from subscriptions where id = ?;";
            $query = $this->conn->prepare($sqlString);
            $query->execute([$id]); // It executes the sql sentence
            $this->conn->commit(); //Commit the transaction if everything went well
            return $query->rowCount();
        } catch (PDOException $erro) {
            // Roll back the transaction if somthing failed
            $this->conn->rollback();
            throw $erro;
        }
    }
}
