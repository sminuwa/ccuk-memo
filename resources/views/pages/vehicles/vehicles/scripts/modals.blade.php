
    <script>
        $('.fuel-request-form').hide();

        $('.add-fuel-request').change(function () {
            if ($(this).is(':checked')) {
                $('.fuel-request-form').slideDown();
            } else {
                $('.fuel-request-form').slideUp();
            }
        })

        $('.has-commission-option').change(function () {
            if ($(this).is(':checked')) {
                // $('.commission-box').slideDown();
                $('.commission-box').html(`
                    <label>Commission</label>
                    <input name="commission" type="number" class="form-control form-control-sm" placeholder="Commission" required>
                `).slideDown();
            } else {
                $('.commission-box').slideUp();

            }
        })

        $(document).on('keyup', '#amount_per_litre, #litre', function(){
            let amount = $("#amount_per_litre").val() * $("#litre").val();
            $('#amount').val(amount)
        })
    </script>

