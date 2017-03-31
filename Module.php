<?php

namespace Floxim\Media;

use Floxim\Floxim\System\Fx as fx;

class Module extends \Floxim\Floxim\Component\Module\Entity {
    
    public function init()
    {
        if (fx::isAdmin()) {
            fx::listen('content_form_ready', function($e) {
                if ($e['entity']->isInstanceOf('floxim.media.video')) {
                    fx::page()->addJsFile(fx::path('@module/Floxim/Media/Video/video-admin.js'));
                }
            });
        }
    }
}