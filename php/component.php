<?php

function component($productname, $productprice, $productimg, $productid)
{
    $element = "
    
    <div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
                <form action=\"marketplace.php\" method=\"post\">
                    <div class=\"card shadow\">
                        <div>
                            <img src=\"$productimg\" alt=\"Image1\" class=\"img-fluid card-img-top\">
                        </div>
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$productname</h5>
                            <h6>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"fas fa-star\"></i>
                                <i class=\"far fa-star\"></i>
                            </h6>
                            <p class=\"card-text\">
                                Some quick example text to build on the card.
                            </p>
                            <h5>
                                <small><s class=\"text-secondary\">$519</s></small>
                                <span class=\"price\">$$productprice</span>
                            </h5>

                            <button type=\"submit\" class=\"btn btn-warning my-3\" name=\"add\">Add to Cart <i class=\"fas fa-shopping-cart\"></i></button>
                             <input type='hidden' name='product_id' value='$productid'>
                        </div>
                    </div>
                </form>
            </div>
    ";
    echo $element;
}

function cartElement($productimg, $productname, $productprice, $productid)
{
    $element = "
    
    <form action=\"cart.php?action=remove&id=$productid\" method=\"post\" class=\"cart-items\">
                    <div class=\"border rounded\">
                        <div class=\"row bg-white\">
                            <div class=\"col-md-3 pl-0\">
                                <img src=$productimg alt=\"Image1\" class=\"img-fluid\">
                            </div>
                            <div class=\"col-md-6\">
                                <h5 class=\"pt-2\">$productname</h5>
                                <small class=\"text-secondary\">Seller: dailytuition</small>
                                <h5 class=\"pt-2\">$$productprice</h5>
                                <button type=\"submit\" class=\"btn btn-warning\">Save for Later</button>
                                <button type=\"submit\" class=\"btn btn-danger mx-2\" name=\"remove\">Remove</button>
                            </div>
                        </div>
                    </div>
                </form>
    
    ";
    echo $element;
}

function checkoutElement($product_id, $product_name, $product_price, $quantity, $subtotal)
{
    $quantity = '1';
    $element = '
      <tr>
        <td>' . $product_name . '</td>
        <td>' . $product_price . '</td>
        <td>
          <form method="POST" action="checkout.php?action=minus&id=' . $product_id . '">
            <input type="submit" value="-" name="minus" class="btn btn-secondary btn-sm">
            <input type="number" value="' . $quantity . '" name="quantity" readonly class="form-control-plaintext w-25 d-inline-block">
            <form method="POST" action="checkout.php?action=plus&id=' . $product_id . '">
              <input type="submit" value="+" name="plus" class="btn btn-secondary btn-sm">
            </form>
          </form>
        </td>
        <td>' . $subtotal . '</td>
        <td>
          <form method="POST" action="checkout.php?action=remove&id=' . $product_id . '">
            <input type="submit" value="X" name="remove" class="btn btn-danger btn-sm">
          </form>
        </td>
      </tr>';
    echo $element;
}