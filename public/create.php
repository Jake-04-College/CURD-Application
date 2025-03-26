<?php require 'templates/header.php'; ?>

<?php
if (isset($_POST['submit'])) {
    require "../config.php";
    require '../common.php';
    try {
        /**
         *  After multiple attmepts to get the code working as shown in the PDF document 
         * https://brightspace.tudublin.ie/d2l/le/content/359305/viewContent/3328245/View
         * 
         * Including deleting all of the code and starting from sratch I could not get the origional code working as intended and turned to stackoverflow in order to help solve the errors I was getting.
         * 
         * I kept getting errors from the PHP site like
         * 
         * INSERT INTO users (firstname, lastname, email, age, location) values (:firstname, :lastname, :email, :age, :location)
         * SQLSTATE[3D000]: Invalid catalog name: 1046 No database selected
         * 
         * when I managed to solve the first issue was then getting
         * 
         * USE test; INSERT INTO users values (firstname, lastname, email, age, location)
         * SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens
         * 
         * The code below works as intended and posts the information submitted in the form to the database.
         */
        $conn = new PDO("mysql:host=$servername", $username, $password, $options);

       
        $new_user = array(
            "firstname" => escape($_POST['firstname']),
            "lastname" => escape($_POST['lastname']),
            "email" => escape($_POST['email']),
            "age" => escape($_POST['age']),
            "location" => escape($_POST['location']),
        );

    
        $sql = "USE test; INSERT INTO users (firstname, lastname, email, age, location) 
                VALUES (:firstname, :lastname, :email, :age, :location)";
        
       
        $statement1 = $conn->prepare($sql);

        // Uses the SQL statement above and replaces the paramters included with the value assigned in the form
        $statement1->bindValue(':firstname', $new_user['firstname']);
        $statement1->bindValue(':lastname', $new_user['lastname']);
        $statement1->bindValue(':email', $new_user['email']);
        $statement1->bindValue(':age', $new_user['age']);
        $statement1->bindValue(':location', $new_user['location']);

     
        $statement1->execute();

        if(isset($_POST['submit']) && $statement1) {
            echo $new_user['firstname'] . " " . $new_user['lastname'] . ' Was Sucessfully Added';
        }

    } catch (PDOException $error) {
        
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<h2>Add a user</h2>
<form method="POST">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" required>
    
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" required>
    
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>
    
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require 'templates/footer.php'; ?>
