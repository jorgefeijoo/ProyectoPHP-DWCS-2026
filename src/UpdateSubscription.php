<?php
require_once("Operations.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update subscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

    $id = $service_name = $status = "";
    $mensaje = "";
    $monthly_cost = 0;
    $billing_day = 0;

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $id = test_input($_GET["id"]);
        $service_name = test_input($_GET["serviceName"]);
        $monthly_cost = test_input($_GET["monthlyCost"]);
        $billing_day = test_input($_GET["billingDay"]);
        $status = test_input($_GET["status"]);
    }
    ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = (test_input($_POST["id"]));
        $service_name = (test_input($_POST["serviceName"]));
        $monthly_cost = (test_input($_POST["monthlyCost"]));
        $billing_day = (test_input($_POST["billingDay"]));
        $status = (test_input($_POST["status"]));

        if (
            !empty($id) &&
            !empty($service_name) &&
            !empty($monthly_cost) &&
            !empty($billing_day) &&
            !empty($status)
        ) {
            $oper = new Operations();
            $subscription = new Subscription();

            $subscription->setId($id);
            $subscription->setService_name($service_name);
            $subscription->setMonthly_cost($monthly_cost);
            $subscription->setBilling_day($billing_day);
            $subscription->setStatus($status);

            $numberOfRows = $oper->updateSubscription($subscription);

            $mensaje = "Subscription updated correctly";
        } else {
            $id = test_input($_POST["id"]);
            $service_name = test_input($_POST["serviceName"]);
            $monthly_cost = test_input($_POST["monthlyCost"]);
            $billing_day = test_input($_POST["billingDay"]);
            $status = test_input($_POST["status"]);

            $mensaje = "All the fields must be completed";
        }
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="card p-4 shadow-sm m-3">
        <h3 class="h5 mb-3 text-primary">Update new Subscription</h3>

        <div class="mb-3">
            <input hidden type="text" id="id" name="id" value="<?php echo $id ?>"><br>
        </div>

        <div class="mb-3">
            <label for="serviceName" class="form-label">Service Name:</label>
            <input type="text" class="form-control" id="serviceName" name="serviceName" value="<?php echo $service_name ?>">
        </div>

        <div class="mb-3">
            <label for="monthlyCost" class="form-label">Monthly Cost:</label>
            <input type="number" class="form-control" id="monthlyCost" name="monthlyCost" value="<?php echo $monthly_cost ?>">
        </div>

        <div class="mb-3">
            <label for="billingDay" class="form-label">Billing Day:</label>
            <input type="number" min="1" max="31" class="form-control" id="billingDay" name="billingDay" value="<?php echo $billing_day ?>">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select class="form-select form-select-sm shadow-none p-2" id="status" style="min-width: 110px;" name="status">
                <option value="paid" <?php echo ($status == "paid") ? "selected" : ""; ?>>Paid</option>
                <option value="unpaid" <?php echo ($status == "unpaid") ? "selected" : ""; ?>>Unpaid</option>
                <option value="paused" <?php echo ($status == "paused") ? "selected" : ""; ?>>Paused</option>
            </select>
        </div>

        <button type="submit" id="boton" class="btn btn-primary w-100 mb-3">Submit</button>

        <div class="text-center">
            <a href="mainPage.php" class="text-decoration-none">Volver a la página principal</a>
        </div>

        <br><br>
    </form>
    <?php echo $mensaje; ?>

</body>

</html>