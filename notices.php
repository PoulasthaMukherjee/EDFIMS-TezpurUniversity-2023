<?php
session_start();
include("config.php");

if (!isset($_SESSION['admin'])) {
    header("location:index.php");
}

$notice = $_POST['notice'];
$title = $_POST['title'];
$date = date('d-M-Y');
$access = $_POST['access'];

if ($notice == NULL || $title == NULL || empty($access)) {
    // Do Nothing
} else {
    $extension = end(explode(".", $_FILES["file"]["name"]));
    $filename = "$title.$extension";
    move_uploaded_file($_FILES["file"]["tmp_name"], "asl_uploads/$filename");

    $accessString = implode(',', $access);
    mysqli_query($poulastha, "INSERT INTO notices(title,notice,file,date,access) VALUES('$title','$notice','$filename','$date','$accessString')");
    $info = "Successfully Submitted Notice";

    // Fetch the list of recipients from the database based on the notice access
$recipients = array();
$query = "SELECT email FROM faculty WHERE id IN (" . implode(",", $access) . ")";
$result = mysqli_query($poulastha, $query);
while ($row = mysqli_fetch_array($result)) {
    $recipients[] = $row['email'];
}

// Email subject
$subject = "New Notice on EDFIMS: " . $title;

// Email content
$message = "Dear Faculty,\n\nA new notice has been uploaded on EDFIMS: $title\nPlease login to the system to view the notice.\n\nRegards,\nAdmin";

// Set sender information
$from = ""; // Enter your Gmail username
$headers = "From: $from" . "\r\n";
$headers .= "Reply-To: $from" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// SMTP configuration
$smtpServer = "smtp.gmail.com";
$smtpPort = "587";
$smtpUsername = ""; // Enter your Gmail username
$smtpPassword = ""; // Enter your Gmail password

// Set SMTP configuration
ini_set("SMTP", $smtpServer);
ini_set("smtp_port", $smtpPort);
ini_set("auth_username", $smtpUsername);
ini_set("auth_password", $smtpPassword);

// Print the recipients
// echo "Recipients: " . implode(", ", $recipients) . "<br>";
// echo "Email Subject: " . $subject . "<br>";
// echo "Email Message: " . $message . "<br>";
// echo "SMTP Server: " . ini_get('SMTP') . "<br>";
// echo "SMTP Port: " . ini_get('smtp_port') . "<br>";
// echo "SMTP Username: " . $smtpUsername . "<br>";
// echo "SMTP Password: " . $smtpPassword . "<br>";


// Send email to each recipient
$failedRecipients = array();
foreach ($recipients as $recipient) {
    // Use the PHP mail() function to send email
    $success = mail($recipient, $subject, $message, $headers);

    if (!$success) {
        $failedRecipients[] = $recipient;
    }
}

// Check if there are any failed recipients
if (!empty($failedRecipients)) {
    echo "Failed to send email to the following recipients: " . implode(", ", $failedRecipients);
} else {
    echo "Email sent successfully!";
}

}

$del = $_GET['del'];
if ($del == NULL) {
    // Do Nothing
} else {
    mysqli_query($poulastha, "DELETE FROM notices WHERE id='$del'");
}

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "onb";

$connect = mysqli_connect($hostname, $username, $password, $databaseName);
$query = "SELECT * FROM faculty";
$result = mysqli_query($connect, $query);

$queryFaculty = "SELECT * FROM faculty";
$resultFaculty = mysqli_query($connect, $queryFaculty);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>File Upload Page</title>
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
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 12px 16px;
        z-index: 1;
    }
    
    .share-with-checkboxes .dropdown.active {
        display: block;
    }
    
    .share-with-checkboxes button {
        padding: 8px 12px; /* Adjust the padding to change the button size */
        font-size: 14px; /* Adjust the font size if needed */
    }
    
    .share-with-checkboxes label {
        display: block;
        margin-bottom: 5px;
    }
