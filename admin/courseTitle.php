<?php
include_once("connect.php");


$sql = "SELECT `CID`, `Title` FROM `t_courses`;";
$run = mysqli_query($db_connect,$sql);
$result =  mysqli_fetch_assoc($run);
if ($result) {
  while ($result = mysqli_fetch_assoc($run)) {
    //Display users in rows
    $id = $result["CID"];
      ?>

<tr>
    <td><?= $id ?></td>
    <td class="titleResult"><?= $result["Title"] ?></td>
    <td>
        <button id="enrolBtn" data-id="<?= $id ?>" class='btn bg-warning text-white edit'>Enrol</button>
    </td>
</tr>

<?php
  }}
<?php

include_once("connect.php");


$sql=mysqli_query($db_connect, "SELECT `t_enrolment`.*, COUNT(*) AS 'Enrolled_Users' FROM `t_enrolment` LEFT JOIN `t_users` ON `t_enrolment`.`UID` = `t_users`.`UID` GROUP by `t_enrolment`.`CID`;");


 while($row=mysqli_fetch_array($sql)){

 ?>
<tr>
    <td><?php echo $row['CID']; ?></td>
    <td><?php echo $row['Enrolled_Users']; ?></td>
    <td><?php echo $row['EID']; ?></td>
    <td><?php echo $row['UID']; ?></td>
</tr>
<?php
 }
 ?>
