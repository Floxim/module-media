<div fx:template="list" fx:b="list" fx:of="list">
    {css}video.less{/css}
    {js}video.js{/js}
    <div fx:item fx:b="video">
        {set $embed = $item.getEmbedCode() /}
        {set $popup_id = 'popup-video-' . $item.id /}
        {= $item.addPlayerJs() /}
        
        <a href="#{$popup_id /}" fx:e="thumbnail" data-source="{$source | htmlspecialchars /}">
            <span fx:e="icon" class="{= fx::icon('fa play-circle') /}"></span>
            <img fx:e="img" src="{$image | 'max-width:500' /}" />
        </a>
        
        {apply floxim.ui.hidden:popup with  $popup_id = $popup_id, $size = 'max'}
            {$popup_content}
                <div fx:b="video provider_{$item.provider /}">
                    <div fx:e="video">{$embed /}</div>
                </div>
            {/$}
        {/apply}
    </div>
</div>