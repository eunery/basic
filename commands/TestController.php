<?php

namespace app\commands;

use yii\console\ExitCode;

class TestController extends \yii\console\Controller
{
    public function actionParse(string $url = "https://ru.wikipedia.org") {
        $site = file_get_contents($url);

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($site, 0);
        libxml_clear_errors();

        $p = $dom->getElementById("main-tfa");
        $text = "";
        foreach ($p->getElementsByTagName("p") as $i){
            $text .= $i->nodeValue;
        }
        echo $text;
        return ExitCode::OK;
    }

    public function actionUtilite(){

    }
}