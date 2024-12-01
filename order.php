<?php include('partial-front/menu.php'); ?>
<?php
    if (isset($_GET['food_id'])) {
        //Get the food id and details of the selected food
        $food_id = $_GET['food_id'];

        //Get the details of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            //We have data
            //Get data from database
            $row = mysqli_fetch_assoc($res);
            $title = $row["title"];
            $price = $row["price"];
            $image_name = $row["image_name"];
        }
        else{
            //Food Not available
            //Redirect to Home page
            header('Location:' .SITEURL);
        }
    }
    else{
        header('Location:' .SITEURL);
    }
?>
<!-- Food Search Section Starts Here -->
<section class="food-search-order">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <!-- Single form for order and contact details -->
        <form action="" method="POST" class="order1" id="orderForm">
            <fieldset id="premier">
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                        if($image_name == ""){
                            echo "<div class='error'>Image not Available</div>";
                        } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Cookies" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>
                <br>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price"><?php echo $price; ?> XAF</p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Ismael KAGOU" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <!-- Confirm Order Button with JavaScript Alert -->
                <button type="button" id="confirmOrderButton" onclick="confirmOrder()" class="btn btn-primary" data-clicked="false">Confirm Order</button>
            </fieldset>
        </form>

        <?php
        // Include FPDF library
            require('fpdf.php');  // Adjust the path to where your fpdf.php file is located

            // Order form handling part
    if (isset($_POST['submit'])) {
        // Get all order details
        $food = $_POST['food'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $total = $price * $qty;
        $order_date = date("Y-m-d H:i:sa"); // Order Date
        $status = "Ordered"; // Ordered, On delivery, Delivered, Cancelled
        $customer_name = $_POST['full-name'];
        $customer_contact = $_POST['contact'];
        $customer_email = $_POST['email'];
        $customer_address = $_POST['address'];

        // Save the order in the database
        $sql2 = "INSERT INTO tbl_order SET
            food = '$food',
            price = $price,
            qty = $qty,
            total = $total,
            order_date = '$order_date',
            status = '$status',
            customer_name = '$customer_name',
            customer_contact = '$customer_contact',
            customer_email = '$customer_email',
            customer_address = '$customer_address'
        ";

        $res2 = mysqli_query($conn, $sql2);
        if ($res2 == true) {
            // Order saved successfully
            $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";

            // Generate PDF
            generateOrderPDF($food, $price, $qty, $total, $order_date, $customer_name, $customer_contact, $customer_email, $customer_address);

            // Redirect after PDF generation
            header('Location: ' . SITEURL . 'index.php'); // Redirect to the success page
        } else {
            $_SESSION['order'] = "<div class='error text-center'>Failed to order Food.</div>";
            header('Location: ' . SITEURL);
        }
    }

    // Function to generate the order PDF using FPDF
    function generateOrderPDF($food, $price, $qty, $total, $order_date, $customer_name, $customer_contact, $customer_email, $customer_address) {
        // Create new FPDF object
        $pdf = new FPDF();
        $pdf->AddPage();  // Add a page to the PDF

        // Set title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(200, 10, 'Order Confirmation', 0, 1, 'C');  // Title in center

        // Order details section
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10); // Line break

        $pdf->Cell(0, 10, 'Order Date: ' . $order_date, 0, 1);
        $pdf->Cell(0, 10, 'Customer Name: ' . $customer_name, 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $customer_contact, 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $customer_email, 0, 1);
        $pdf->Cell(0, 10, 'Address: ' . $customer_address, 0, 1);

        // Food details section
        $pdf->Ln(10); // Line break
        $pdf->Cell(0, 10, 'Food Ordered: ' . $food, 0, 1);
        $pdf->Cell(0, 10, 'Price per unit: ' . $price . ' XAF', 0, 1);
        $pdf->Cell(0, 10, 'Quantity: ' . $qty, 0, 1);
        $pdf->Cell(0, 10, 'Total: ' . $total . ' XAF', 0, 1);

        // Output the PDF to browser
        $pdf->Output('order_confirmation.pdf', 'I'); // 'I' for inline (will display in browser)
    }
        ?>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<!-- Payment Information Modal -->
<div id="paymentModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePaymentModal()">&times;</span>
        <h2>Payment</h2>

        <!-- Payment Information -->
        <div class="payment-info">
            <div class="payment-option">
                <h3>Orange Money</h3>
                <p><strong>Name:</strong> Ilona Clervie</p>
                <p><strong>Number:</strong> +237 699 000 111</p>
            </div>
            <div class="payment-option">
                <h3>MTN Mobile Money</h3>
                <p><strong>Name:</strong> Ismaël KAGOU</p>
                <p><strong>Number:</strong> +237 677 000 222</p>
            </div>
        </div>

        <!-- Fee Ranges -->
        <div class="fee-ranges">
            <h3>Transaction Fees</h3>
            <ul>
                <li>500 - 1000 XAF: <strong>+100 XAF</strong></li>
                <li>1025 - 5000 XAF: <strong>+200 XAF</strong></li>
                <li>5025 - 10000 XAF: <strong>+500 XAF</strong></li>
                <li>10000+ XAF: <strong>+1000 XAF</strong></li>
            </ul>
        </div>

        <!-- Warning Message -->
        <div class="warning">
            <p><strong>Warning:</strong> All payments are non-refundable. Please ensure your order is correct before confirming.</p>
        </div>
        <br>

        <!-- Confirmation Button -->
        <button type="button" onclick="closePaymentModal()" class="btn btn-primary">I Made Payment</button>
    </div>
</div>

<?php include('partial-front/footer.php'); ?>

<script>
    function confirmOrder() {
        const confirmButton = document.getElementById("confirmOrderButton");
        const form = document.getElementById("orderForm");
        const isClicked = confirmButton.getAttribute("data-clicked") === "true";

        if (!isClicked) {
            // First click: Display the payment information modal if the form is valid
            if (form.checkValidity()) {
                openPaymentModal();
                confirmButton.setAttribute("data-clicked", "true"); // Mark as clicked
            } else {
                // Show validation messages if fields are missing
                form.reportValidity();
            }
        } else {
            // Second click: Submit the form
            confirmButton.setAttribute("type", "submit");
            confirmButton.name = "submit"; // Set name to submit for PHP handling
            form.submit(); // Submit the form
        }
    }

    function openPaymentModal() {
        document.getElementById("paymentModal").style.display = "block";
    }

    function closePaymentModal() {
        document.getElementById("paymentModal").style.display = "none"; // Hide the modal
    }

</script>