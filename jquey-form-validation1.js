< script type = "text/javascript" >
    $(window).on('load', function() {
        var charLength = $("input[name='Days']").val();
        var qr_id = $("input[name='qr_id']").val();
        if (charLength > 90) {
            $('#error').text('Value must be less than or equal to 90.');
            console.log($(this).val(char.substring(0, 90)));
        } else {
            $('#error').text('');
            $.ajax({
                url: '<?php echo base_url("/admin/inspected_equip/getNextReminderDate"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    qr_id: qr_id,
                    reminder_days: charLength
                },
                success: function(response) {
                    $("input[name='NextReminderDate']").val(response.next_reminder_date);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
$(document).ready(function() {
    $('#Days').on('keyup', function() {
        var charLength = $(this).val();
        console.log(charLength);
        var qr_id = $("input[name='qr_id']").val();
        if (charLength.trim() === '') {
            $('#error').text('Please enter a number between 0 to 90.');
            return;
        } else if (charLength <= 0 || charLength >= 90) {
            $('#error').text('Value must be greater than 0 and less than 90.');
            console.log($(this).val(char.substring(0, 90)));
        } else {
            $('#error').text('');
            $.ajax({
                url: '<?php echo base_url("/admin/inspected_equip/getNextReminderDate"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    qr_id: qr_id,
                    reminder_days: charLength
                },
                success: function(response) {
                    $("input[name='NextReminderDate']").val(response.next_reminder_date);
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
}); <
/script>