(function() {

$('html').on('popup_show', function(e) {
    var $popup = $(e.target),
        $video = $popup.find('.floxim--media--video--video');
    
    if ($video.length === 0) {
        return;
    }
    
    var iframe = $video.find('iframe').get(0),
        provider = $video.attr('class').match(/floxim--media--video--video_provider_([^\s]+)/);
    if (!provider || !iframe) {
        return;
    }
    provider = provider[1];
    
    switch (provider) {
        case 'vimeo':
            var Player = new Vimeo.Player(iframe);
            Player.play();
            $popup.one('popup_hide', function() {
                Player.pause();
            });
            break;
    }
});

})();