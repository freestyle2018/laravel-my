$(document).ready(function() {
    //$(function() {

        /*$('#nestable').nestable({
            dropCallback: function(details) {
                console.log(details.sourceId);
            }
        }).on('change', function(e) {
            console.log(e);
        });*/






        $('#nestable').nestable({
            dropCallback: function(details) {
                console.log(details.sourceId);
            }
        }).on('change', '.dd-item', function() {
            //e.stopPropagation();

            var id = $(this).data('id'),
                parentId = $(this).parents('.dd-item').data('id');

            //console.log("parentID = " + parentId);


            var order = new Array();
            $("li[data-id='"+ parentId +"']").find('ol:first').children().each(function(index,elem) {
                order[index] = $(elem).attr('data-id');
                console.log("index = " + index);
            });
            //if (order.length === 0){
                var rootOrder = new Array();
                $("#nestable > ol > li").each(function(index,elem) {
                    rootOrder[index] = $(elem).attr('data-id');
                });
            //}

            //console.table(order);

            //console.table(rootOrder);

            var token = $('form').find( 'input[name=_token]' ).val();

            $.post('/admin/reorder',
                {
                    source : id,
                    destination: parentId,
                    order:JSON.stringify(order),
                    rootOrder:JSON.stringify(rootOrder),
                    _token: token
                },
                function(data) {
                    // console.log('data '+data);
                })
                .done(function() {
                    $( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
                })
                .fail(function() {  })
                .always(function() {  });
        });



    //});



});
