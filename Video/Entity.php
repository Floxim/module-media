<?php
namespace Floxim\Media\Video;

use Floxim\Floxim\System\Fx as fx;

/*
 * For tests:
 * https://www.youtube.com/watch?v=D457b9QZ0RY
 * https://www.youtube.com/watch?v=Z8fkFKC0fV8
 * https://vimeo.com/204776636
 */

class Entity extends \Floxim\Main\Content\Entity
{
    
    protected $provider = null;
    
    public function getProvider()
    {
        if (is_null($this->provider)) {
            $this->provider = Provider::find($this['source']);
        }
        return $this->provider;
    }
    
    public function getIframe()
    {
        return $this->getProvider()->getIframe();
    }
    
    public function getBoxFields() {
        $res = parent::getBoxFields();
        $res[]= [
            'keyword' => 'source',
            'template' => 'floxim.media.video:player',
            'name' => 'Плеер'
        ];
        return $res;
    }
 

    public function loadOEmbedData()
    {
        $url = $this->getRemoteUrl();
        preg_match("~https?://(?:www\.)?([^/]+)~i", $url, $host);
        $host = $host[1];
        if (!isset(self::$oembed_urls[$host])) {
            return false;
        }
        $oembed_url = sprintf(self::$oembed_urls[$host], urlencode($url));
        $data = fx::http()->get($oembed_url);
        $data = json_decode($data, true);
        $this['oembed_data'] = $data;
        return $data;
    }
    
    public function getOEmbedData()
    {
        if (!$this->isModified('source')) {
            return $this['oembed_data'];
        }
        
        $provider = $this->getProvider();
        if ($provider->isSame($this->getOld('source'))) {
            return $this['oembed_data'];
        }
        
        $res = $provider->getMetaData();
        $this['oembed_data'] = $res;
        return $res;
    }
    
    public function syncFields() 
    {
        $oe = $this->getOEmbedData();
        $res = [];
        if (isset($oe['title'])) {
            $res['name'] = $oe['title'];
        }
        if (isset($oe['thumbnail_url'])) {
            $res['image'] = $oe['thumbnail_url'];
        }
        if (isset($oe['description'])) {
            $res['description'] = $oe['description'];
        }
        $res['iframe'] = $this->getIframe();
        return $res;
    }
}