</style>
    <script type="text/javascript">
        function MM_validateForm() {
            if (document.getElementById) {
                var i, p, q, nm, test, num, min, max, errors = '', args = MM_validateForm.arguments;
                for (i = 0; i < (args.length - 2); i += 3) {
                    test = args[i + 2];
                    val = document.getElementById(args[i]);
                    if (val) {
                        nm = val.name;
                        if ((val = val.value) != "") {
                            if (test.indexOf('isEmail') != -1) {
                                p = val.indexOf('@');
                                if (p < 1 || p == (val.length - 1)) errors += '- ' + nm + ' must contain an e-mail address.\n';
                            } else if (test != 'R') {
                                num = parseFloat(val);
                                if (isNaN(val)) errors += '- ' + nm + ' must contain a number.\n';
                                if (test.indexOf('inRange') != -1) {
                                    p = test.indexOf(':');
                                    min = test.substring(8, p);
                                    max = test.substring(p + 1);
                                    if (num < min || max < num) errors += '- ' + nm + ' must contain a number between ' + min + ' and ' + max + '.\n';
                                }
                            }
                        } else if (test.charAt(0) == 'R') errors += '- ' + nm + ' is required.\n';
                    }
                }
                if (errors) {
                    alert('The following error(s) occurred:\n' + errors);
                    return false;
                }
                return true;
            }
        }

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
    <span class="head">File Uploads</span>
    <span style="float:right;"><a href="logout.php">Logout</a></span><br />
    <hr style="clear:both;box-shadow:0px 0px 2px #000;" color="#FF6600" size="2" width="100%" /><br />
    <div align="center">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"
            onsubmit="MM_validateForm('title','','R','notice','','R');return document.MM_returnValue">
            <table cellpadding="3" cellspacing="3" class="formTable">
                <tr>
                    <td colspan="2">
                        <span class="Subhead">Add File</span>
                        <hr />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="info"><?php echo $info; ?></td>
                </tr>
                <tr>
                    <td class="labels">Share With</td>
                    <td>
                        <div class="share-with-checkboxes">
                            <button type="button" onclick="toggleDropdown()" style="padding: 1px 12px; font-size: 17px;">- - Select - -</button>
                            <div class="dropdown" id="dropdown">
                                <label><input type="checkbox" id="selectAllButton" onclick="selectAll();" /> All</label>
                                <?php while ($rowFaculty = mysqli_fetch_array($resultFaculty)) : ?>
                                    <label><input type="checkbox" name="access[]" value="<?php echo $rowFaculty['id']; ?>"><?php echo $rowFaculty['name']; ?></label>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td class="labels">Title</td>
                    <td><input name="title" type="text" class="fields" id="title" placeholder="Enter Title"
                            size="45" /></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td class="labels">Description</td>
                    <td><textarea name="notice" cols="35" class="fields" id="notice"
                            style="height:70px;font-family:'trebuchet MS';"
                            placeholder="Enter Description"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td class="labels">Upload File</td>
                    <td><input type="file" name="file" size="45" class="button"
                            placeholder="Select Document or Image File" /></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class="button"
                            onclick="return confirm('Are You Sure...?');" /></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </form>
        <br>
        <table cellpadding="3" cellspacing="3" class="formTable">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>File</th>
                <th>Shared With</th>
                <th>Date</th>
                <th>Download</th>
                <th>Action</th>
            </tr>
            <?php
            $a = mysqli_query($poulastha, "SELECT * FROM notices ORDER BY id DESC");
            while ($b = mysqli_fetch_array($a)) {
                $accessUsers = explode(',', $b['access']);
                $sharedWith = "";
                foreach ($accessUsers as $userId) {
                    $queryUser = "SELECT name FROM faculty WHERE id='$userId'";
                    $resultUser = mysqli_query($connect, $queryUser);
                    $rowUser = mysqli_fetch_array($resultUser);
                    $sharedWith .= $rowUser['name'] . ", ";
                }
                $sharedWith = rtrim($sharedWith, ', ');

                echo "<tr>";
                echo "<td class='rowTable'>" . $b['id'] . "</td>";
                echo "<td class='rowTable'>" . $b['title'] . "</td>";
                echo "<td class='rowTable'>" . $b['file'] . "</td>";
                echo "<td class='rowTable'>" . $sharedWith . "</td>";
                echo "<td class='rowTable'>" . $b['date'] . "</td>";
                echo "<td class='rowTable'><a href='asl_uploads/" . $b['file'] . "' target='_blank'>Download</a></td>";
                echo "<td class='rowTable'>
         <a href='edit.php?edit=" . $b['id'] . "' style='text-shadow:0px 0px 1px #000000;'>Edit</a>
         <a href='notices.php?del=" . $b['id'] . "' onclick=\"return confirm('Are You Sure..?');\" style='text-shadow:0px 0px 1px #000000;'>Delete</a>
      </td>";

                echo "</tr>";
            }
            ?>
        </table>
        <p></p> 
 <a href="admin.php">Go Back</a>
    </div>
</body>

</html>
