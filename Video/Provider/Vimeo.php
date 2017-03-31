<?php

namespace Floxim\Media\Video\Provider;

class Vimeo extends \Floxim\Media\Video\Provider {
    const KEYWORD = 'vimeo';
    
    protected  static $id_regexp = '~vimeo\.com/(?:video/)?([0-9]+)~';
    
    protected static $oembed_url_template = 'https://vimeo.com/api/oembed.json?url=%s';
    
    protected static $remote_url_template = 'http://vimeo.com/%s';
    
    public function getIframe()
    {
        return '<iframe '.
            'src="https://player.vimeo.com/video/'.$this->remote_id.'" '.
            'width="640" height="360" frameborder="0" '.
            'webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>';
    }
}