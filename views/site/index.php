<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                foreach ($posts as $post):?>
                <article class="post">
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['/site/view', 'id'=>$post->id])?>" style="width: 700px"><img src="<?= $post->getImage();?>" alt=""></a>

                        <a href="<?= Url::toRoute(['/site/view', 'id'=>$post->id])?>" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">View Post</div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category','id'=>$post->category->id])?>"> <?= $post->category->name; ?></a></h6>

                            <h1 class="entry-title"> <?= $post->head?></a></h1>
                        </header>
                        <div class="entry-content">
                            <p><?= $post->body ?></p>

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="<?= Url::toRoute(['/site/view', 'id'=>$post->id])?>" class="more-link">Continue Reading</a>
                            </div>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <?= $post->author;?> <a href="<?= Url::toRoute(['/site/view', 'id'=>$post->id])?>">Rubel</a> <?= $post->getDate();?></span>
                            <ul class="text-center pull-right">
                                <li>
                                    <a class="s-facebook" href="#">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </li><?= $post->views?>
                            </ul>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php
                echo LinkPager::widget([
                            'pagination' => $pagination
                    ]);
                ?>
            </div>
            <?= $this->render('/partials/sidebar', [
                'popular'=>$popular,
                'recent'=>$recent,
                'categories'=>$categories
            ]);?>
        </div>
    </div>
</div>
<!-- end main content-->