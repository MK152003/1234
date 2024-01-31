<?php
// Include the connection file
include('connection.php');

// Function to get the next serial number based on the current highest serial number in the database
function getNextSerialNumber($conn) {
    $result = $conn->query("SELECT MAX(SUBSTRING(invoice_num, 2, 4)) AS maxSerial FROM invoices");
    $row = $result->fetch_assoc();
    $maxSerial = $row['maxSerial'];

    if ($maxSerial === null) {
        return 'A0001';
    }

    $nextSerial = intval($maxSerial) + 1;

    // If the serial number exceeds 9999, reset to 1 and increment the alphabet
    if ($nextSerial > 9999) {
        $nextSerial = 1;
        $nextAlphabet = getNextAlphabet(substr($row['maxSerial'], 0, 1));
        return $nextAlphabet . sprintf('%04d', $nextSerial);
    }

    // Pad the serial number with leading zeros
    return 'A' . sprintf('%04d', $nextSerial);
}

// Function to get the next alphabet (e.g., A to B, B to C, etc.)
// Function to get the next alphabet (e.g., A to B, B to C, etc.)
function getNextAlphabet($alphabet) {
    $alphabet = strtoupper($alphabet); // Convert to uppercase to handle case sensitivity

    if ($alphabet === 'Z') {
        return 'A';
    } else {
        // Increment the alphabet
        return chr(ord($alphabet) + 1);
    }

}


// Define variables to store form data
$name = $phone = $address = $date = $dueDate = $securityCount = $securityAmount = '';
$companySecurityCount = $companySecurityAmount = $personalSecurityCount = $personalSecurityAmount = '';
$privateSecurityCount = $privateSecurityAmount = $ladySecurityCount = $ladySecurityAmount = $gst = $modeOfPayment = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generate an invoice number
    $invoiceNumber = getNextSerialNumber($conn) . date('y');

    // Fetch values from the form
    $name = $_POST['name'];
    $phone = $_POST['pno'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $dueDate = $_POST['duedate'];
    $securityCount = $_POST['security'];
    $securityAmount = $_POST['securityamt'];
    $companySecurityCount = $_POST['csecurity'];
    $companySecurityAmount = $_POST['csecurityamt'];
    $personalSecurityCount = $_POST['personalsecurity'];
    $personalSecurityAmount = $_POST['personalsecurityamt'];
    $privateSecurityCount = $_POST['privatecsecurity'];
    $privateSecurityAmount = $_POST['privatesecurityamt'];
    $ladySecurityCount = $_POST['lsecurity'];
    $ladySecurityAmount = $_POST['lsecurityamt'];
    $gst = $_POST['gst'];
    $modeOfPayment = $_POST['mop'];

    // Insert data into the database, including the invoice number
    $sql = "INSERT INTO invoices (invoice_num, name, phone, address, date, due_date, security_count, security_amount, company_security_count, company_security_amount, 
            personal_security_count, personal_security_amount, private_security_count, private_security_amount, lady_security_count, lady_security_amount, gst, mode_of_payment)
            VALUES ('$invoiceNumber', '$name', '$phone', '$address', '$date', '$dueDate', '$securityCount', '$securityAmount', '$companySecurityCount', '$companySecurityAmount', 
            '$personalSecurityCount', '$personalSecurityAmount', '$privateSecurityCount', '$privateSecurityAmount', '$ladySecurityCount', '$ladySecurityAmount', '$gst', '$modeOfPayment')";

    if ($conn->query($sql) === TRUE) {
        echo "Invoice generated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>




<!DOCTYPE html>
<html>
    <head>
        <title>Invoice</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container-fluid">
            <h3>Invoice details</h3>
            <form id="detailsForm" method="post" action="home.php">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Phone Number:</label>
                            <input type="text" name="pno" id="pno" class="form-control" placeholder="Phone Number" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label> Address:</label>
                            <textarea name="address" id="address" class="form-control" placeholder="Address"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Date:</label>
                            <input type="date" name="date" id="date" class="form-control" placeholder="Date" >
                        </div>
                    </div>

                    <div class="col-md-6">
                            <div class="form-group">
                                <label> Due Date:</label>
                                <input type="date" name="duedate" id="duedate" class="form-control" placeholder="Date" >
                            </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Security Guard:</label>
                            <input type="number" name="security" id="security" class="form-control" placeholder="Number of Security Guards">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Amount:</label>
                            <input type="number" name="securityamt" id="securityamt" class="form-control" placeholder="Security Amount" >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Company Security:</label>
                            <input type="number" name="csecurity" id="csecurity" class="form-control" placeholder="Number of Company Security">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Amount:</label>
                            <input type="number" name="csecurityamt" id="csecurityamt" class="form-control" placeholder="Company Security Amount" >
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Personal Security:</label>
                            <input type="number" name="personalsecurity" id="personalsecurity" class="form-control" placeholder="Number of Personal Security">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Amount:</label>
                            <input type="number" name="personalsecurityamt" id="personalsecurityamt" class="form-control" placeholder=" Personal Security Amount" >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Private Security:</label>
                            <input type="number" name="privatecsecurity" id="privatesecurity" class="form-control" placeholder="Number of Private Security">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Amount:</label>
                            <input type="number" name="privatesecurityamt" id="privatesecurityamt" class="form-control" placeholder="Private Security Amount">
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Lady Security Guard:</label>
                            <input type="number" name="lsecurity" id="lsecurity" class="form-control" placeholder="Number of Lady Security">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Amount:</label>
                            <input type="number" name="lsecurityamt" id="lsecurityamt" class="form-control" placeholder=" Lady Security Amount" >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> GST</label>
                            <input type="number" name="gst" id="gst" class="form-control" placeholder="GST">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Mode of Payment </label>
                            <select name="mop" id="mop" class="form-control">
                                <option>Cash</option>
                                <option>Online</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        
                        <button type="submit" class="btn" style="width: auto; margin-top: 25px;">Generate Invoice</button>
                        <button type="button" class="btn" id="clearBtn" style="width: auto; margin-top: 25px; margin-left: 10px;">Clear</button>
                    </div>
                </div>

             </form>

        </div>
    </body>
</html>