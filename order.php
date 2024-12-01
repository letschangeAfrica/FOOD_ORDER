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
            if(isset($_POST['submit'])){
                // Get all details
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

                // Save the order in database
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
                    // Query executed and order saved
                    $order_id = mysqli_insert_id($conn); // Get the last inserted ID

                    // Output success message and trigger JavaScript for PDF
                    echo "
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const { jsPDF } = window.jspdf;
                            const pdf = new jsPDF();

                            // Order details
                            const food = '$food';
                            const price = $price;
                            const qty = $qty;
                            const total = $total;
                            const customerName = '$customer_name';
                            const customerContact = '$customer_contact';
                            const customerEmail = '$customer_email';
                            const customerAddress = '$customer_address';

                            // Generate PDF
                            pdf.setFont('helvetica', 'bold');
                            pdf.setFontSize(20);
                            pdf.text('Order Receipt', 105, 20, { align: 'center' });

                            pdf.setFont('helvetica', 'normal');
                            pdf.setFontSize(12);
                            pdf.text('Customer Name: ' + customerName, 10, 40);
                            pdf.text('Contact: ' + customerContact, 10, 50);
                            pdf.text('Email: ' + customerEmail, 10, 60);
                            pdf.text('Address: ' + customerAddress, 10, 70);

                            pdf.text('Food: ' + food, 10, 90);
                            pdf.text('Price: ' + price + ' XAF', 10, 100);
                            pdf.text('Quantity: ' + qty, 10, 110);
                            pdf.text('Total: ' + total + ' XAF', 10, 120);

                            pdf.setFont('helvetica', 'bold');
                            pdf.text('Thank you for your order!', 10, 140);

                            // Save the PDF
                            const fileName = 'Order_Receipt_' + Date.now() + '.pdf';
                            pdf.save(fileName);

                            // Redirect to success page
                            setTimeout(() => {
                                window.location.href = '".SITEURL."index.php?success=true&order_id=".$order_id."';
                            }, 1000); // Allow time for the PDF to download
                        });
                    </script>
                    ";
                } else {
                    // Query failed, display error message and redirect
                    $_SESSION['order'] = "<div class='error text-center'>Failed to order Food.</div>";
                    header('Location:' . SITEURL);
                }

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
