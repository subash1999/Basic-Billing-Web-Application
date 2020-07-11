<?php
function show_carousel($images_url){
    include_once("helper_functions.php");
?>
<div id="carousel_example" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php 
        $count = 0;
        foreach($images_url as $img_url) {
            $class = "";
            if ($count == 0){
                $class = "active";
            }
        ?>    
            <li data-target="#carousel_example" data-slide-to="<?php echo($count) ?>" 
            class="<?php echo($class) ?>"></li>
        <?php
            
            $count++;
        ?>            
        <?php
        } 
        ?>
    </ol>
    <div class="carousel-inner">
        <?php
        $count = 0;
        foreach($images_url as $img_url){
            $class = "";
            if($count == 0){
                $class = "active";
            }
        ?>
        <div class="carousel-item <?php echo($class); ?>" >
            <img src="<?php echo($img_url); ?>" alt="Image <?php echo($count) ?>" class="d-block w-100" height="300px" >
            <div class="carousel-caption d-none d-md-block">
            
            </div>
        </div>
        <?php
            $count++;
        }
        ?>
    </div>
    <a href="#carousel_example" class="carousel-control-prev" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a href="#carousel_example" class="carousel-control-next" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
}

?>