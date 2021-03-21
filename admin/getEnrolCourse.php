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
    <td class="titleResult"><?= $result["Title"] ?></td>
    <td class="dateResult"><?= $result["Date"] ?></td>
    <td class="durationResult"><?= $result["Duration"] ?></td>
    <td class="descriptionResult"><?= $result["Description"] ?></td>
     <td>
        <button data-id='<?= $id ?>' class='btn bg-success text-white'>Enrol</button>
    </td>
</tr>
<?php
  }
}
