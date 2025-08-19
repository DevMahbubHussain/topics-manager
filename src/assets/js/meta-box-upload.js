jQuery(document).ready(function($){

    $('.upload_image_button').click(function(e){
        e.preventDefault();
        var button  = $(this);
        var input   = button.siblings('.image-url');
        var preview = button.siblings('.image-preview');

        var mediaUploader = wp.media({
            title: 'Select Image',
            button: { text: 'Use this image' },
            multiple: false
        });

        mediaUploader.on('select', function(){
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url);
            preview.html('<img src="'+attachment.url+'" style="max-width:150px; display:block; margin-top:5px;" />');
        });

        mediaUploader.open();
    });


    $('.upload_gallery_button').click(function(e){
        e.preventDefault();
        var button = $(this);
        var list   = button.closest('label').siblings('.gallery-preview');

        var mediaUploader = wp.media({
            title: 'Select Images',
            button: { text: 'Use these images' },
            multiple: true
        });

        mediaUploader.on('select', function(){
            var attachments = mediaUploader.state().get('selection').toJSON();
            attachments.forEach(function(attachment){
                list.append(
                    '<li style="list-style:none; position:relative;">' +
                        '<img src="'+attachment.url+'" style="max-width:100px; height:auto;" />' +
                        '<input type="hidden" name="'+button.closest("label").text().trim()+'[]" value="'+attachment.url+'" />' +
                        '<span class="remove-image" style="cursor:pointer; color:red; position:absolute; top:0; right:5px;">&times;</span>' +
                    '</li>'
                );
            });
        });

        mediaUploader.open();
    });

    $(document).on('click', '.remove-image', function(){
        $(this).parent().remove();
    });

    // Drag-and-drop sorting
    if ($.fn.sortable) {
        $('.gallery-preview').sortable();
    }
});
