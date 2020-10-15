var doc = document;
var sign = doc.getElementById('signupButton');

var func = function () {
    //1. 정보를 전부 취합한다
    var id = doc.getElementById('userId').value;
    var pw = doc.getElementById('userPass').value;
    var check = doc.getElementById('passCheck').value;
    var tel = doc.getElementById('userPhone').value;
    // 취합된 정보 확인 console.log(변수명);

    //2. 예외처리: 빈 칸 없이 다 입력되었는지 확인한다
    if (!id) {
        alert('아이디를 입력해 주세요');
        //커서 이동
        doc.getElementById('userId').focus();
        return;
    }
    if (!pw) {
        alert('비밀번호를 입력해 주세요');
        //커서 이동
        doc.getElementById('userPass').focus();
        return;
    }
    if (!check) {
        alert('비밀번호를 입력해 주세요');
        //커서 이동
        doc.getElementById('passCheck').focus();
        return;
    }
    if (!tel) {
        alert('전화번호를 입력해 주세요');
        //커서 이동
        doc.getElementById('userPhone').focus();
        return;
    }


    //3. 비밀번호 일치 확인
    if (pw != check) {
        alert('비밀번호가 서로 다릅니다');
        //비밀번호를 공백으로 만든다
        doc.getElementById('userPass').value = '';
        doc.getElementById('passCheck').value = '';

        doc.getElementById('userPass').focus();
        return;
    }

    //4. 비밀번호 길이 확인
    if (pw.length < 6) {
        alert('비밀번호는 최소 6자리 이상 작성해야 합니다');
        doc.getElementById('userPass').value = '';
        doc.getElementById('passCheck').value = '';

        doc.getElementById('userPass').focus();
        return;
    }

    //5. 핸드폰 정규식 확인
    tel = tel.split('-').join('');
    var regExp = /^((01[1|6|7|8|9])[1-9]+[0-9]{6,7})|(010[1-9][0-9]{7})$/;
    //var regExp = /^\d{3}-\d{3,4}-\d{4}$/;
    if (!regExp.test(tel)) {
        alert('휴대폰번호 형식이 아닙니다');
        doc.getElementById('userPhone').value = '';
        doc.getElementById('userPhone').focus();
        return;
    }
    //alert('가입이 완료 되었습니다');
    if(doc.getElementById('chk1').checked == false){
        alert('필수 이용약관에 동의해 주세요');
        doc.getElementById('ck1').focus();
        return;
    }
    if(doc.getElementById('chk2').checked == false){
        alert('개인정보 수집 및 이용에 동의해 주세요');
        doc.getElementById('ck2').focus();
        return;
    }
};
sign.addEventListener('click', func);