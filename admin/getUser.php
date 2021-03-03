<?php
include_once("connect.php");
// Select all users from database
$query = "SELECT * FROM `t_users`";
$run = mysqli_query($db_connect,$query);
$result =  mysqli_fetch_assoc($run);
if ($result) {
  while ($result = mysqli_fetch_assoc($run)) {
    //Display users in rows
    $id= $result["UID"];
    ?>
<tr>
    <td><?= $id ?></td>
    <td class="email"><?= $result["Email"] ?></td>
    <!--<td>$result[Password]</td>-->
    <td><?= $result["Fname"] ?></td>
    <td><?= $result["Lname"] ?></td>
    <td><?= $result["Jobtitle"] ?></td>
    <td><?= $result["Access"] ?></td>
    <td><?= $result["Currentcourse"] ?></td>
    <td><?= $result["Timestamp"] ?></td>
    <td>
        <button data-id="<?= $id ?>" class='btn bg-warning text-white edit'>Edit</button>
    </td>
    <td>
        <button data-id='<?= $id ?>' class='btn bg-danger text-white delete'>Delete</button>
    </td>
</tr>

<?php
  }}
