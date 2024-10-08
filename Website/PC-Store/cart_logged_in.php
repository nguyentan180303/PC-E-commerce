<?php

include 'db.php';
if (empty($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["id_user"]))
    header('Location: index.php');
    
if (isset($_SESSION['couponApplyed']))
    unset($_SESSION["couponApplyed"]);

if (isset($_SESSION["id_current_cmd"])) {
    $idCmd = $_SESSION["id_current_cmd"];
    $query = "DELETE FROM commande WHERE (idCommande = '$idCmd')";
    $result = mysqli_query($con, $query);

    $query = "DELETE FROM commande_produits WHERE (idCommande = '$idCmd')";
    $result = mysqli_query($con, $query);
}

$cart = false;
$query = "SELECT * FROM panier_produits WHERE (idClient = " . $_SESSION['id_user'] . ")";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    $cart = true;
}

$query = "SELECT * FROM panier_produits NATURAL JOIN produit  WHERE (idClient = " . $_SESSION['id_user'] . ")";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['stock'] == 0) {

        $query = "UPDATE panier_produits SET quantite = '0' WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
        $result1 = mysqli_query($con, $query);
        $_SESSION['cartItems'] -= $row['quantite'];
    } else if ($row['quantite'] > $row['stock']) {

        $query = "UPDATE panier_produits SET quantite = " . $row['stock'] . " WHERE (idClient = " . $_SESSION['id_user'] . " AND idProduit = " . $row['idProduit'] . ")";
        $result1 = mysqli_query($con, $query);
        $_SESSION['cartItems'] -= $row['quantite'] - $row['stock'];
    }
}

$query = "SELECT * FROM panier_produits NATURAL JOIN produit  WHERE (idClient = " . $_SESSION['id_user'] . ")";
$result = mysqli_query($con, $query);

$query = "SELECT * FROM types_livraisons";
$result2 = mysqli_query($con, $query);



?>
<!doctype html>
<html class="no-js" lang="en">

