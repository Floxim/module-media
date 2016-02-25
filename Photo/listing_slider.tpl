<div 
    fx:b="image-list" 
    fx:template="list" 
    fx:of="floxim.media.photo:list">
    <div 
        fx:each="$items" 
        fx:e="item">
        <img src="{$image | 'max-width:800'}" alt="{$description editable='false' | strip_tags}" />
    </div>
</div>