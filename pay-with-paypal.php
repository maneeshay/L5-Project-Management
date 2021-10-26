<?php
    $conn = oci_connect('suburban', 'suburban', '//localhost/xe'); 
    $desc = "Suburban Takeaway Payment"; // set to the order description to be appear on the PayPal website
    $order_no = $_POST['orderId']; // set to unique order number (retrieve previous order id from dB)
    $net_total = $_POST['grandTotal']; // set to productTotal + shipmentFee + tax
    $_SESSION["ss_last_order_no"] = $order_no;

    $date = $_POST['date'];
    $time = $_POST['date'] . " " .$_POST['time'];
    


    $colSql = "SELECT * FROM COLLECTIONSLOT WHERE ORDER_ID = ". $order_no ;
    $result = oci_parse($conn,$colSql);
    $collectionId = '';//
    oci_execute($result);
    oci_fetch_assoc($result);

    if(!oci_num_rows($result)){
        $insertCollectionSql = 'INSERT INTO COLLECTIONSLOT(COLLECTION_DATE,COLLECTION_TIME,ORDER_ID) ';
        $insertCollectionSql .= "VALUES(TO_DATE(:odate, 'DD/MM/YYYY'), TO_DATE(:otime, 'DD/MM/YYYY HH24:MI:SS'), :orderId) ";
        $insertCollectionSql .=  " RETURNING SLOT_ID INTO :c_val"; //

        $insertCollectionStatement = oci_parse($conn, $insertCollectionSql);

        oci_bind_by_name($insertCollectionStatement, ':odate', $date);
        oci_bind_by_name($insertCollectionStatement, ':otime', $time);
        oci_bind_by_name($insertCollectionStatement, ':orderId', $order_no);
        oci_bind_by_name($insertCollectionStatement, ':c_val', $collectionId);//

        oci_execute($insertCollectionStatement);

        
    }else{   
        $updateCollectionSql = "UPDATE COLLECTIONSLOT SET COLLECTION_DATE=TO_DATE(:odate, 'DD/MM/YYYY'), COLLECTION_TIME=TO_DATE(:otime, 'DD/MM/YYYY HH24:MI:SS') WHERE ORDER_ID=". $order_no;
        $updateCollectionSql = oci_parse($conn, $updateCollectionSql);

        oci_bind_by_name($updateCollectionSql, ':odate', $date);
        oci_bind_by_name($updateCollectionSql, ':otime', $time);
    

        oci_execute($updateCollectionSql);
    }

    
   

    $url = "https://www.sandbox.paypal.com/cgi-bin/webscr"; //Test
    //$url = "https://www.paypal.com/cgi-bin/webscr"; //Live

    $pp_acc = "sb-wnyyl6565753@business.example.com"; //PayPal account email

    $cancel_URL = "http://localhost/suburban/order_summary.php";
    //https://www.sandbox.paypal.com/businessmanage/preferences/website#

    $paypal_form =
    "<form action='$url' method='post' name='frmPayPal' id='paypal'>\n" .
    "<input type='hidden' name='business' value='$pp_acc'>\n" .
    "<input type='hidden' name='cmd' value='_xclick'>\n" .
    "<input type='hidden' name='item_name' value='$desc'>\n" .
    "<input type='hidden' name='item_number' value='$order_no'>\n" .
    "<input type='hidden' name='amount' value='$net_total'>\n" .
    "<input type='hidden' name='no_shipping' value='1'>\n" .
    "<input type='hidden' name='currency_code' value='USD'>\n" .
    "<input type='hidden' name='handling' value='0'>\n" .
    "<input type='hidden' name='cancel_return' value='$cancel_URL'>\n" .
    // "<button type='submit' name='pay_button'>Pay with PayPal</button>\n" .
    "</form>\n";

    echo ($paypal_form);

?>

<script>
    var form = document.getElementById("paypal");
    form.submit();
</script>