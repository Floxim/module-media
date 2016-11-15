<?php
namespace Floxim\Media\Video;

use Floxim\Floxim\System\Fx as fx;

class Entity extends \Floxim\Main\Content\Entity
{
    
    public function getEmbedCode()
    {
        $s = $this['source'];
        preg_match('~<iframe.+?</iframe>~is', $s, $iframe);
        if ($iframe) {
            return $iframe[0];
        }
        $oembed = $this['oembed_data'];
        if ($oembed && isset($oembed['html'])) {
            return $oembed['html'];
        }
        /*
        $s = trim($s);
        preg_match("~https?://([^/]+)~i", $s, $host);
        if ($host) {
            switch ($host[1]) {
                case 'vimeo.com':
                    $url = 'https://vimeo.com/api/oembed.json?url='.urlencode($s);
                    $data = fx::http()->get($url);
                    $data = json_decode($data, true);
                    return $data['html'];
                    break;
            }
        }
        return '';
         * 
         */
    }
    
    protected static function getOEmbedData($url)
    {
        preg_match("~https?://([^/]+)~i", $url, $host);
        switch ($host[1]) {
            case 'vimeo.com':
                $oembed_url = 'https://vimeo.com/api/oembed.json?url='.urlencode($url);
                $data = fx::http()->get($oembed_url);
                $data = json_decode($data, true);
                return $data;
        }
    }
    
    public function beforeSave() {
        parent::beforeSave();
        if ($this->isModified('source') || true) {
            $s = trim($this['source']);
            $this['oembed_data'] = self::getOEmbedData($s);
            fx::cdebug($this);
        }
    }
    
    public function _getProvider()
    {
        $oe = $this['oembed_data'];
        if (!$oe || !isset($oe['provider_name'])) {
            return;
        }
        return mb_strtolower($oe['provider_name']);
    }
    
    public function addPlayerJs()
    {
        
        switch ($this['provider']){
            case 'vimeo':
                fx::page()->addJsFile('https://player.vimeo.com/api/player.js');
                break;
        }
    }
}