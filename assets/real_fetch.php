<?php
/**
 * Template Name: Real Fetch Contact
 */

get_header();

global $wpdb;

// Check if the update form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_contact'])) {
        // Update contact logic
        $contact_id = intval($_POST['contact_id']);
        $updated_name = sanitize_text_field($_POST['updated_name']);
        $updated_email = sanitize_email($_POST['updated_email']);
        $updated_forme = sanitize_text_field($_POST['updated_forme']);

        $result = $wpdb->update(
            'contact_demo',
            array(
                'name' => $updated_name,
                'email' => $updated_email,
                'forme' => $updated_forme,
            ),
            array('id' => $contact_id),
            array('%s', '%s', '%s'),
            array('%d')
        );

        // Check for update success or failure
        if ($result === false) {
            // Display an error message
            echo 'Update failed. Database Error: ' . $wpdb->last_error;
        } else {
            // Display a success message or perform other actions
            echo 'Contact updated successfully!';
        }
    } elseif (isset($_POST['delete_contact'])) {
        // Delete contact logic
        $contact_id = intval($_POST['contact_id']);

        // Soft delete by updating status to 0
        $result = $wpdb->update(
            'contact_demo',
            array('status' => 0),
            array('id' => $contact_id),
            array('%d'),
            array('%d')
        );

        // Check for delete success or failure
        if ($result === false) {
            // Display an error message
            echo 'Delete failed. Database Error: ' . $wpdb->last_error;
        } else {
            // Display a success message or perform other actions
            echo 'Contact deleted successfully!';
        }
    } elseif (isset($_POST['image_upload'])) {
        // Handle image upload logic
        $contact_id = intval($_POST['contact_id']);

        if (!empty($_FILES['uploaded_image']['tmp_name'])) {
            $image_data = file_get_contents($_FILES['uploaded_image']['tmp_name']);
            $base64_image = base64_encode($image_data);

            // Update the contact with the new image
            $result = $wpdb->update(
                'contact_demo',
                array('image' => $base64_image),
                array('id' => $contact_id),
                array('%s'),
                array('%d')
            );

            // Check for update success or failure
            if ($result === false) {
                // Display an error message
                echo 'Image upload failed. Database Error: ' . $wpdb->last_error;
            } else {
                // Display a success message or perform other actions
                echo 'Image uploaded successfully!';
            }
        }
    }
}

// Fetch only active contacts from the database
$sql = "SELECT * FROM contact_demo WHERE status = 1";
$results = $wpdb->get_results($sql) or die(mysql_error());
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

<table class='table'>
    <tr>
        <td>id</td>
        <td>Name</td>
        <td>Email</td>
        <td>Image</td>
        <td>Forme</td>
        <td>Action</td>
    </tr>
    <?php
foreach ($results as $r) {
    ?>
    <tr>
        <td><?php echo $r->id; ?></td>
        <td><?php echo $r->name; ?></td>
        <td><?php echo $r->email; ?></td>
        <td><img src="data:image/png;base64,<?php echo $r->image; ?>" alt="Contact Image" style="max-width: 100px;"></td>
        <td><?php echo $r->forme; ?></td>
        <td>
            <form method="post" style="display:inline-block;">
                <input type="hidden" name="contact_id" value="<?php echo $r->id; ?>">
                <button type="submit" name="edit_contact" class="btn btn-warning">Edit</button>
                <button type="submit" name="delete_contact" class="btn btn-danger">Delete</button>
            </form>
            <!-- Add the image upload form for each contact -->
            <form method="post" enctype="multipart/form-data" style="display:inline-block;">
                <input type="hidden" name="contact_id" value="<?php echo $r->id; ?>">
                <input type="file" name="uploaded_image" accept=".jpg, .jpeg, .png">
                <button type="submit" name="image_upload" class="btn btn-success">Upload Image</button>
            </form>
        </td>
    </tr>
    <?php
    // Display the edit form if the Edit button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_contact']) && $_POST['contact_id'] == $r->id) {
        ?>
    <tr>
        <!-- ... (existing code for displaying edit form) ... -->
    </tr>
    <?php
    }
}
?>
</table>

<?php
get_footer();
?>
