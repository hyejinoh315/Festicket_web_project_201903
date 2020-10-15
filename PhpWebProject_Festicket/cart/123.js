var express = require('express');
var app = express();
var axios = require('axios');

function cancelPay() {
    <!-- Node.js -->
    /* ... 중략 ... */

    app.post('/payments/cancel', async (req, res, next) => {
        try {
            /* 액세스 토큰(access token) 발급 */
            const getToken = await axios({
                url: "https://api.iamport.kr/users/getToken",
                method: "post", // POST method
                headers: {
                    "Content-Type": "application/json"
                },
                data: {
                    imp_key: "0227147315017718", // [아임포트 관리자] REST API키
                    imp_secret: "8cqURkOXy7KIAs5NZ7YGS6AGmlLfThW2tmWlHLjgS3Ytv4guceb4lLLH6wW0NT2hgZDXLWdEZc7vgoZt" // [아임포트 관리자] REST API Secret
                }
            });
            const { access_token } = getToken.data.response; // 엑세스 토큰
            console.log(getToken.data.response);
            /* 결제정보 조회 */

        } catch (error) {
            res.status(400).send(error);
        }
    });

}