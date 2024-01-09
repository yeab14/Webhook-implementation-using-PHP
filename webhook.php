
<?php
if ( $_SERVER ['REQUEST_METHOD'] === 'POST'){

//retrieve the raw POST data
$payload = file_get_contents ('php://input')

//parse the JSON payload
$data = json_decode ( $payload, true)

//process the notification data
if (isset ($data ['event_type'] )){
    $event_type = $data['event_type'];

    //handle different transaction events made on the account

    if ( $event_type === 'transaction_made'){
        
        //process the transaction made event
        $transactionid = $data ['transaction_id'];
        $accountid = $data ['account_id'];
        $amount = $data ['amount'];

        // verification and replay of message are handled for transaction made event
        //verify the data

        if (!empty ($transactionid ) && is_numeric ($amount)) {

        // data is valid, prepare the reply
            $replyMessage = " your transaction with Id  $transactionid  and amount  $amount has been processed successfully!";
        }

    } else if ( $event_type === 'transaction_failed') {

        //process the transaction failed event
        $transactionid = $data ['transaction_id'];
        $accountid = $data ['account_id'];
        $reason = $data ['reason'];

        //prepare error reply message
        $replyMessage = "Something went wrong with your transaction. Please double-check the provided information";

    } else if ( $event_type === 'transaction_cancelled') {

    //process the transaction cancelled event
    $transactionid = $data ['transaction_id'];
    $accountid = $data ['account_id'];
  
}

// to send response back to the partner systems
http_response_code ( 200);
echo  $replyMessage; 

}

}

?>
