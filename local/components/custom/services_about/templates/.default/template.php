<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<section class="page-section" id="services">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Services</h2>
        </div>
        <div class="row text-center">
            <?php foreach ($arResult as $item): ?>
                
                <div class="col-md-4">
                <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                </span>
                    <h4 class="my-3"><?= htmlspecialchars($item['NAME']) ?></h4>
                    <p class="text-muted"><?= htmlspecialchars($item['PREVIEW_TEXT']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
