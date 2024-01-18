<?php
/**
 * Template Name: contact Real
 */

get_header();
global $wpdb;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    // Get form fields values
    $e = sanitize_email($_POST['email']);
    $n = sanitize_text_field($_POST['names']);
    $m = sanitize_textarea_field($_POST['messages']);
    $base64_image = '';

    // Handle image upload
    if (!empty($_FILES['uploaded_image']['tmp_name'])) {
        $image_data = file_get_contents($_FILES['uploaded_image']['tmp_name']);
        $base64_image = base64_encode($image_data);
    }

    // Insert data into the table
    $sql = $wpdb->insert(
        'contact_demo',
        array(
            'name' => $n,
            'email' => $e,
            'message' => $m,
            'image' => $base64_image,
        ),
        array(
            '%s',
            '%s',
            '%s',
            '%s',
        )
    );

    // Check for insertion success or failure
    if ($sql === false) {
        echo '<script> alert("Not Inserted") </script>';
    } else {
        echo '<script> alert("Inserted") </script>';
    }
}

?>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<div class="container">
    <form method='POST' enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
            <label for="pwd">Name:</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="names">
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" name="messages"></textarea>
        </div>
        <div class="form-group">
            <label for="uploaded_image">Image:</label>
            <input type="file" name="uploaded_image" accept=".jpg, .jpeg, .png">
        </div>
        <button type="submit" name='insert' class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
get_footer();
?>