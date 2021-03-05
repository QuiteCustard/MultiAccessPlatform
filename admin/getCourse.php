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
    <td class="titleResult"><?= $result["Title"] ?></td>
    <td class="dateResult"><?= $result["Date"] ?></td>
    <td class="durationResult"><?= $result["Duration"] ?></td>
    <td class="descriptionResult"><?= $result["Description"] ?></td>
    <td class="attendeesResult"><?= $result["Max_attendees"] ?></td>
    <td ><?= $result["Timestamp"] ?></td>
    <td>
        <button data-id="<?= $id ?>" class='btn bg-warning text-white edit'>Edit</button>
    </td>
     <td>
        <button data-id='<?= $id ?>' class='btn bg-danger text-white delete'>Delete</button>
    </td>
</tr>
<?php
  }
}
