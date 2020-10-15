<?php

while ($row = mysqli_fetch_array($real_data)) {
    // 실행할 때마다 한행씩 보여주고 값이 없으면 null 속성을 이용하여 반복문을 돌릴 수 있다
    ?>
    <tbody>
    <tr>
        <td align="center"><?= substr($row['order_no'], 4); ?><br>(<?= $row['u_id'] ?>)</td>
        <td>
            <?php
            $order_data = json_decode($row['order_data'], true);
            $i = 0;
            foreach ($order_data as $keys => $values) {
            $sql = "SELECT * FROM fesitval WHERE id ={$values['f_id']}";
            $res = mysqli_query($conn, $sql);
            $row2 = mysqli_fetch_array($res);
            $tal = $row2['price'] * $values["quantity"];
            ?>
            <table class="table">
                <tr>
                    <td width="60%">
                        <img src="img/<?= $row2['img']; ?>"
                             style="height: 30px;"><?= $row2['title'];?>
                    </td>
                    <td align="right" width="20%">
                        <?= $values["quantity"]; ?>장
                    </td>
                    <td align="right" width="20%"><?php
                        if ($values["status"] == 0) {
                            //주문완료, 티켓 발송 전
                            ?>
                            <form method="post">
                                <input type="hidden" name="idx" value="<?= $i;?>">
                                <input type="hidden" name="jsonData" value='<?= $row['order_data']; //버튼 클릭시 변수에 담을 json 데이터 ?>'>
                                <input type="hidden" name="orderNo" value="<?= $row['order_no']; //버튼 클릭시(2) WHERE 구분해줄 order_no ?>">
                                <input type="submit" value="티켓발송">
                            </form>
                            <?php
                            //클릭시, (고유값)order_no & f_id 값을 넘겨준다
                            //-> "status"의 값을 1로 update 해주기
                        } elseif ($values ["status"] == 1) {
                            //주문 완료, 티켓 발송 후
                            ?>
                            <form method="post" hidden>
                                <input type="hidden" name="idx" value="<?= $i;?>">
                                <input style="color: #ff2e2a;" type="submit" name="fin" value="발송완료">
                            </form>
                            <div style="color: #007bff;">발송완료</div>
                            <?php
                        }
                        ?></td>
                    <td hidden>
                        <?= $i++; //json 데이터를 추출하기 위해 가상의 인덱스를 만듦 ?>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>총 결제금액</td>
                    <td align="right" colspan="2">￦ <?= number_format($row['price']); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    </tbody>
    <?php
    if ($row == false) {
        exit;
    }
}
