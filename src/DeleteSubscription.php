<?php
require_once("Operations.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Subscription</title>

    <style>
        h2 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 15px;

        }

        #yes {
            width: 40%;
            padding: 10px;
            background-color: green;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
        }

        #no {
            width: 40%;
            padding: 10px;
            background-color: red;
            color: black;
            border: none;
            border-radius: 3px;
            text-decoration: none;
            text-align: center;
            box-sizing: border-box;
            font-size: 16px;
        }

        #enlace {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>

<body>
    <h2>You are about to delete this Suscription</h2>
    <h2>Are you Sure?</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
        }
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button id="yes" name="confirm_delete" type="submit">Yes</button>
        <a href="mainPage.php" id="no">No</a>
        <a href="mainPage.php" id="enlace">Return to the home page</a>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm_delete"])) {
        if (isset($_POST["id"])) {
            $id = $_POST["id"];
            $oper = new Operations();
            $oper->deleteSubscription($id);
            echo "<p style='text-align:center;'>Subscription deleted correctly</p>";
        }
    } else {
    }
    ?>
</body>

</html>