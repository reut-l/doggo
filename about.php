<?php
include_once("./app/functions.php");

//function to start session in a way that prevents session hijacking
sess_start("lkjhtukih");

$pageName = "About Us";

//*****html starts*****
include './templates/header.php';

?>
<!--================ Start About Area =================-->
<div class="about_area generic_area">

    <div class="row h_blog_item">
        <div class="col-lg-6">
            <div class="h_blog_img about_img">
                <img class="img-fluid" src="./img/home-banner.jpg" alt="" />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="h_blog_text">
                <div class="h_blog_text_inner left right about_text">
                    <h4>Welcome to our doggo adoption community</h4>
                    <p>
                        Subdue whales void god which living don't midst lesser
                        yielding over lights whose. Cattle greater brought sixth fly
                        den dry good tree isn't seed stars were.
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque architecto id, eligendi accusantium voluptates modi illo nostrum facilis quis quos. Perspiciatis ex reprehenderit quae quam facere ipsa natus voluptate aspernatur pariatur ad, in eius obcaecati id odit corrupti vero eligendi possimus est ut labore quisquam? Nam consectetur adipisci illo repellat sint eligendi molestias aliquam nisi? Labore consequuntur culpa iure harum incidunt magni molestias at quam velit perferendis, tempore ratione expedita earum soluta accusamus voluptatum atque dicta debitis asperiores fuga adipisci. Cupiditate voluptatibus, quaerat aspernatur illo.
                    </p>

                </div>
            </div>
        </div>
    </div>

</div>
<!--================ End About Area =================-->

<?php
include './templates/footer.php';
?>