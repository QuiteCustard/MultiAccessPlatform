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
