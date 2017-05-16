<div fx:template="list" fx:b="list" fx:of="list">
    {css}video.less{/css}
    {js}video.js{/js}
</div>
    
<div fx:template="player" fx:b="video provider_{$item.provider /}">
    {css}video.less{/css}
    <div fx:e="video">{$item.getIframe() /}</div>
</div>