<?php include 'templates/head.php'; ?>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">Bạn đang sử dụng một trình duyệt <strong>lỗi thời</strong>. Vui lòng <a href="http://browsehappy.com/">nâng cấp trình duyệt của bạn</a> để cải thiện trải nghiệm.</p>
    <![endif]-->

    <!-- Bắt đầu wrapper chính của body -->
    <div class="wrapper fixed__footer">
        <!-- Bắt đầu Kiểu Header -->
        <?php include 'templates/header.php'; ?>
        <!-- Kết thúc Kiểu Header -->

        <div class="body__overlay"></div>
        <!-- Bắt đầu Wrapper Offset -->
        <div class="offset__wrapper">
            <!-- Bắt đầu Popup Tìm kiếm -->
            <?php include 'templates/search.php'; ?>

            <?php   
              $arr=array();

              $arr2 = array();
                    $quer = "SELECT * FROM produit ";
                    $resul = mysqli_query ($con,$quer)or die(mysqli_error($con));
                    if(mysqli_num_rows($resul) > 0) 
                    {   
                        while($rowse = mysqli_fetch_assoc($resul)) 
                        { $arr[]=$rowse['nom_prod'];
                          $arr2[] = $rowse["idProduit"];
                           $path="images/".$rowse['img_prod']."";
                           $arrimage[]=$path;
                       }}
                   
                             
              ?>
            
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <?php
        include 'templates/bradcaump.php';

        // Thêm đoạn code này sau phần offset wrapper và trước phần cart-main-area
        if (!$cart) {
            renderBradcaump(
                'Giỏ hàng trống',
                [
                    ['url' => 'index.php', 'text' => 'Trang chủ / '],
                    ['text' => 'Giỏ hàng trống']
                ]
            );
            echo '<a class="continuer" href="index.php">Tiếp tục mua sắm</a>';
        } else {
            renderBradcaump(
                'Giỏ hàng',
                [
                    ['url' => 'index.php', 'text' => 'Trang chủ / '],
                    ['text' => 'Giỏ hàng']
                ]
            );
        }

        ?>
        <!-- Kết thúc khu vực Bradcaump -->
        <!-- Bắt đầu khu vực chính của giỏ hàng -->

        <div class="cart-main-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-thumbnail">Hình ảnh</th>
                                            <th class="product-name">Sản phẩm</th>
                                            <th class="product-price">Đơn giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Tổng phụ</th>
                                            <th class="product-remove">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $totalFinal = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $prix = $row['prix'] * (1 - $row['promo'] / 100);
                                        ?>
                                        <tr>
                                            <td class="product-thumbnail"><a href="product-details.php?idprod=<?php echo $row["idProduit"]; ?>"><img src="images/<?php echo $row['img_prod']; ?>" alt="hình ảnh sản phẩm" /></a></td>
                                            <td class="product-name"><a href="product-details.php?idprod=<?php echo $row["idProduit"]; ?>"><?php echo $row['nom_prod']; ?></a></td>
                                            <td class="product-price"><span class="amount"><?php echo $prix; ?> VNĐ</span></td>
                                            <td class="product-quantity">
                                                <form class="change-quantity" method="post" action="" role="form">
                                                    <?php
                                                    if ($row['stock'] == 0) {
                                                        echo '<input type="number" style="display: none;" name="quantity" value="0" min="1" max="' . $row['stock'] . '" />';
                                                        echo '<span class="comments">Hết hàng</span>';
                                                        $total = 0;
                                                    } else if ($row['quantite'] > $row['stock']) {
                                                        echo '<input type="number" name="quantity" value="' . $row['stock'] . '" min="1" max="' . $row['stock'] . '" />';
                                                        $total = $row['stock'] * $prix;
                                                    } else {
                                                        echo '<input type="number" name="quantity" value="' . $row['quantite'] . '" min="1" max="' . $row['stock'] . '" />';
                                                        $total = $row['quantite'] * $prix;
                                                    }
                                                    $totalFinal += $total;
                                                    ?>
                                                    <input type="hidden" name="id_product" value="<?php echo $row['idProduit']; ?>" />
                                                </form>
                                            </td>
                                            <td class="product-subtotal"><?php echo $total; ?></td>
                                            <td class="product-remove">
                                                <form class="remove-product" method="post" action="" role="form">
                                                    <a href="#/"><span class="ti-trash" style="font-size: 25px;"></span></a>
                                                    <input type="hidden" name="id_product" value="<?php echo $row['idProduit']; ?>" />
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    $_SESSION["montantGlobale"] = $totalFinal;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-7 col-xs-12">
                                    <div class="buttons-cart">
                                        <a href="#/">Xóa giỏ hàng</a>
                                        <a href="index.php">Tiếp tục mua sắm</a>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4 col-sm-5 col-xs-12">
                                    <div class="cart_totals">
                                        <h2>Tổng kết</h2>
                                        <table>
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Tổng cộng</th>
                                                    <td><span id="sous_amount" class="amount"><?php echo $totalFinal; ?> VNĐ</span></td>
                                                </tr>
                                                <tr class="shipping">
                                                    <th>Vận chuyển</th>
                                                    <td>
                                                        <?php
                                                        $row2 = mysqli_fetch_assoc($result2);
                                                        $bilan = $row2['prix_livraison'] + $totalFinal;
                                                        $_SESSION["type_livr"] = $row2['id_type'];
                                                        ?>
                                                        <form class="livraison" method="post" action="" role="form">
                                                            <ul id="shipping_method">
                                                                <li>
                                                                    <input type="radio" id="<?php echo $row2['nom_type']; ?>" name="type_livraison" value="<?php echo $row2['id_type']; ?>" checked>
                                                                    <label for="<?php echo $row2['nom_type']; ?>">
                                                                        <?php echo $row2['nom_type']; ?>: <span class="amount"><?php echo $row2['prix_livraison']; ?> VNĐ</span>
                                                                    </label>
                                                                </li>
                                                                <?php
                                                                $row2 = mysqli_fetch_assoc($result2);
                                                                ?>
                                                                <li>
                                                                    <input type="radio" id="<?php echo $row2['nom_type']; ?>" name="type_livraison" value="<?php echo $row2['id_type']; ?>">
                                                                    <label for="<?php echo $row2['nom_type']; ?>">
                                                                        <?php echo $row2['nom_type']; ?>: <span class="amount"><?php echo $row2['prix_livraison']; ?> VNĐ</span>
                                                                    </label>
                                                                </li>
                                                                <li></li>
                                                            </ul>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <tr class="order-total">
                                                    <th>Tổng thanh toán</th>
                                                    <td>
                                                        <strong><span id="final_amount" class="amount "><?php echo $bilan; ?> VNĐ</span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <form class="achat" method="post" action="" role="form">
                                            <div class="wc-proceed-to-checkout">
                                                <a href="#/">Hoàn tất đơn hàng</a><br><br>
                                                <span id="cmdError" class="comments"></span>
                                            </div>
                                            <input type="text" style="display: none;" name="type_livr" value="<?php echo $_SESSION["type_livr"]; ?>" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-main-area end -->
        <!-- Start Footer Area -->
        <?php include 'templates/footer.php'; ?>
        <!-- End Footer Area -->
    </div>
    
 <script>
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;
  function autocomplete(inp, arr, arr2) {

  var currentFocus;
  
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
     
      closeAllLists();
     if(!val) {
        const button=document.querySelector('button[type="submit"]');
button.disabled=true;

     }
      currentFocus = -1;
      
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
       
      this.parentNode.appendChild(a);

if( val=="" || val==" " || val=="  " || val=="   " || val=="    " || val.indexOf("    " )>-1){

    const button=document.querySelector('button[type="submit"]');
button.disabled=true;
const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Áp dụng stylesheet cho tài liệu:
document.adoptedStyleSheets = [sheet];

}    
else{
      var y=0;
      for (i = 0; i < arr.length; i++) { 
   for(var l=0;l<arr[i].length;l++){
        if (arr[i].substr(l, val.length).toUpperCase() == val.toUpperCase() ) {
            console.log(arr[i]);
          y++;

          l=document.createElement("a");
          l.href="product-details.php?idprod=" + arr2[i];
          ul=document.createElement("ul");
          b = document.createElement("DIV");
          b.className='good';
          li=document.createElement("li");
          li.setAttribute("class", "li_search");   
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<a style='color:black;' href='product-details.php?idprod=" + arr2[i] + "'>" + arr[i] + "</a>";
          
          var iconurl =  <?php echo json_encode($arrimage); ?>;
          var img = document.createElement("img"); 
            img.src=iconurl[i];
            img.width=50;
             img.height=50;
             li.appendChild(img);
             li.appendChild(p);
             b.appendChild(li);
             l.appendChild(b);
          b.addEventListener("click", function(e) {
         
              inp.value = this.getElementsByTagName("input")[0].value;
        
              closeAllLists();
          });
          a.appendChild(l);
          
        }
}
      }
      if(y>7) {
        console.log(y);
          b.setAttribute("id", "invisible_");
          
          const sheet = new CSSStyleSheet();
           sheet.replaceSync('.autocomplete-items {height: 371px}');

// Áp dụng stylesheet cho tài liệu:
          document.adoptedStyleSheets = [sheet];
          const button=document.querySelector('button[type="submit"]');
          button.disabled=false;
 }
 else if(y==0) {
          b = document.createElement("DIV");
          b.className='good';
          p=document.createElement("p");
          p.setAttribute("class","p-search");

 
          p.innerHTML += "<p style='color:black;' > không có kết quả..</a>";              
             b.appendChild(p);
           
           
          b.addEventListener("click", function(e) {
         
              inp.value = this.getElementsByTagName("input")[0].value;
        
              closeAllLists();
          });
          a.appendChild(b);
    
    const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Áp dụng stylesheet cho tài liệu:
document.adoptedStyleSheets = [sheet];

const button=document.querySelector('button[type="submit"]');
button.disabled=true;
 }
 else {
    const sheet = new CSSStyleSheet();
    sheet.replaceSync('.autocomplete-items {height: auto ; overflow-y: unset; scroll-behavior: unset}');

// Áp dụng stylesheet cho tài liệu:
document.adoptedStyleSheets = [sheet];
const button=document.querySelector('button[type="submit"]');
button.disabled=false;
 }

}
  });
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
      
        currentFocus++;
        addActive(x);
      } else if (e.keyCode == 38) { 
        
        currentFocus--;
        addActive(x);
      } else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
   
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

var myvar = <?php echo json_encode($arr); ?>;
var myvar2 = <?php echo json_encode($arr2); ?>;
autocomplete(document.getElementById("myInput"), myvar, myvar2);
</script>
</body>

</html>