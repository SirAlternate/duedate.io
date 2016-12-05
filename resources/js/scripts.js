$(function() {
    if ($('body').attr('id') == 'dashboard') {
        var add_button = $('.add-class-btn');
        var add_class_form = $();

        // Check if there are any classes, if not show the form by default
        if ($('.display').children().length == 2) {
            show_class_form();
        }

        // Handle adding new classes
        $('body').on('submit', '.display .new form.add-class', function(e) {
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

        // Update form color as user changes color
        $('body').on('mouseup', '.display .new form.add-class .colors', function(e) {
            var color = $(e.target).attr('for');
            $(e.target).closest('.new').attr('color', color);

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
                // close_all_assignments();
                hide_all_assignment_forms();
                show_assignment_form(item);

                // Make sure form is within scroll
                item.parent().delay(100).animate({
                    scrollTop: item.parent().height()
                }, 300);
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

        // Handle marking assignments as finished
        $('body').on('click', '.display .class ul li.item .tab input[type="checkbox"]', function(e) {
            e.preventDefault(); // Prevent default checking the box

            // Handle marking assignments as complete
            if ($(e.target).is(':checked')) {
                // Tell the server create the new class
                $.post('resources/library/actions.php', {
                    action: 'finish',
                    type: 'assignment',
                    id: $(e.target).closest('li').attr("assg-id")
                }, function(response) {
                    if (response == true) {
                        $(e.target).prop('checked', true);
                    }
                });
            }

            // Handle marking assignments as incomplete
            else {
                // Tell the server create the new class
                $.post('resources/library/actions.php', {
                    action: 'unfinish',
                    type: 'assignment',
                    id: $(e.target).closest('li').attr("assg-id")
                }, function(response) {
                    if (response == true) {
                        $(e.target).prop('checked', false);
                    }
                });
            }

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

function show_assignment_form(btn) {
    // Select this item
    btn.addClass('selected');

    // Switch span text to minus sign
    btn.find('span').text('-');

    // Show the form
    btn.parent().find('form.add-assignment').attr('hide', 'false');
}

function hide_assignment_form(btn) {
    // Un-select this item
    btn.removeClass('selected');

    // Switch span text to plus sign
    btn.find('span').text('+');

    // Hide the form
    btn.parent().find('form.add-assignment').attr('hide', 'true');

    // Clear the input fields for next time
    btn.parent().find('input[name="assg_title"]').val('');
    btn.parent().find('input[name="assg_due"]').val('');
    btn.parent().find('input[name="assg_desc"]').val('');
}

function hide_all_assignment_forms() {
    // Un-select buttons
    var btns = $('.display .class .add-btn.selected');
    hide_assignment_form(btns);
}
