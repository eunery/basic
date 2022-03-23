<?php

namespace app\models;

interface Moderator
{
    public function publish($post);
    public function unPublish($post);
}
?>