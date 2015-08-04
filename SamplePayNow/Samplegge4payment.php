<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd" >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        Payment Pages: Sample PHP Payment Form
    </title>
    <style type="text/css">
        label {
            display: block;
            margin: 5px 0px;
            color: #AAA;
        }

        input {
            display: block;
        }

        input[type=submit] {
            margin-top: 20px;
        }
    </style>

</head>
<body>
<h1>Processing Please Wait...</h1>

<form action="https://demo.globalgatewaye4.firstdata.com/pay" method="POST" name="myForm" id="myForm">

    <?php
    $x_login = ""; // Take from Payment Page ID in Payment Pages interface
    $transaction_key = ""; // Take from Payment Pages configuration interface
    $x_amount = $_POST['x_amount'];
    $x_recurring_billing_id = "";  //Take from recurring area->plan name(HCO Plan ID)
    $x_recurring_billing = "TRUE";
    $x_recurring_billing_amount = "10";  //recurring payment sample 10USD
    $x_currency_code = "USD"; // Needs to agree with the currency of the payment page
    srand(time()); // initialize random generator for x_fp_sequence
    $x_fp_sequence = rand(1000, 100000) + 123456;
    $x_fp_timestamp = time(); // needs to be in UTC. Make sure webserver produces UTC

    // The values that contribute to x_fp_hash
    $hmac_data = $x_login . "^" . $x_fp_sequence . "^" . $x_fp_timestamp . "^" . $x_amount . "^" . $x_currency_code;
    $x_fp_hash = hash_hmac('MD5', $hmac_data, $transaction_key);

    echo('<input name="x_login" value="' . $x_login . '" type="hidden">');
    echo('<input name="x_amount" value="' . $x_amount . '" type="hidden">');
    echo('<input name="x_fp_sequence" value="' . $x_fp_sequence . '" type="hidden">');
    echo('<input name="x_fp_timestamp" value="' . $x_fp_timestamp . '" type="hidden">');
    echo('<input name="x_fp_hash" value="' . $x_fp_hash . '" size="50" type="hidden">');
    echo('<input name="x_currency_code" value="' . $x_currency_code . '" type="hidden">');

   //For recurring payment
    if ($_POST['x_check'] == 'on') {
        echo('<input name="x_recurring_billing_amount" value="' . $x_recurring_billing_amount . '" type="hidden">');
        echo('<input name="x_recurring_billing" value="' . $x_recurring_billing . '" type="hidden">');
        echo('<input name="x_recurring_billing_id" value="' . $x_recurring_billing_id . '" type="hidden">');
    }

    // create parameters input in html
    foreach ($_POST as $a => $b) {
        echo "<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>";
    }

    ?>
    <input type="hidden" name="x_show_form" value="PAYMENT_FORM"/>
</form>
<script type='text/javascript'>document.myForm.submit();</script>
</body>
</html>