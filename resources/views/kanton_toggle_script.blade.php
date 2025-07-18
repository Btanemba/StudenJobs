<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Get the country and region fields
        var $countryField = $('select[name="person[country]"]');
        var $regionField = $('select[name="person[region]"]');

        // Function to toggle region field based on country
        function toggleRegionField() {
            if ($countryField.val() === 'AT') {
                // Austria selected: enable region field
                $regionField.prop('disabled', false).css('background-color', '#ffffff');
                $regionField.prop('readonly', false);
            } else {
                // Non-Austria selected: clear and disable region field
                $regionField.val(null).trigger('change'); // Clear the selection
                $regionField.prop('disabled', true).css('background-color', '#d3d3d3');
                $regionField.prop('readonly', true);
            }
        }

        // Run on page load
        toggleRegionField();

        // Run on country field change
        $countryField.on('change', toggleRegionField);
    });
</script>
