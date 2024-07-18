$(document).ready(function () {
    getInitialRow();

    $('#purchaseTable').on('change', 'select, input', function(event) {
        const row = $(this).closest('tr');

        if ($(this).hasClass('cat')) {
            const category = $(this).val();
            const itemCodeSelect = row.find('.item_code');

            $.ajax({
                url: `../router.php`,
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'getCategoryData',
                    category: category
                },
                success: function(data) {
                    itemCodeSelect.empty();
                    $.each(data, function(index, item) {
                        itemCodeSelect.append(`<option value="${item.code}">${item.code}</option>`);
                    });

                    itemCodeSelect.trigger('change');
                },
                error: function() {
                    alert('Error loading item codes.');
                }
            });
        }


        if ($(this).hasClass('quantity') || $(this).hasClass('price') || $(this).hasClass('discount') || $(this).hasClass('discount_type')) {
            calculateAmounts();
        }
    });

    $('#purchaseTable').on('change', '.item_code', function(event) {
        const itemCode = $(this).val();
        const descriptionSelect = $(this).closest('tr').find('.description');
        const unitsInput = $(this).closest('tr').find('.units');

        $.ajax({
            url: `../router.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'getItemCodeData',
                item_code: itemCode
            },
            success: function(data) {
                descriptionSelect.html(`<option value="${data.description}">${data.description}</option>`);
                unitsInput.val(data.sunits);
                descriptionSelect.trigger('change');
            },
            error: function() {
                alert('Error loading item description.');
            }
        });
    });

    $('#purchaseTable').on('change', '.description', function(event) {
        const description = $(this).val();
        const unitsInput = $(this).closest('tr').find('.units');

        $.ajax({
            url: `../router.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'getUnitsData',
                description: description
            },
            success: function(data) {
                unitsInput.val(data.sunits);
            },
            error: function() {
                alert('Error loading units.');
            }
        });
    });
    $('#purchaseTable').on('change', '.vat_code', function(event) {
        calculateAmounts();
    });

    function calculateAmounts() {
        let totalBasicAmount = 0;
        let totalPrice = 0;
        let discountType = $('input[name="discount_type"]:checked').val();
        let discount = parseFloat($('#discount').val()) || 0;

        $('#purchaseTable tbody tr').each(function() {
            const row = $(this);
            const quantity = parseFloat(row.find('.quantity').val()) || 0;
            const price = parseFloat(row.find('.price').val()) || 0;
            const vatPercentage = parseFloat(row.find('.vat_code').val()) || 0;

            const basicAmount = quantity * price * (1 + vatPercentage / 100);
            totalBasicAmount += basicAmount;

            row.find('.basic_amount').val(basicAmount.toFixed(2));
        });

        if (discountType === 'percentage') {
            totalPrice = totalBasicAmount * (1 - discount / 100);
        } else {
            totalPrice = totalBasicAmount - discount;
        }

        $('#basic_amount').val(totalBasicAmount.toFixed(2));
        $('#total_price').val(totalPrice.toFixed(2));
    }

    $('.addRow').click(function () {
        addRow();
    });
    $('#purchaseTable').on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        calculateAmounts();
    });

    $('#purchaseTable').on('change', '.quantity, .price', function () {
        calculateAmounts();
    });

    $('#discount, input[name="discount_type"]').change(function () {
        calculateAmounts();
    });

    $('#save').on('click',function(event){
        event.preventDefault();
        var validRows = [];
        $('#purchaseTable tbody tr').each(function() {
            var row = $(this);
            var itemCode = row.find('.item_code').val();
            var quantity = parseFloat(row.find('.quantity').val()) || 0;

            if (itemCode && quantity > 0) {
                validRows.push(row);
            }
        });

        if (validRows.length === 0) {
            alert('Please select at least one item with a quantity greater than 0.');
            return;
        }

        var formData = {
            action: 'saveData',
            items: []
        };

        validRows.forEach(function(row) {
            var rowData = {
                cat: row.find('.cat').val(),
                item_code: row.find('.item_code').val(),
                description: row.find('.description').val(),
                units: row.find('.units').val(),
                quantity: parseFloat(row.find('.quantity').val()) || 0,
                price: parseFloat(row.find('.price').val()) || 0,
                vat_code: row.find('.vat_code').val()
            };
            formData.items.push(rowData);
        });

        formData.basic_amount = parseFloat($('#basic_amount').val()) || 0;
        formData.discount_type = $('input[name="discount_type"]:checked').val();
        formData.discount = parseFloat($('#discount').val()) || 0;
        formData.total_price = parseFloat($('#total_price').val()) || 0;

        $.ajax({
            url: '../router.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                alert('Form data saved successfully.');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error saving form data.');
            }
        });

    });

});

function getInitialRow(){
    $.ajax({
        url: '../router.php',
        type: 'POST',
        data: {
            action: 'getInitialData',
        },
        dataType: 'json',
        success: function (response) {

            var categoriesDropdown = $('.cat');
            categoriesDropdown.empty();
            $.each(response.categories, function (key, value) {
                categoriesDropdown.append('<option value="' + value + '">' + value + '</option>');
            });

            var itemCodesDropdown = $('.item_code');
            itemCodesDropdown.empty();
            $.each(response.item_codes, function (key, value) {
                itemCodesDropdown.append('<option value="' + value + '">' + value + '</option>');
            });

            var descriptionsDropdown = $('.description');
            descriptionsDropdown.empty();
            $.each(response.descriptions, function (key, value) {
                descriptionsDropdown.append('<option value="' + value + '">' + value + '</option>');
            });
            descriptionsDropdown.trigger('change');

            var vatCodesDropdown = $('.vat_code');
            vatCodesDropdown.empty();
            $.each(response.vat_codes, function (key, value) {
                vatCodesDropdown.append('<option value="' + value.vatper + '">' + value.code + '</option>');
            });

            $('#invoice_no').text(response.invoice_no);
        },
        error: function () {
            alert('Error fetching initial data.');
        }
    });
}

function addRow() {
    var newRow = $('#purchaseTable tbody tr').first().clone();

    if (newRow.length == 0) {
        newRow = '<tr class="purchaseRow">\n' +
            '    <td><select name="cat[]" class="cat"></select></td>\n' +
            '    <td>\n' +
            '        <select name="item_code[]" class="item_code">\n' +
            '        </select>\n' +
            '    </td>\n' +
            '    <td><select name="description[]" class="description"></select></td>\n' +
            '    <td><input type="text" name="units[]" class="units" readonly></td>\n' +
            '    <td><input type="text" name="quantity[]" class="quantity" value="0"></td>\n' +
            '    <td><input type="text" name="price[]" class="price" value="0"></td>\n' +
            '    <td><select name="vat_code[]" class="vat_code"></select></td>\n' +
            '    <td>\n' +
            '        <button type="button" class="removeRow">Remove Row</button>\n' +
            '    </td>\n' +
            '</tr>';

        $('#purchaseTable tbody').append(newRow);

        getInitialRow();
    } else {
        newRow.find('input, select').val('');
        newRow.find('.removeRow').show();

        $('#purchaseTable tbody').append(newRow);
    }
}

