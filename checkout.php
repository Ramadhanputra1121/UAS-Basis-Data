<?php
session_start();

// Memastikan bahwa user telah menambahkan produk ke dalam keranjang sebelum mengakses halaman checkout
if (!isset($_SESSION['cart'])) {
  header("Location: cart.php");
}

require_once("php/CreateDb.php");
require_once("php/component.php");

$db = new CreateDb("project_uas_basdat", "producttb");

// Menangani pengurangan jumlah produk
if (isset($_POST['minus'])) {
  if ($_GET['action'] == 'minus') {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($value["product_id"] == $_GET['id']) {
        if ($_SESSION['cart'][$key]['quantity'] >= 1) { // menambahkan pengecekan agar jumlah produk tidak menjadi negatif
          $_SESSION['cart'][$key]['quantity']--;
        }
      }
    }
  }
}

// Menangani penambahan jumlah produk
if (isset($_POST['plus'])) {
  if ($_GET['action'] == 'plus') {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($value["product_id"] == $_GET['id']) {
        $_SESSION['cart'][$key]['quantity']++;
      }
    }
  }
}

// Menangani penghapusan produk dari keranjang
if (isset($_POST['remove'])) {
  if ($_GET['action'] == 'remove') {
    foreach ($_SESSION['cart'] as $key => $value) {
      if ($value["product_id"] == $_GET['id']) {
        unset($_SESSION['cart'][$key]);
      }
    }
  }
}

// Menghitung total harga per produk
function calculateProductTotalPrice($product_id, $product_quantity, $db)
{
  $result = $db->getData();
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['id'] == $product_id) {
      return (int) $row['product_price'] * (int) $product_quantity;
    }
  }
}

// Menghitung total harga keseluruhan
$total_price = 0;
foreach ($_SESSION['cart'] as $value) {
  $product_total_price = calculateProductTotalPrice($value['product_id'], $value['quantity'], $db);
  $total_price += $product_total_price;
}

// Menampilkan daftar produk yang ada dalam keranjang belanja
if (isset($_SESSION['cart'])) {
  $cart_count = count($_SESSION['cart']);
}

?>

<!doctype html <html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Checkout</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />

  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
  <?php
  require_once('php/header.php');
  ?>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Item List</h4>
          </div>
          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
              </tr>
              <?php foreach ($_SESSION['cart'] as $value) {
                $result = $db->getData();
                while ($row = mysqli_fetch_assoc($result)) {
                  if ($row['id'] == $value['product_id']) {
                    ?>
                <tr>
                  <td>
                    <?php echo $row['product_name']; ?>
                  </td>
                  <td>$<?php echo $row['product_price']; ?></td>
                  <td>
                    <form action="checkout.php?action=minus&id=<?php echo $value['product_id']; ?>" method="post">
                      <button type="submit" name="minus" value="minus" class="btn btn-danger">-</button>
                    </form>
                    <?php echo $value['quantity']; ?>
                    <form action="checkout.php?action=plus&id=<?php echo $value['product_id']; ?>" method="post">
                      <button type="submit" name="plus" value="plus" class="btn btn-success">+</button>
                    </form>
                  </td>
                  <td>
                    $<?php echo calculateProductTotalPrice($value['product_id'], $value['quantity'], $db); ?>
                  </td>
                </tr>
              <?php }
                }} ?>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Payment Information</h4>
          </div>
          <div class="card-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="metodePembayaran">Payment method</label>
                <select name="metodePembayaran" id="metodePembayaran" class="form-control">
                  <option value="">Choose Payment method</option>
                  <option value="transfer">Bank Transfer</option>
                  <option value="kartuKredit">Credit Card</option>
                  <option value="kartuKredit">Cash On Delivery</option>
                </select>
              </div>
              <div class="form-group">
                <label for="totalHarga">Total Price</label>
                <input type="text" class="form-control" value="$<?php echo $total_price; ?>" id="totalHarga"
                  name="totalHarga" readonly>
              </div>
              <div class="form-group">
                <label for="namaPenerima">Recipient's Name</label>
                <input type="text" class="form-control" id="namaPenerima" name="namaPenerima" required>
              </div>
              <div class="form-group">
                <label for="alamatPengiriman">Shipping Address</label>
                <textarea name="alamatPengiriman" id="alamatPengiriman" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="checkout">Buy Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>