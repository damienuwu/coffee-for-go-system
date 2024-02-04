<!DOCTYPE html>
<html>

<head>
    <script>
        function showCompleted() {
            document.getElementById("completed").style.display = "block";
            document.getElementById("cover").style.display = "block";
        }

        function goBack() {
            window.history.back();
        }
    </script>
    <style>
        body {
            background-image: url(image/bg.png);
        }

        @keyframes transitionIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* animation: transitionIn 1s; */

        .rounded-square2 {
            margin-left: 100px;
            width: 600px;
            height: 205px;
            border-radius: 20px;
            background-color: #DFE6F0;
            padding-top: 50px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            animation: transitionIn 1s;
        }

        #cover {
            font-family: 'Poppins', sans-serif;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 99;
            color:white;
        }

        #donepay {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 25px;
            width: 800px;
            height: 680px;
            margin-top: 15px;
            background-color: orange;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        #donepay h1 {
            text-align: center;
            color: white;
            font-size: 70px;
            margin-top: 140px;
            animation: transitionIn 1s;
        }

        #donepay p:not(.small) {
            font-family: 'Poppins', sans-serif;
            font-size: 40px;
            color: brown;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        .small {
            font-family: 'Poppins', sans-serif;
            font-size: 30px;
            color: brown;
            text-align: center;
            font-weight: bold;
            animation: transitionIn 1s;
        }

        #donepay button {
            width: 200px;
            height: 50px;
            background-color: black;
            border-radius: 25px;
            font-weight: bold;
            color: orange;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            margin-top: 30px;
            margin-left: 305px;
            border: none;
            outline: none;
            transition: box-shadow 0.2s ease-in-out;
            animation: transitionIn 1s;
        }

        #donepay button:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);
        }

        #donepay img {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-left: 300px;
            animation: transitionIn 1s;
        }
    </style>
</head>

<body>
</body>

</html>

<?php
/* include db connection file */
include("dbconn.php");
session_start();
$username = $_SESSION['username'];
if (isset($_POST['Update'])) {
    /* capture values from HTML form */
    $menuID = $_POST['menuID'];
    $menuPrice = $_POST['menuPrice'];
    $menuDesc = $_POST['menuDesc'];

    // Check if any of the textboxes are empty
    if (empty($menuPrice) || empty($menuDesc)) {
        echo "<div id='donepay'>
        <h1>Oh No!</h1>
        <p>Please fill in all the fields!</p>
            <button onclick='goBack()'>Try Again</button>
    </div>
    <div id='cover' style='display:block'></div>";
        exit;
    }

    // Check if the price is not a valid number
    if (!is_numeric($menuPrice)) {
        echo "<div id='donepay'>
        <h1>Oh No!</h1>
        <p>Price must be a number!</p>
        <a href='adminDash.php'>
        <button>Try Again</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
        exit;
    }

    $sql0 = "SELECT * FROM menu WHERE menuID = ?";
    $stmt0 = mysqli_prepare($dbconn, $sql0);
    mysqli_stmt_bind_param($stmt0, "i", $menuID);
    mysqli_stmt_execute($stmt0);
    $query0 = mysqli_stmt_get_result($stmt0);
    $row0 = mysqli_num_rows($query0);

    /* execute SQL UPDATE command */
    $sql2 = "UPDATE menu SET menuPrice = ?, menuDesc = ? WHERE menuID = ?";
    $stmt2 = mysqli_prepare($dbconn, $sql2);
    mysqli_stmt_bind_param($stmt2, "dss", $menuPrice, $menuDesc, $menuID);
    mysqli_stmt_execute($stmt2);

    /* display a message */
    echo "<div id='donepay'>
        <h1>Congratulations!</h1>
        <p>Menu Updated Successfully!</p>
        <a href='adminDash.php'>
            <button>Back</button>
        </a>
    </div>
    <div id='cover' style='display:block'></div>";
}

// close if isset()
/* close db connection */
mysqli_close($dbconn);
?>