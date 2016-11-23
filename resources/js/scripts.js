$(function() {

    if ($('body').attr('id') == 'dashboard') {
        var button = $('.add-class-btn');

        // Handling generating add class form
        $('body').on('click', '.add-class-btn', function(e) {
            // Remove the button
            $(e.target).remove();

            // Insert the add class form at the end of the DOM
            $('.display').append("\
                <div class='class new'>\
                    <div class='header'>\
                        New Class <a class='close-btn'></a>\
                    </div>\
                    <form class='col-md-5 add-class' method='post'>\
                        <div class='form-group'>\
                            <label idfor='class_name'>Class Name:</label></br>\
                            <input type='text' name='class_name' required='required' />\
                        </div>\
                        <div class='form-group'>\
                            <label for='class_desc'>Description:</label></br>\
                            <input type='text' name='class_desc' />\
                        </div>\
                        <div class='form-group'>\
                            <input type='submit' name='add_class' value='Create class' />\
                        </div>\
                    </form>\
                </div>\
            ");

            $('form.add-class').on('submit', function(e) {
                // Tell the server create the new class
                $.post('resources/library/actions.php', {
                    action: 'add',
                    type: 'class',
                    data: {
                        name: $(this).find("input[name='class_name']").val(),
                        desc: $(this).find("input[name='class_desc']").val()
                    }
                }, function(response) {
                    if (respone == true) {
                        // Remove the form
                        $(e.target).parent().remove();
                    }
                });
            });

            // Scroll the class list all the way to the right
            $('.display').scrollLeft($('.display').width());
        });

        // Handle removing an add class form
        $('body').on('click', '.display .new .close-btn', function(e) {
            // Remove the form from the DOM
            $(e.target).parent().parent().remove();

            // Re-insert the button
            $('.display').append(button);
        });

        // Handle deleting classes
        $('body').on('click', '.display .class .close-btn', function(e) {
            e.preventDefault();

            var class_id = $(e.target).parent().parent().attr('class-id');

            // Tell the server to delete this class
            $.post('resources/library/actions.php', {
                action: 'delete',
                type: 'class',
                id: class_id
            }, function(response) {
                // If successful remove element
                if (response == true) {
                    // Remove the class
                    $(e.target).parent().parent().remove();
                }

                return false;
            });
        });
    }
});
