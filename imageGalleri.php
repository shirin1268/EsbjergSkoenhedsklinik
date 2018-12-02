<?php
// set page headers
$page_title = "Image Gallery";
include_once "Header.php";
include_once "menu.php";
$imgh = new ImageResizer();
 ?>
<div class='row'>

    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <?php
    $pictures = $imgh->OpenImageGallery();
    $first = 0;
    $second = 0;
    ?>
  <!-- Indicators -->
        <ol class="carousel-indicators">
          <?php foreach ($pictures as $image) : ?>
            <li data-target="#carouselExampleCaptions" data-slide-to='<?php echo $first; ?>' class='<?php if($first < 1) { echo "active"; } ?>'></li>
          <?php $first++; ?>
          <?php endforeach; ?>
        </ol>

    <?php foreach($pictures as $image) :?>
        <div class="carousel-inner">
            <div class='carousel-item <?php if($second < 1) { echo "active"; } ?>'>
                <?php $second++; ?>
                <img class='class="d-block w-100' src='img/<?php echo $image['picture']?>' alt='<?php echo $image['picturetitle']?>'>
                <div class='carousel-caption d-none d-md-block'>
                    <h3><?php echo $image['picturekategori'] ?></h3>
                    <p><?php echo $image['picturetitle'] ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
</div>
 </div>

       
<?php


include_once "footer.php";
?>

