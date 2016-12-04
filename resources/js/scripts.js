$(function() {

    if ($('body').attr('id') == 'dashboard') {
        var add_button = $('.add-class-btn');
        var add_class_form = $('form.add-class');

        // Check if there are any classes, if not show the form by default
        if ($('.display').children().length == 2) {
            show_class_form();
        }

        // Handle adding new classes
        add_class_form.on('submit', function(e) {
            e.preventDefault(); // Prevent default form reloading

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

        add_class_form.find('.colors').on('mouseup', function(e) {
            var color = $(e.target).attr('for');
            add_class_form.parent().attr('color', color);
        });

        // Handling generating add class form
        $('body').on('click', '.add-class-btn', function(e) {
            show_class_form();
        });

        // Handle removing an add class form
        $('body').on('click', '.display .new .close-btn', function(e) {
            hide_class_form();
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

        // Handle hiding/showing add assignment form
        $('body').on('click', '.display .class ul li.add-btn', function(e) {
            var item = $(e.target).closest('li');

            if (item.hasClass('selected')) {
                hide_assignment_form(item);
            } else {
                close_assignments();
                show_assignment_form(item);

                item.parent().delay(100).animate({
                    scrollTop: item.parent().height()
                }, 300);
            }
        });

        // Handle opening/closing assignments
        $('body').on('click', '.display .class ul li.item', function(e) {
            var item = $(e.target).closest('li');

            // If the item is already selected hide the open assignment
            if (item.hasClass('selected')) {
                close_assignments();
            }

            // Otherwise we want to open it
            else {
                // Close any open assignments / this class's add form
                close_assignments();
                hide_assignment_form(item.parent().find('.add-btn'));

                // Select this assignmnet
                item.addClass('selected');

                // Generate assignment page
                item.closest('.class').after('\
                    <div class="assignment">\
                    </div>\
                ');
            }
        });

        // Handle adding new assignments
        $('body').on('submit', '.display .class form.add-assignment', function(e) {
            e.preventDefault(); // Prevent default form reloading

            // Tell the server create the new class
            $.post('resources/library/actions.php', {
                action: 'add',
                type: 'assignment',
                data: {
                    class_id: $(this).parent().parent().attr("class-id"),
                    title: $(this).find("input[name='assg_title']").val(),
                    due_date: $(this).find("input[name='assg_due']").val(),
                    desc: $(this).find("input[name='assg_desc']").val()
                }
            }, function(response) {
                // Reload page if we were successful so that we can see the
                // new assignment we just added
                if (response == true) {
                    location.reload();
                }
            });
        });
    }
});

function show_class_form() {
    var add_button = $('.add-class-btn');
    var add_class_form = $('form.add-class');

    // Hide the button, show the form
    add_button.attr('hide', 'true');
    add_class_form.parent().attr('hide', 'false');

    // Swap positions
    add_button.after(add_class_form.parent());

    // Focus on the name field
    add_class_form.find('input[name="class_name"]').focus();

    // Scroll the class list all the way to the right
    $('.display').scrollLeft($('.display').width());
}

function hide_class_form() {
    var add_button = $('.add-class-btn');
    var add_class_form = $('form.add-class');

    // Hide the form, show the button
    add_class_form.parent().attr('hide', 'true');
    add_button.attr('hide', 'false');

    // Swap positions
    add_class_form.parent().after(add_button);

    // Clear the input fields for next time
    add_class_form.find('input[name="class_name"]').val('');
    add_class_form.find('input[name="class_desc"]').val('');
    add_class_form.parent().removeAttr('color')
}

function close_assignments() {
    // Un-select items
    $('.display .class ul li.item.selected').removeClass('selected');

    // Remove any existing assignment pages
    $('.display .assignment').remove();
}

function show_assignment_form(btn) {
    // Select this item
    btn.addClass('selected');

    // Set text to minus
    btn.find('span').text('-');

    // Show the form
    btn.parent().find('form.add-assignment').attr('hide', 'false');
}

function hide_assignment_form(btn) {
    // Un-select this item
    btn.removeClass('selected');

    // Set text to plus
    btn.find('span').text('+');

    // Hide the form
    btn.parent().find('form.add-assignment').attr('hide', 'true');
}
