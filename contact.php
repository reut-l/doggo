<?php
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

$pageName = "Contact Us";

//*****html starts*****
include './templates/header.php';

?>
<div class="generic_area">

    <div class="row">
        <div class="col-lg-5">
            <div class="contact_info">
                <div class="info_item">
                    <h6><i class="ti-home"></i>Tel Aviv, Israek</h6>
                    <p>Rothschild bullevard</p>
                </div>
                <div class="info_item">
                    <h6><i class="ti-headphone"></i><a href="#">+972 (0)3 111 1111</a></h6>
                    <p>Mon to Fri 9am to 6 pm</p>
                </div>
                <div class="info_item">
                    <h6><i class="ti-email"></i><a href="#">support@doggo.com</a></h6>
                    <p>Send us your query anytime!</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <iframe id="mapBox" class="mapBox" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4079.3762459972468!2d34.77358918721174!3d32.06511468689466!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151d4b7df683586b%3A0xc95a69f356f7f3b2!2sSderot%20Rothschild%2C%20Tel%20Aviv-Yafo!5e0!3m2!1sen!2sil!4v1601705436163!5m2!1sen!2sil" width="80%" height="50%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>

    </div>

</div>
<!--================Contact Area =================-->

<?php
include './templates/footer.php';
?>