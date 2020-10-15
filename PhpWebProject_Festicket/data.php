<?php
while ($row = mysqli_fetch_array($result)) { // 실행할 때마다 한행씩 보여주고 값이 없으면 null 속성을 이용하여 반복문을 돌릴 수 있다
    echo "<div class=\"col-lg-4 col-sm-6 portfolio-item\">
        <div class=\"card h-100\">
          <a href=\"festivals_post.php?id={$row['id']}\"><img class=\"card-img-top\" src=\"img/{$row['img']}\" alt=\"\"></a>
          <div class=\"card-body\">
            <h4 class=\"card-title\">
              <a href=\"festivals_post.php?id={$row['id']}\" style=\"color: #000;\">{$row['title']}</a>
            </h4>
            <p class=\"card-text\">{$row['date']} ~ {$row['date_end']}<br>{$row['locate']}</p>
            <div style='float: left;'><a href='festivals_post.php?id={$row['id']}' class='btn btn-primary' style='background-color: black; border: white'>더 알아보기</a></div>
            <div style='float: right;'><form method=\"post\" action=\"cart/index.php?id={$_SESSION['id']}{$row['id']}\">
                <input type=\"hidden\" name=\"hidden_name\" value=\"{$row['title']}\" />
                <input type=\"hidden\" name=\"hidden_price\" value=\"{$row['price']}\" />
                <input type=\"hidden\" name=\"hidden_id\" value=\"{$row['id']}\" />
                <input type='number' min='1' name='quantity' value='1' style='width: 50px'";
    include('timeCompare.php');
    echo"/>
                <input type=\"submit\" name=\"add_to_cart\" value=\"cart\" class=\"btn btn-primary\"
                       style=\"font-family: monospace; height: auto; color: #fff; background-color: #ff5f33; border: white\"";
    include('timeCompare.php');
    echo">";
    if($str_now > $str_target) {
        echo "<div style='color: brown'>판매종료</div>";
    } elseif ($str_now == $str_target) {
        echo "<div style='color: darkblue;'>당일티켓 현장구매 가능</div>";
    }
    echo "</form></div>
          </div>
        </div>
      </div>";
    if ($row == false) {
        exit;
    }
}
?>