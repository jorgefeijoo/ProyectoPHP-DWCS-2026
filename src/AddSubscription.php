<?php
require_once("Operations.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        h2 {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h2>Subscription</h2>

    <?php
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $service_name = "";
    $montly_cost = "";
    $billing_day = 0;
    $status = "";
    $errUnits = "";



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["serviceName"])) {
            $errUnits = "service name is required";
        } else {
            $service_name = test_input($_POST["serviceName"]);
        }
        if (empty($_POST["monthlyCost"])) {
            $errUnits = "monthly cost is required";
        } else {
            $montly_cost = test_input($_POST["monthlyCost"]);
        }
        if (empty($_POST["billingDay"])) {
            $errUnits = "billingDay is required";
        } else {
            $billing_day = test_input($_POST["billingDay"]);
        }
        if (empty($_POST["status"])) {
            $errUnits = "status is required";
        } else {
            $status = test_input($_POST["status"]);
        }
    }
    if (
        !empty($service_name) &&
        !empty($montly_cost) &&
        !empty($billing_day) &&
        !empty($status)
    ) {
        $oper = new Operations();
        $subscription = new Subscription();

        $subscription->setService_name($service_name);
        $subscription->setMonthly_cost($montly_cost);
        $subscription->setBilling_day($billing_day);
        $subscription->setStatus($status);

        $numberOfRows = $oper->addSubscription($subscription);
    }
    ?>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="card p-4 shadow-sm m-3">
        <h3 class="h5 mb-3 text-primary">Create new Subscription</h3>

        <div class="mb-3">
            <label for="serviceName" class="form-label">Service Name:</label>
            <input type="text" class="form-control" id="serviceName" name="serviceName">
        </div>

        <div class="mb-3">
            <label for="monthlyCost" class="form-label">Monthly Cost:</label>
            <input type="number" class="form-control" id="monthlyCost" name="monthlyCost">
        </div>

        <div class="mb-3">
            <label for="billingDay" class="form-label">Billing Day:</label>
            <input type="number" min="1" max="31" class="form-control" id="billingDay" name="billingDay">
        </div>

        <div class="mb-3">

            <label for="status" class="form-label">Status:</label>
            <select class="form-select form-select-sm shadow-none p-2" id="currencySelect" style="min-width: 110px;" name="status">
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="paused">Paused</option>
            </select>
        </div>

        <button type="submit" id="boton" class="btn btn-primary w-100 mb-3">Submit</button>

        <div class="text-center">
            <a href="mainPage.php" class="text-decoration-none">Volver a la página principal</a>
        </div>

        <br><br>
    </form>

    <?php


    if (
        !empty($service_name) &&
        !empty($montly_cost) &&
        !empty($billing_day) &&
        !empty($status) &&
        $_SERVER["REQUEST_METHOD"] == "POST"
    ) {
        echo "<p style='text-align:center;'>Subscription add correctly</p>";
    } else {
        echo "<p style='text-align:center;'>Complete all the fields</p>";
    }

    ?>
</body>

</html>