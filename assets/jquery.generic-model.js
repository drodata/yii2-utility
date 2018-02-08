$(function(){
    $(document).on('click', '.modal-create-taxonomy', function(e) {
        var dropDown = $(this).closest('.form-group').find('select')
            , type = $(this).data('type')
            , taxonomy = $(this).data('taxonomy')
            , createUrl =  '/' + type + '/modal-create'
            , submitUrl =  '/' + type + '/modal-submit'

        var data = typeof(taxonomy) === 'undefined' ? '' : taxonomy


        $.get(createUrl, data, function(response) {
            $(response).appendTo('body');

            $('#taxonomy-modal').modal({
                'keyboard': false,
                'backdrop': 'static',
            }).on('hidden.bs.modal', function (e) {
                $('#taxonomy-modal').remove();
            }).on('shown.bs.modal', function (e) {
                $('#taxonomy-name').focus();
            });
            var form = $('#taxonomy-form')
                , submitBtn = form.find('[type=submit]')

            form.submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                submitBtn.prop('disabled',true)

                $.post(submitUrl, form.serialize(), function(response) {

                    if (response.status) {
                        $( response.message ).appendTo(submitBtn.parent());
                        $( response.option ).appendTo(dropDown);

                        dropDown.trigger('change').trigger('select2:select', {
                            id: response.id,
                            name: response.name
                        });

                        setTimeout(function(){
                            $('#taxonomy-modal').modal('hide');
                        },1000);
                    } else {
                        form.displayErrors(response)
                    }
                }).fail(ajax_fail_handler).always(function(){
                    submitBtn.prop('disabled',false)
                });
            });
        })
    })
})
