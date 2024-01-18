

<?php

require '../inc/dbcon.php';

function getCustomerList()
{
    global $conn;

    $query = "SELECT * From wp_suhail";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {

        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' =>  'customer list fecth',
                'data' => $res
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' =>  'no customer found',
            ];
            header("HTTP/1.0 404 no customer found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' =>  'Internal Serve Error',
        ];
        header("HTTP/1.0 500 Internal Serve Error");
        return json_encode($data);
    }
}

function getCustomer($customerparams)
{
    global $conn;

    if ($customerparams['id'] == null) {

        return ('enter your customer id');
    }

    $customerId = mysqli_real_escape_string($conn, $customerparams['id']);

    $query = "SELECT * FROM wp_suhail WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' =>  'customer fetched successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' =>  'no customer found',
            ];
            header("HTTP/1.0 404 not found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' =>  'Internal Serve Error',
        ];
        header("HTTP/1.0 500 Internal Serve Error");
        return json_encode($data);
    }
}