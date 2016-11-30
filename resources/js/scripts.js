$(function() {

    if ($('body').attr('id') == 'dashboard') {
        var add_button = $('.add-class-btn');
        var add_form = $('form.add-class');

        // Check if there are any classes, if not show the form by default
        if ($('.display').children().length == 2) {
            show_form();
        }

        // Handle adding new classes
        add_form.on('submit', function(e) {
            e.preventDefault(); // Prevent default form reloading

            console.log($(this).find(".colors input:checked").val());

            // Tell the server create the new class
            $.post('resources/library/actions.php', {
                action: 'add',
                type: 'class',
                data: {
                    name: $(this).find("input[name='class_name']").val(),
                    desc: $(this).find("input[name='class_desc']").val(),
                    color: $(this).find(".colors input:checked").val()
                }
            }, function(response) {
                // Reload page if we were successful so that we can see the
                // new class we just added
                if (response == true) {
                    location.reload();
                }
            });
        });

        add_form.find('.colors').on('mouseup', function(e) {
            var color = $(e.target).attr('for');
            add_form.parent().attr('color', color);
        });

        // Handling generating add class form
        $('body').on('click', '.add-class-btn', function(e) {
            show_form();
        });

        // Handle removing an add class form
        $('body').on('click', '.display .new .close-btn', function(e) {
            hide_form();
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

                    // If all classes have been removed show form
                    if ($('.display').children().length == 2) {
                        show_form();
                    }
                }

                return false;
            });
        });
    }
});

function show_form() {
    var add_button = $('.add-class-btn');
    var add_form = $('form.add-class');

    // Hide the button, show the form
    add_button.attr('hide', 'true');
    add_form.parent().attr('hide', 'false');

    // Swap positions
    add_button.after(add_form.parent());

    // Focus on the name field
    add_form.find('input[name="class_name"]').focus();

    // Scroll the class list all the way to the right
    $('.display').scrollLeft($('.display').width());
}

function hide_form() {
    var add_button = $('.add-class-btn');
    var add_form = $('form.add-class');

    // Hide the form, show the button
    add_form.parent().attr('hide', 'true');
    add_button.attr('hide', 'false');

    // Swap positions
    add_form.parent().after(add_button);

    // Clear the input fields for next time
    add_form.find('input[name="class_name"]').val('');
    add_form.find('input[name="class_desc"]').val('');
    add_form.parent().removeAttr('color')
}