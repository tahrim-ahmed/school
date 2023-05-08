<?php
$sql = "SELECT users.*, aid.* FROM users INNER JOIN aid ON users.userID = aid.recipientID";
$serial = 1;
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)){
            $user = $row['userID'];
            $fname = $row['firstName'];
            $lname = $row['lastName'];
            $email = $row['email'];
            $house = $row['houseNo'];
            $road = $row['road'];
            $area = $row['area'];
            $city = $row['city'];
            $zip = $row['zipCode'];
            $country = $row['country'];
            $gender = $row['gd'];
            $contact = $row['cellNo'];
            $bday = $row['birthDay'];
            $reg = $row['regDate'];
            $purpose = $row['purpose'];
            $amount = $row['amount'];
            $volunteerid = $row['volunteerID'];
            $date = $row['date'];

            $sql2 = "SELECT users.*, aid.* FROM users INNER JOIN aid ON users.userID = aid.volunteerID WHERE userID = '$volunteerid'";

            if($result2 = mysqli_query($link, $sql2)){
                if (mysqli_num_rows($result2) > 0){
                    $row2 = mysqli_fetch_array($result2);
                    $vFirstName = $row2['firstName'];
                    $vLastName = $row2['lastName'];

                    ?>
                    <tr>
                        <td><?= $serial ?></td>
                        <td><?= $fname.' '.$lname ?></td>
                        <td><?= $email ?></td>
                        <td><?= $house.' '.$road.' '.$area.' '.$city.'- '.$zip.' '.$country ?></td>
                        <td><?= $contact ?></td>
                        <td><?= $reg ?></td>
                        <td><?= $purpose ?></td>
                        <td><?= $amount; ?></td>
                        <td><?= $vFirstName.' '.$vLastName ?></td>
                        <td><?= $date ?></td>
                    </tr>
                    <?php
                }
            }
            $serial++;
        }
    }
    else{
        echo "no data!!!";
    }
}

$s = "SELECT (SELECT CONCAT(`users`.`firstName`,' ' , `users`.`lastName`) FROM `users` WHERE `users`.`userID`=`aid`.`recipientID`) AS recipientName FROM `aid`";
?>

