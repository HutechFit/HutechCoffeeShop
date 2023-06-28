<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông tin đơn hàng</title>
</head>
<body style="
    background-color:#e2e1e0;
    font-family: Open Sans, sans-serif;
    font-size:100%;
    font-weight:400;
    line-height:1.4;
    color:#000;">
<table aria-label="Thông tin đơn hàng"
       style="max-width:670px;
                  margin:50px auto 10px;
                  background-color:#fff;
                  padding:50px;
                  -webkit-border-radius:3px;
                  -moz-border-radius:3px;
                  border-radius:3px;
                  -webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
                  -moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
                  box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);
                  border-top: solid 10px #1f1c45;">
    <thead>
    <tr>
        <th style="text-align:left;">
            <h1 style="color:#1f1c45;">
                HUTECH COFFEE
            </h1>
        </th>
        <th style="text-align:right;font-weight:400;">{{payment_date}}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="height:35px;"></td>
    </tr>
    <tr>
        <td colspan="2"
            style="border: solid 1px #ddd;
                       padding:10px 20px;">
            <p style="font-size:14px;margin:0 0 6px 0;">
                    <span style="font-weight:bold;
                          display:inline-block;
                          min-width:150px">Trạng thái
                    </span><b style="color:green;
                              font-weight:normal;
                              margin:0">Hoàn thành</b></p>
            <p style="font-size:14px;margin:0 0 6px 0;">
                    <span style="font-weight:bold;
                          display:inline-block;
                          min-width:146px">Mã hoá đơn</span>{{id}}</p>
            <p style="font-size:14px;margin:0 0 0 0;">
                    <span style="font-weight:bold;
                                 display:inline-block;
                                 min-width:146px">Tổng tiền</span>{{total}}₫</p>
        </td>
    </tr>
    <tr>
        <td style="height:35px;"></td>
    </tr>
    <tr>
        <td style="width:50%;
                       padding:20px;
                       vertical-align:top">
            <p style="margin:0 0 10px 0;
                          padding:0;
                          font-size:14px;">
                    <span style="display:block;
                                 font-weight:bold;
                                 font-size:13px;">Email</span>{{email}}</p>
            <p style="margin:0 0 10px 0;
                          padding:0;font-size:14px;">
                    <span style="display:block;
                                 font-weight:bold;
                                 font-size:13px;">Phương thức thanh toán</span>{{payment_method}}
            </p>
        </td>
        <td style="width:50%;
                       padding:20px;
                       vertical-align:top">
            <p style="margin:0 0 10px 0;
                          padding:0;font-size:14px;">
                    <span style="display:block;
                                 font-weight:bold;
                                 font-size:13px;">Địa chỉ</span>Thủ Đức, TP.HCM</p>
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"
            style="font-size:14px;
                           padding:50px 15px 0 15px;">
            <strong style="display:block;
                            margin:0 0 10px 0;">Trân trọng</strong> Hutech Coffee<br>
            Xa lộ Hà Nội, TP.Thủ Đức, TP.Hồ Chí Minh<br><br>
            <b>Số điện thoại:</b> 028 5445 7777<br>
            <b>Email:</b> nguyenxuannhan.dev@gmail.com
        </td>
    </tr>
    </tfoot>
</table>
</body
</html>