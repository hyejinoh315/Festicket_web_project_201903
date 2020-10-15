var doc = document;
var sign = doc.getElementById('pay_btn');

var func = function () {
    var tel = doc.getElementById('fin_tel').value;

    if (!tel) {
        alert('수신받을 휴대폰번호를 입력해 주세요');
        //커서 이동
        document.getElementById('fin_tel').focus();
        return;
    }
    tel = tel.split('-').join('');
    var regExp = /^((01[1|6|7|8|9])[1-9]+[0-9]{6,7})|(010[1-9][0-9]{7})$/;
    //var regExp = /^\d{3}-\d{3,4}-\d{4}$/;
    if (!regExp.test(tel)) {
        alert('휴대폰번호 형식이 아닙니다');
        doc.getElementById('userPhone').value = '';
        doc.getElementById('userPhone').focus();
        return;
    }
    if(doc.getElementById('chk1').checked == false){
        alert('구매조건 확인 및 결제 진행에 동의해주세요');
        doc.getElementById('ck1').focus();
        return;
    }

    var IMP = window.IMP;
    IMP.init('imp82708556');
    IMP.request_pay({
        pg: 'kakao',
        pay_method: 'card',
        merchant_uid: 'merchant_' + new Date().getTime(),
        name: doc.getElementById('product').value + ' 외 (총 ' + doc.getElementById('value').value + '개)',
        //주문명->결제창에서 보여질 이름(상품명+개수)
        amount: doc.getElementById('total').value, //주문금액
        buyer_name: doc.getElementById('name').value, //구매자 이름
        buyer_tel: doc.getElementById('tel').value //구매자 전화번호
    }, function (rsp) {
        if (rsp.success) {
            var msg = '결제가 완료되었습니다.';
            msg += '\n고유ID : ' + rsp.imp_uid;
            //msg += '\n상점 거래ID : ' + rsp.merchant_uid;
            msg += '\n결제 금액 : ' + rsp.paid_amount;
            //msg += '\n카드 승인번호 : ' + rsp.apply_num;

            var form = doc.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "payment_success.php");
            var Field1 = doc.createElement("input");
            Field1.setAttribute("type", "hidden");
            Field1.setAttribute("name", "order_no");//주문내역
            Field1.setAttribute("value", rsp.imp_uid);
            var Field2 = doc.createElement("input");
            Field2.setAttribute("type", "hidden");
            Field2.setAttribute("name", "fin_tel");//수신자번호
            Field2.setAttribute("value", tel);
            var Field3 = doc.createElement("input");
            Field3.setAttribute("type", "hidden");
            Field3.setAttribute("name", "total");//총금액
            Field3.setAttribute("value", doc.getElementById('total').value);
            form.appendChild(Field1);
            form.appendChild(Field2);
            form.appendChild(Field3);
            doc.body.appendChild(form);
            form.submit();
            //{'order_no': rsp.imp_uid, 'user_id':<?=$id?>, 'tel': document.getElementById('tel').value, 'fin_tel': tel}
        } else {
            var msg = '결제에 실패하였습니다.';
            msg += '에러내용 : ' + rsp.error_msg;
        }
        //alert(msg);
    });
};
sign.addEventListener('click', func);