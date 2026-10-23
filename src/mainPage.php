<?php
require_once("Operations.php");

$moneyOption = "";

if (isset($_POST["moneyOption"])) {
    $moneyOption = $_POST["moneyOption"];
    setcookie("moneyOption", $_POST["moneyOption"], time() + (86400 * 30), "/");
} elseif (isset($_COOKIE["moneyOption"])) {
    $moneyOption = $_COOKIE["moneyOption"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Subscription Management</title>

    <style>
        a {
            text-decoration: none;
        }
    </style>
</head>

<?php
try {
    $oper = new Operations();
    $mySubscriptionList = $oper->getAllMySubscription();
    $myPaidSubscriptionList = $oper->getPaidSubscription("paid");
    $myUnpaidSubscriptionList = $oper->getUnpaidSubscription("unpaid");

?>

    <body class="d-flex flex-column min-vh-100 bg-light">

        <nav class="navbar navbar-light bg-white border-bottom py-3">
            <div class="container-fluid px-4">
                <span class="navbar-brand mb-0 h1 fs-4 fw-semibold text-dark">
                    Subscription Tracker
                </span>
                <div class="d-flex align-items-center ms-auto gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <label for="currencySelect" class="text-secondary small mb-0">Currency</label>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="d-flex align-items-center gap-2">
                            <select class="form-select form-select-sm shadow-none" id="currencySelect" style="min-width: 110px;" name="moneyOption">
                                <option value="$">USD ($)</option>
                                <option value="€" selected>EUR (€)</option>
                                <option value="£">GBP (£)</option>
                            </select>

                            <button type="submit" class="btn btn-sm btn-primary shadow-none px-3" id="boton">Send</button>
                        </form>
                    </div>
                    <a href="AddSubscription.php">
                        <button type="button" class="btn btn-primary fw-medium px-3 py-2 d-flex align-items-center gap-1">
                            <span>+</span> Add Subscription
                        </button>
                    </a>
                </div>
            </div>
        </nav>


        <main class="flex-grow-1 d-flex flex-column p-4">
            <div class="d-flex gap-2 mb-3" role="tablist">
                <button class="btn btn-outline-primary active" id="btn-all" data-bs-toggle="tab" data-bs-target="#showAllSubscriptions" type="button" role="tab">
                    Show All Subscriptions
                </button>
                <button class="btn btn-outline-primary" id="btn-paid" data-bs-toggle="tab" data-bs-target="#showPaidSubscriptions" type="button" role="tab">
                    Show Paid Subscriptions
                </button>
                <button class="btn btn-outline-primary" id="btn-unpaid" data-bs-toggle="tab" data-bs-target="#showUnpaidSubscriptions" type="button" role="tab">
                    Show Unpaid Subscriptions
                </button>
            </div>

            <div class="tab-content flex-grow-1 d-flex flex-column">
                <section class="tab-pane fade show active flex-grow-1 bg-white p-4 border rounded shadow-sm" id="showAllSubscriptions" role="tabpanel">
                    <h2>All Subscriptions</h2>
                    <table class="table">
                        <thead class="table-primary">
                            <tr>
                                <th>Service Name</th>
                                <th>Monthly Cost</th>
                                <th>Billing Day</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                        foreach ($mySubscriptionList as $subscriptions) {
                            $id = $subscriptions->getId();
                            $service_name = $subscriptions->getService_name();
                            $monthly_cost = $subscriptions->getMonthly_cost();
                            $billing_day = $subscriptions->getBilling_day();
                            $status = $subscriptions->getStatus();
                        ?>

                            <tbody>
                                <tr>
                                    <td><?php echo $service_name ?></td>
                                    <td><?php echo $monthly_cost . $moneyOption ?></td>
                                    <td><?php echo $billing_day; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td>
                                        <div id="contenedorActions">
                                            <a id="lapiz" href="UpdateSubscription.php?id=<?php echo $id; ?>&serviceName=<?php echo $service_name ?>&monthlyCost=<?php echo $monthly_cost ?>&billingDay=<?php echo $billing_day ?>&status=<?php echo $status ?>">✏️</a>
                                            <a href="DeleteSubscription.php?id=<?php echo $id; ?>" id="papelera">🗑️</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>

                        <?php
                        }
                        ?>
                    </table>
                </section>

                <section class="tab-pane fade flex-grow-1 bg-white p-4 border rounded shadow-sm" id="showPaidSubscriptions" role="tabpanel">
                    <h2>Paid Subscriptions</h2>
                    <table class="table">
                        <thead class="table-primary">
                            <tr>

                                <th>Service Name</th>
                                <th>Monthly Cost</th>
                                <th>Billing Day</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                        foreach ($myPaidSubscriptionList as $subscriptions) {
                            $id = $subscriptions->getId();
                            $service_name = $subscriptions->getService_name();
                            $monthly_cost = $subscriptions->getMonthly_cost();
                            $billing_day = $subscriptions->getBilling_day();
                            $status = $subscriptions->getStatus();
                        ?>

                            <tbody>
                                <tr>
                                    <td><?php echo $service_name; ?></td>
                                    <td><?php echo $monthly_cost . $moneyOption ?></td>
                                    <td><?php echo $billing_day; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td>
                                        <div id="contenedorActions">
                                            <a id="lapiz" href="UpdateSubscription.php?id=<?php echo $id; ?>&serviceName=<?php echo $service_name ?>&monthlyCost=<?php echo $monthly_cost ?>&billingDay=<?php echo $billing_day ?>&status=<?php echo $status ?>">✏️</a>
                                            <a href="DeleteSubscription.php?id=<?php echo $id; ?>" id="papelera">🗑️</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>

                        <?php
                        }
                        ?>
                    </table>
                </section>

                <section class="tab-pane fade flex-grow-1 bg-white p-4 border rounded shadow-sm" id="showUnpaidSubscriptions" role="tabpanel">
                    <h2>Unpaid Subscriptions</h2>
                    <table class="table">
                        <thead class="table-primary">
                            <tr>

                                <th>Service Name</th>
                                <th>Monthly Cost</th>
                                <th>Billing Day</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <?php
                        foreach ($myUnpaidSubscriptionList as $subscriptions) {
                            $id = $subscriptions->getId();
                            $service_name = $subscriptions->getService_name();
                            $monthly_cost = $subscriptions->getMonthly_cost();
                            $billing_day = $subscriptions->getBilling_day();
                            $status = $subscriptions->getStatus();
                        ?>

                            <tbody>
                                <tr>
                                    <td><?php echo $service_name; ?></td>
                                    <td><?php echo $monthly_cost . $moneyOption ?></td>
                                    <td><?php echo $billing_day; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td>
                                        <div id="contenedorActions">
                                            <a id="lapiz" href="UpdateSubscription.php?id=<?php echo $id; ?>&serviceName=<?php echo $service_name ?>&monthlyCost=<?php echo $monthly_cost ?>&billingDay=<?php echo $billing_day ?>&status=<?php echo $status ?>">✏️</a>
                                            <a href="DeleteSubscription.php?id=<?php echo $id; ?>" id="papelera">🗑️</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>

                        <?php
                        }
                        ?>
                    </table>
                </section>
            </div>
        </main>

    <?php
} catch (PDOException $e) {
    echo "<br><p style='color:red;'>DB Error: " . htmlspecialchars($e->getMessage()) . "</p><br>";
} catch (Exception $e) {
    echo "<br><p style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p><br>";
} finally {
    if (isset($oper)) {
        $oper->closeConnection();
    }
}
    ?>
    </body>

</html>