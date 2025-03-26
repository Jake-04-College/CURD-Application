<?php
if (isset($_POST["submit"])) {
    try {

        require '../common.php';
        require_once '../install.php';

        $conn = new PDO("mysql:host=$servername", $username, $password, $options);

        $conn->exec("USE test");
        $sql = "SELECT * FROM users WHERE location = :location";
        $statement2 = $conn->prepare($sql);

        $location = $_POST["location"];
        $statement2->bindParam(':location', $location, PDO::PARAM_STR);
        $statement2->execute();
        $result = $statement2->fetchAll();

    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

require "templates/header.php";

if (isset($_POST['submit'])) {
    if ($result && $statement2->rowCount() > 0) {
        ?>
        <h2>Results</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Age</th>
                    <th>Location</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td><?php echo escape($row["id"]); ?></td>
                        <td><?php echo escape($row["firstname"]); ?></td>
                        <td><?php echo escape($row["lastname"]); ?></td>
                        <td><?php echo escape($row["email"]); ?></td>
                        <td><?php echo escape($row["age"]); ?></td>
                        <td><?php echo escape($row["location"]); ?></td>
                        <td><?php echo escape($row["date"]); ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No results found for <?php echo escape($_POST['location']); ?>.</p>
    <?php }
}
?>

<h2>Find user based on location</h2>
<form method="post">
    <label for="location">Location</label>
    <input type="text" id="location" name="location">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
