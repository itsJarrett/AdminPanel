<?php
session_start();
ob_start();

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$staffPerms = $_SESSION['perms'];
$user = $_SESSION['user'];

include 'verifyPanel.php';
masterconnect();

if ($staffPerms['manageDonations'] != '1') {
    echo "<script src='scripts/na.js'></script>";
    header('Location: lvlError.php');
}
include 'header/header.php';
?>



<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 style = "margin-top: 70px">Donations Management</h1>
    <p class="page-header">Donations to the server, allows you to see / manage donations from players.</p>

    <div class="table-responsive">
        <table class="table table-striped" style = "margin-top: -10px">
            <thead>
            <tr>
                <th>Email</th>
                <th>UID</th>
                <th>Add Donation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            echo '<form action=donations.php method=post>';
            echo '<tr>';

            echo '<td>'."<input class='form-control' type=text name=email value='' </td>";
            echo '<td>'."<input class='form-control' type=text name=uid value='' </td>";
            echo '<td>'."<input class='btn btn-primary btn-outline' type=submit name=update value=Add".' </td>';

            echo '</tr>';
            echo '</form>';

            echo '</table></div>';

            if (isset($_POST['update'])) {
                $email = $_POST['email'];
                $uid = $_POST['uid'];

                $UpdateQ = "INSERT INTO donations (email, uid) VALUES ('$email','$uid');";
                mysqli_query($dbcon, $UpdateQ);

                $UpdateQ = "UPDATE players SET donorlevel ='1' WHERE pid = $uid";
                mysqli_query($dbcon, $UpdateQ);
            }
            ?>

            <br><br>

            <?php

            $sqlget = 'SELECT * FROM donations';
            $search_result = mysqli_query($dbcon, $sqlget) or die('Connection could not be established');

            ?>

            <div class="table-responsive">
                <table class="table table-striped" style = "margin-top: -10px">
                    <thead>
                    <tr>
                        <th>Donation ID</th>
                        <th>Date / Time</th>
                        <th>Email</th>
                        <th>UID</th>
                        <th>Active</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($search_result, MYSQLI_ASSOC)) {
                        $active = $row['active'] == 1 ? "Yes" : "No";
                        echo '<tr>';
                        echo '<td>'.$row['donation_id'].'</td>';
                        echo '<td>'.$row['date_time'].' </td>';
                        echo '<td>'.$row['email'].' </td>';
                        echo '<td>'.$row['uid'].' </td>';
                        echo '<td>'.$active.' </td>';
                        echo '</tr>';
                    }

                    echo '</table></div>';
                    ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="/dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="../../assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
