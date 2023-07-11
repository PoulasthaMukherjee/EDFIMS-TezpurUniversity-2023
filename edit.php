<?php
session_start();
include("config.php");

if (!isset($_SESSION['admin'])) {
    header("location:index.php");
}

$edit = $_GET['edit'];

if ($edit == NULL) {
    header("location:notices.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notice = $_POST['notice'];
    $title = $_POST['title'];
    $date = date('d-M-Y');
    $access = $_POST['access'];

    if ($notice == NULL || $title == NULL || empty($access)) {
        // Do Nothing
    } else {
        mysqli_query($poulastha, "UPDATE notices SET title='$title', notice='$notice', date='$date', access='$access' WHERE id='$edit'");
        header("location:notices.php");
    }
}

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "onb";

$connect = mysqli_connect($hostname, $username, $password, $databaseName);
$queryFaculty = "SELECT * FROM faculty";
$resultFaculty = mysqli_query($connect, $queryFaculty);

$a = mysqli_fetch_array(mysqli_query($poulastha, "SELECT * FROM notices WHERE id='$edit'"));
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Edit Notice</title>
    <link href="scripts/styleASL.css" rel="stylesheet" type="text/css" />
    <style>
        /* Additional CSS for Share With checkbox labels */
        .share-with-checkboxes {
            position: relative;
            display: inline-block;
        }

        .share-with-checkboxes .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;
        }

        .share-with-checkboxes .dropdown.active {
            display: block;
        }

        .share-with-checkboxes button {
            padding: 8px 12px;
            font-size: 14px;
        }

        .share-with-checkboxes label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <script type="text/javascript">
        function selectAll() {
            var checkboxes = document.getElementsByName('access[]');
            var selectAllButton = document.getElementById('selectAllButton');

            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAllButton.checked;
            }
        }

        function toggleDropdown() {
            var dropdown = document.getElementById('dropdown');
            dropdown.classList.toggle('active');
        }
    </script>
</head>

<body>
    <span class="head">Edit Notice</span>
    <span style="float:right;"><a href="logout.php">Logout</a></span><br />
    <hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%" /><br />
    <div align="center">
        <form method="post" action="">
            <table cellpadding="3" cellspacing="3" class="formTable">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Notice</th>
                    <th>Share With</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><?php echo $a['id']; ?></td>
                    <td><input type="text" name="title" class="fields" value="<?php echo $a['title']; ?>" /></td>
                    <td><textarea name="notice" cols="35" class="fields"
                            style="height:70px;font-family:'trebuchet MS';"><?php echo $a['notice']; ?></textarea></td>
                    <td>
                        <div class="share-with-checkboxes">
                            <button type="button" onclick="toggleDropdown()"
                                style="padding: 1px 12px; font-size: 17px;">- - Select - -</button>
                            <div class="dropdown" id="dropdown">
                                <label><input type="checkbox" id="selectAllButton" onclick="selectAll();" /> All</label>
                                <?php while ($rowFaculty = mysqli_fetch_array($resultFaculty)) : ?>
                                    <label><input type="checkbox" name="access[]"
                                            value="<?php echo $rowFaculty['id']; ?>"
                                            <?php if (in_array($rowFaculty['id'], explode(',', $a['access']))) echo 'checked'; ?>><?php echo $rowFaculty['name']; ?></label>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="submit" name="update" value="Update" class="button" />
                        <input type="hidden" value="<?php echo $a['id']; ?>" name="id" />
                    </td>
                </tr>
            </table>
        </form>
		<p></p> 
 <a href="notices.php">Go Back</a>
    </div>
</body>

</html>
