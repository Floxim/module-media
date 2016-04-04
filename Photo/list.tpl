<div 
    fx:b="image-list" 
    fx:template="list" 
    fx:of="floxim.media.photo:list">
    {css}list.css{/css}
    <div 
        fx:each="$items" 
        fx:e="item">
        <img fx:e="img" src="{$image | 'max-width:800'}" alt="{$description editable='false' | strip_tags}" />
    </div>
</div>