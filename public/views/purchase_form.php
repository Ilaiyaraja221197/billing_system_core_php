<!DOCTYPE html>
<html>
<head>
    <title>Purchase Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>

<form action="" method="post" id="billing-form">

<!--    <h1>Billing Form</h1>-->
    <div style="float: right">
        <button type="button" class="addRow" style="padding: 10px">Add Row</button>
    </div>

    <div style="display: flex;flex-direction: column;gap: 1rem;text-align: center">
        <div class="date_section">
            <div>
                <label for="date">Date</label>
                <p id="date"><?php echo date( 'd-m-Y' ); ?> </p>
            </div>
        </div>
        <div>
            <table id="purchaseTable">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Units</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>VAT Code</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="purchaseRow">
                    <td><select name="cat[]" class="cat"></select></td>
                    <td>
                        <select name="item_code[]" class="item_code">
                        </select>
                    </td>
                    <td><select name="description[]" class="description"></select></td>
                    <td><input type="text" name="units[]" class="units" readonly></td>
                    <td><input type="text" name="quantity[]" class="quantity" value="0"></td>
                    <td><input type="text" name="price[]" class="price" value="0"></td>
                    <td><select name="vat_code[]" class="vat_code"></select></td>
                    <td>

                        <button type="button" class="removeRow">Remove Row</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="common-fields">
            <div class="row">
                <div class="column">
                    <label for="basic_amount">Basic Amount:</label>
                    <input type="text" id="basic_amount" name="basic_amount" value="0" readonly>
                </div>

                <div class="column" style="display: flex">
                    <div>
                        <p>Discount:</p>
                    </div>
                    <div>
                        <input type="radio" id="percentage" name="discount_type" value="percentage" checked>
                        <label for="percentage">%</label>
                    </div>
                    <div>
                        <input type="radio" id="amount" name="discount_type" value="amount">
                        <label for="amount">Amount</label>
                    </div>
                    <div style="padding-left: 10px;">
                        <input type="text" id="discount" name="discount" value="0">
                    </div>
                </div>
            </div>

            <div class="row">
                <label for="total_price">Total Price:</label>
                <input type="text" id="total_price" name="total_price" value="0" readonly>
            </div>
        </div>

    </div>
    <input type="hidden" name="action" value="saveData">
    <div style="float: right">
        <button type="button" id="save" style="padding: 10px">Save</button>
    </div>
</form>


</body>
</html>
