$(document).ready(function () {
    $('#calculatePayment').on('click', function (e) {
        e.preventDefault();
        resetJsonForm();
        var jsonArray = $.trim($('textarea#jsonArray').val());
        var fieldErrors = '';
        var isValid = true;

        if (jsonArray == null || jsonArray == "") {
            fieldErrors += 'Json array is required.<br>';
            $('.jsonArray').addClass('has-error');
            isValid = false;
        }

        if(!isValidJSONString(jsonArray)){
            fieldErrors += 'Valid json array is required.<br>';
            $('.jsonArray').addClass('has-error');
            isValid = false;
        }

        if (isValid == false) {
            $('.payment-calculate-form .alert-danger').html(fieldErrors);
            $('.payment-calculate-form .alert-danger').css('display', '');
            $('.payment-calculate-form .alert-danger').fadeIn('slow');
            $('.payment-calculate-form .alert-danger').removeClass('hidden');
        }

        if (isValid) {

            $(this).attr('disabled', 'disabled');
            $('.loader').removeClass('hidden');
            var dataSet = {
                'jsonArray': $.parseJSON(jsonArray),
            };
            $.ajax({
                url: APP_URL + 'payment/split',
                type: 'POST',
                dataType: "json",
                data: dataSet,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (data) {

                $('.loader').addClass('hidden');
                if (data.message) {

                    resetJsonFormFields();
                    $jsonData = $('.json-data');
                    $jsonData.append('----------------------Result-------------------');
                    $jsonData.append('<div><label for="name">Total Days = ' + data.data.days + '</label></br>');
                    $jsonData.append('<div><label for="name">Total Spent Amount = ' + parseFloat((data.data.spentTotal).toFixed(2)) + '</label></br>');

                    $jsonData.append('-------------Each User Spent--------------');
                    $.each(data.data.spent, function (user, price) {

                        var amount = parseFloat((price).toFixed(2));
                        $jsonData.append('<div><label for="name">' + user + ' Spent = ' + amount + '</label></br>');
                    });

                    $jsonData.append('-----------------Settlement----------------');
                    $.each(data.data.owes, function (index, value) {

                        $.each(value, function (user, price) {
                            var amount = parseFloat((price).toFixed(2));
                            $jsonData.append('<div><label for="name">' + index + ' -> ' + user + ' = ' + amount + '</label></br>');
                        });
                    });
                    $('.payment-calculate-form .alert-success').html(data.message);
                    $('.payment-calculate-form .alert-success').removeClass('hidden');
                    $('.payment-calculate-form .alert-success').show();
                    $('.payment-calculate-form .alert-success').fadeOut(8000);
                    $('#calculatePayment').removeAttr('disabled');
                }
            }).fail(function (data) {

                $('#calculatePayment').removeAttr('disabled');
                $('.loader').addClass('hidden');
                var errorText = '';
                if (errorText != '') {
                    $('.payment-calculate-form .alert-danger').html(errorText);
                    $('.payment-calculate-form .alert-danger').css('display', '');
                    $('.payment-calculate-form .alert-danger').fadeIn('slow');
                    $('.payment-calculate-form .alert-danger').removeClass('hidden');
                }
            });
        }
    });

    function resetJsonFormFields() {
        $('#jsonArray').val('');
    }

    function resetJsonForm() {
        $('.json-data').html('');
        $('.description').removeClass('has-error');
        $('.payment-calculate-form .alert-success').addClass('hidden');
        $('.payment-calculate-form .alert-warning').addClass('hidden');
        $('.payment-calculate-form .alert-danger').addClass('hidden');
        $('.payment-calculate-form .alert-success').text('');
        $('.payment-calculate-form .alert-warning').text('');
        $('.payment-calculate-form .alert-danger').text('');
    }

    function isValidJSONString(jsonArray) {
        try {
            JSON.parse(jsonArray);
        } catch (e) {
            return false;
        }
        return true;
    }
});
