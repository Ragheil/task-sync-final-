<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit();
}

$page_name = "About Us";
include("include/sidebar.php");

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="well">
                        <h3 class="text-center bg-primary" style="padding: 7px;">About Us</h3><br>

                        <div class="row">
                            <div class="col-md-12">
                                <p>Welcome, this is our group <strong>NIGGERSAURUS.</strong> We are a team of dedicated individuals committed to achieving excellence in our respective fields. Below is a brief introduction to each of our group members:</p>
                                
                                <h4>Group Members:</h4>
                                <ul>
                                    <li><strong>Ragheil Atacador: </strong> Team Lead/ Full Stack Developer </li>
                                    <li><strong>Divina Karla Barcelo:</strong> Documentation/Designer</li>
                                    <li><strong>Creslen Joy Boncales:</strong> Documentation/Designer</li>
                                    <li><strong>Ricardo Rimando Jr:</strong> System Engineer</li>
                                    <li><strong>Gadiel Tagam:</strong> Front-End Developer</li>
                                </ul>
<br>
                                <p>Our group is passionate about collaboration and innovation. We believe in the power of collaboration, enthusiasm and strive to push the boundaries of what we can achieve together.</p>
                          <br>
                          
                                <strong>CONTACT US AT</strong> 
                                <p>niggersaurus@email.com</p>
                                <p>09226739414</p>
<br>
<br>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <a href="index.php" class="btn btn-success-custom btn-xs">Return</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
