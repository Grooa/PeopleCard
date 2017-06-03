<?php
//ipAddCss('../assets/peopleCard.css');
//echo ipHead();
?>

<section class="card small">
    <?php if (isset($img) && !empty($img)): ?>
        <div class="profile-image">
            <img id="image" src="<?= ipFileUrl('file/repository/' . $img[0]); ?>"
                 alt="<?= isset($name) ? $name : '' ?>">
        </div>
    <?php endif; ?>

    <div class="metadata">
        <h4><?php echo isset($name) ? $name : '[missing name]' ?></h4>
        <em>position: <?php echo isset($position) ? $position : '' ?></em>
    </div>
</section>