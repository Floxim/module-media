( function($) {
    
$('html').on('fx_content_form_ready', function(e) {
    var $form = $(e.target),
        $source = $('[name="content[source]"]', $form),
        get_remote_url = function(){
            var v = $source.val(),
                m = v.match(/https?:\/\/[^\s\"]+/);
            return m ? m[0] : '';
        },
        last_url = get_remote_url();
    
    $source.on('change input paste', function() {
        var new_url = get_remote_url();
        if (new_url === last_url || !new_url) {
            return;
        }
        var data = $form.formToHash();
        //console.log(data);
        data.mode = 'sync_fields';
        $fx.post(
            data
        ).then(function(res) {
            $.each(res, function(k, v) {
                var $inp = $('[name="content['+k+']"]'),
                    $img_field = $inp.closest('.fx_image_field');
                if ($img_field.length) {
                    $img_field.find('.remote_file_location').val(v).trigger('paste');
                } else {
                    $inp.val(v).trigger('change');
                }
            });
        });
        last_url = new_url;
    });
});

})($fxj);