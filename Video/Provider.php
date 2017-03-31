<?php

namespace Floxim\Media\Video;

use Floxim\Floxim\System\Fx as fx;

class Provider {
    
    protected static $id_regexp = '~.~';
    
    protected $remote_id = null;
    protected $remote_url = null;
    
    protected $source = null;
    
    const KEYWORD = 'default';
    
    protected static $remote_url_template = '';
    
    public static function getRemoteVideoId($source)
    {
        $rex = (array) static::$id_regexp;
        
        foreach ($rex as $crex) {
            if (preg_match($crex, $source, $id)) {
                return $id[1];
            }
        }
    }
    
    public function __construct($source) 
    {
        $this->source = $source;
        $this->remote_id = self::getRemoteVideoId($source);
    }
    
    public function getIframe()
    {
        return $this->source;
    }
            
    public function getKeyword()
    {
        return static::KEYWORD;
    }
    
    public static function find($source)
    {
        foreach (self::getList() as $pclass) {
            if (call_user_func([$pclass, 'getRemoteVideoId'], $source)) {
                return new $pclass($source);
            }
        }
        return new self($source);
    }
    
    public static function getList()
    {
        static $list = null;
        if (is_null($list)) {
            $list = [];
            $dir = fx::path('@module/Floxim/Media/Video/Provider/*');
            $all = glob( $dir ); 
            foreach( $all as $f ) {
                preg_match("~([a-z0-9]+)\.php$~i", $f, $name);
                $class = '\\Floxim\\Media\\Video\\Provider\\'.$name[1];
                $list []= $class;
            }
        }
        return $list;
    }
    
    public function isSame($source)
    {
        $new_provider = self::find($source);
        return $new_provider->getHash() === $this->getHash();
    }
    
    public function getHash()
    {
        return $this->getKeyword().$this->remote_id;
    }
    
    public function getRemoteUrl()
    {
        $id = $this->remote_id;
        if (!$id) {
            return;
        }
        $tpl = static::$remote_url_template;
        return sprintf($tpl, $id);
    }
            
    
    public function getMetaData()
    {
        $url = $this->getRemoteUrl();
        if (!$url) {
            return [];
        }
        $oembed_url = sprintf(static::$oembed_url_template, urlencode($url));
        
        $res = fx::http()->get($oembed_url);
        if (!$res) {
            return [];
        }
        return json_decode($res, true);
    }
}
