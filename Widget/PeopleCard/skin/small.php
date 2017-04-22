<?php
ipAddCss('../assets/personCard.css');
//echo ipHead();
?>

<section class="card small">
    <div class="profile-image">
        <?php echo ipBlock('profileImage')->render(); ?>
    </div>
    <h4><?php echo isset($name) ? $name : '[missing name]'?></h4>
    <em>position: <?php echo isset($position) ? $position : '' ?></em>
</section>