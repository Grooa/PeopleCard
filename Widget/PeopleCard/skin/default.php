<?php
ipAddCss('../assets/peopleCard.css');
?>

<section class="card">
    <div class="profile-image">
        <?php if(isset($img) && !empty($img)): ?>
            <img id="image" src="<?=ipFileUrl('file/repository/' . $img[0]);?>" alt="<?= isset($name) ? $name : '' ?>">
        <?php endif; ?>
    </div>
    <h4 id="profileName" class="name"><?php echo isset($name) && $name != '' ? $name : '[missing name]'?></h4>
    <?php if (!empty($position)): ?>
        <em id="profilePosition" class="position"><?= $position ?></em>
    <?php endif; ?>

    <?php if (isset($url) && $url != null): ?>
        <a href="<?=$url?>">
            <button id="profileButton" class="readmore">Read more</button>
        </a>
    <?php endif; ?>
</section>