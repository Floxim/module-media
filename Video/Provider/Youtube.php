<?php

namespace Floxim\Media\Video\Provider;

class Youtube extends \Floxim\Media\Video\Provider {
    const KEYWORD = 'youtube';
    
    protected static $id_regexp = [
        '~youtube\.com/watch\?v=([^&]+)~',
        '~youtu\.be/([^\?]+)~'
    ];
    
    protected static $oembed_url_template = 'https://www.youtube.com/oembed?url=%s';
    
    protected static $remote_url_template = 'http://youtube.com/watch?v=%s';
    
    public function getIframe() 
    {
        return '<iframe '.
            //' width="459" height="344" '.
            ' width="640" height="360" '.
            ' src="https://www.youtube.com/embed/'.$this->remote_id.'" '.
            ' frameborder="0" allowfullscreen=""></iframe>';
    }
}