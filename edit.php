    <!DOCTYPE html>

    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="create.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bearbeiten</title>
    </head>

    <body>

        <?php

    // give history access to the sql config file
        include "config.php";

    // create new mysqli object
        $mysqli = new mysqli($host, $user, $dbpw, $db);

    // start the browser sesson
        session_start();

    // check if user is logged in
        if (!isset($_SESSION['authentication'])) {

            header("location: index.php");

        }
    // cheock if authentication is valid
        elseif ($_SESSION['authentication'] !== "true")

        {

            header("location: login.php");

        }


    // doulbe ckeck that a user is loged in correctly
        if (!isset($_SESSION['uid'])) {

            header("location: login.php");

        }

    // get current time
        $time = date("y.m.d H.i.s");


        ?>

        <div class="container">

            <div class="head">

                <div class="logo">

                    <a href="index.php"><img class="alpeinlogo" src="assets/alpeinlogo.svg"></a>

                </div>

                <div class="title">
                    <?php
                    echo "".$_GET['name']." bearbeten";
                    ?>
                </div>

            </div>
            <div class="createwindow">
                <div class="fwrap">
                    <?php
                // display from with registerd values
                    echo"
                    <form class='f' method='POST' enctype='multipart/form-data'>
                    <label for='name' class='label'>Name:</label>
                    <input type='text' name='name' class='input' required value='".$_GET['name']."'>
                    <br>
                    <label for='text' class='label'>Link:</label>
                    <input type='text' name='link' class='input' required value='".$_GET['link']."'>
                    <br>
                    <div class='label'>Bild:</div>
                    <input type='file' class='fileinput' name='fileToUpload' accept='.jpg, .jpeg, .png'>
                    <br>
                    <input type='submit' name='senden' class='senden' value='senden'>
                    <br>
                    <input type='submit' name='abbrechen' class='senden' value='Abbrechen'>
    
                    </form>
                    ";
                    ?>

                    <?php

                // if the user presses senden
                    if(isset($_POST['senden']))

                    {
					if(strlen($_POST['name'])>100)
					{
						// error if length is more then 100 caracters
						echo"<div class='error'>

						Der Name ist zu lange maximal 100 Zeichen
						</div>";
					}
					// check if link is more then 100 caracters
					elseif (strlen($_POST['link'])>100) {
						// error if length is more then 100 caracters
						echo"<div class='error'>

						Der Link ist zu lange maximal 100 Zeichen
						</div>";
					}
					// if link and name is under 100 caracters
					else{

                        // connect to DB
                        if ($mysqli -> connect_errno)
                        {

                            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

                            exit();



                        }


                        // declare what sring to search in link
                        $word = "https://";
                        $mystring = $_POST['link'];



                        // Test if string contains the word
                        if(strpos($mystring, $word) !== false){


                // if the link contains the string upadate tool with enterd values
                            $mysqli -> query("UPDATE `tools` SET `name`='".$_POST['name']."',`link`='".$_POST['link']."',`changetime`='".$time."' WHERE tid='". $_GET['id']."'");




                        }
        // if link does not contian the string
                        else
                        {
                            // change tool with enterd values and "https://" added infront of link
                            $result = $mysqli -> query("UPDATE `tools` SET `name`='".$_POST['name']."',`link`='https://".$_POST['link']."',`changetime`='".$time."' WHERE tid='". $_GET['id']."'");



                        }
                            // get all data from last changed tool
                        $result = $mysqli -> query("SELECT * FROM tools ORDER BY changetime DESC LIMIT 1;");
                        $row = $result->fetch_assoc();

                            // declare variable with tool id for new file name
                        $rn=$row['tid'];

            // check if a file was submitted in the form
                        if($_FILES['fileToUpload']['size'] > 0)
                        {



                            // delare and initialize variable with the tool id to change the name of the uploaded file
                            $rn=$row['tid'];

                            // declare the target director wher the file will get uploaded
                            $target_dir = "assets/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            $uploadOk = 1;

                            // get the filetipe of the uploaded file
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                            // Check if image file is a actual image or fake image
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if($check !== false)
                            {
                                echo "File is an image - " . $check["mime"] . ".";
                                $uploadOk = 1;
                            }
                            else
                            {
                                echo "File is not an image.";
                                $uploadOk = 0;
                            }

                                // create new file name with tool id
                            $temp = explode(".", $_FILES["fileToUpload"]["name"]);
                            $newfilename = $target_dir .$rn . "." . "png";

                                // uplad file
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
                            {



                            }

                                // if uplad fails display error
                            else
                            {

                                echo"<div class='error'>
    
                                Ein error ist aufgetreten
                                </div>";

                            }

                        }

        // entry in history that tool was changed
                        $mysqli -> query("INSERT INTO `history`(`uid`, `element`, `changetime`, `changed`) VALUES ('".$_SESSION['uid']."','".$row['tid']."','".$time."','".$row['name']." tool bearbeitet')");
                            header("location: index.php");
                        }
                        }

    // if user presse abbrechen redirect to dashboard
                        elseif (isset($_POST['abbrechen']))
                        {
                            header("location: index.php");
                        }


                        ?>


                    </div>
                </div>

            </body>

            </html>