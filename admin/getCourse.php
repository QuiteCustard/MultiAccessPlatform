<?php
include_once("connect.php");
// Select all courses from database
$query = "SELECT * FROM `t_courses`";
$run = mysqli_query($db_connect,$query);
$result =  mysqli_fetch_assoc($run);
if ($result) {
  while ($result = mysqli_fetch_assoc($run)) {
    //Display users in rows
    $id= $result["CID"];
    ?>
    <tr>
      <td><?= $id ?></td>
      <td><?= $result["Title"] ?></td>
      <td><?= $result["Date"] ?></td>
      <td><?= $result["Duration"] ?></td>
      <td><?= $result["Description"] ?></td>
      <td><?= $result["Max_attendees"] ?></td>
      <td><?= $result["Timestamp"] ?></td>
      <td>
        <button data-id='<?= $id ?>' class='delete'>Delete</button>
      </td>
    </tr>
    <?php
  }
}