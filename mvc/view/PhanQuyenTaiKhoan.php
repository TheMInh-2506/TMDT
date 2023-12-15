<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Phân Quyền Tài Khoản</title>
    <link rel="stylesheet" href="./bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <style>
        .ctrBtn {
            width: 10rem;
            margin-right: 1rem;
            border-radius: 1rem;
        }

        .account-authorization__content .product,
        .account-authorization__content .bill {
            border: 1px solid rgba(1, 1, 15, 0.5);
            position: relative;
            z-index: 1;
        }

        .account-authorization__content .product h3,
        .account-authorization__content .bill h3 {
            position: absolute;
            z-index: 2;
            top: -20px;
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="container p-5">
        <div class="account-authorization">
            <div class="account-authorization__title text-center mb-5">
                <h1>Phân quyền Tài khoản</h1>
                <hr>
                <h3 style="text-align: left;" >Phân quyền cho tài khoản: <?php echo $data['MANV'].' - '.$data['TENNV'];?></h3>
            </div>

            <div class="btn-group mb-5">
                <label class="btn btn-primary ctrBtn" onclick="adminSelect();">Admin</label>
                <label class="btn btn-secondary ctrBtn" onclick="saleSelect();">Bán Hàng</label>
                <label class="btn btn-success ctrBtn" onclick="warehouseSelect();">Kiểm Kho</label>
                <label class="btn btn-dark ctrBtn" onclick="unCheckAll();">Bỏ chọn tất cả</label>
            </div>

            <div class="account-authorization__content mb-5">
                <div class="row" id="controlForm">
                </div>
            </div>

            <div class="account-authorization__end d-flex flex-row-reverse">
                <div class="row">
                    <div class="col">
                        <a href="/CuaHangNoiThat/Admin/NhanVien"><button type="button" class="btn btn-primary">Trở về</button></a>

                        <button type="button" class="btn btn-success" onclick="getAllSelectedCheckBox();">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var listRightStaff = '<?php echo $data['QUYEN'] ?>';
     
        
        var control = [{
            'key': 'Thống Kê',
            'id': 'statistic',
            'color': '#787FF6',
            'value': [{
                'name': "Thống Kê Doanh Thu",
                'cmd': 'sta_profic'
            }, {
                'name': "Thống kê Hóa Đơn",
                'cmd': 'sta_bill'
            }, {
                'name': "Thống kê Kho",
                'cmd': 'sta_receipt'
            }]
        }, {
            'key': 'Sản Phẩm',
            'id': 'product',
            'color': '#F66F8D',
            'value': [{
                'name': "Sửa sản phẩm",
                'cmd': 'e_product'
            }, {
                'name': "Xóa sản phẩm",
                'cmd': 'd_product'
            }, {
                'name': "Tìm kiếm Sản Phẩm",
                'cmd': 's_product'
            }, {
                'name': "Xem danh sách Sản Phẩm",
                'cmd': 'v_product'
            }, {
                'name': "Xem danh sách Sản Phẩm cần nhập",
                'cmd': 've_product'
            }, {
                'name': "Xuất Excel Sản Phẩm",
                'cmd': 'ex_product'
            } , {
                'name': "Yêu cầu nhập hàng",
                'cmd': 'request_add_product'
            }
        ]
        }, {
            'key': 'Hóa Đơn',
            'id': 'bill',
            'color': '#1CA7EC',
            'value': [{
                'name': "Lập Hóa Đơn",
                'cmd': 'a_bill'
            }, {
                'name': "Xác nhận/từ chối hóa đơn",
                'cmd': 'c_bill'
            }, {
                'name': "Xem chi tiết hóa đơn",
                'cmd': 'v_bill'
            }, {
                'name': "In Hóa Đơn",
                'cmd': 'p_bill'
            }, {
                'name': "Tìm kiếm Hóa Đơn",
                'cmd': 's_bill'
            }, {
                'name': "Xuất Excel Hóa Đơn",
                'cmd': 'ex_bill'
            }, {
                'name': "Xem danh sách Hóa Đơn",
                'cmd': 'v_bill'
            }]
        }, {
            'key': 'Phiếu Nhập',
            'id': 'receipt',
            'color': '#000000',
            'value': [{
                'name': "Lập Phiếu Nhập",
                'cmd': 'a_receipt'
            }, {
                'name': "Xem chi tiết Phiếu Nhập",
                'cmd': 'v_receipt'
            }, {
                'name': "In Phiếu Nhập",
                'cmd': 'p_receipt'
            }, {
                'name': "Tìm kiếm Phiếu Nhập",
                'cmd': 's_receipt'
            }, {
                'name': "Xuất Excel Phiếu Nhập",
                'cmd': 'ex_receipt'
            }, {
                'name': "Xem danh sách Phiếu Nhập",
                'cmd': 'v_receipt'
            }]
        }, {
            'key': 'Nhân Viên',
            'id': 'staff',
            'color': '#FF9190',
            'value': [{
                'name': "Thêm Nhân Viên",
                'cmd': 'a_staff'
            }, {
                'name': "Sửa Nhân Viên",
                'cmd': 'e_staff'
            }, {
                'name': "Xóa Nhân Viên",
                'cmd': 'd_staff'
            }, {
                'name': "Tìm kiếm Nhân Viên",
                'cmd': 's_staff'
            }, {
                'name': "Phân quyền Nhân Viên",
                'cmd': 'r_staff'
            }, {
                'name': "Xuất Excel Nhân Viên",
                'cmd': 'ex_staff'
            }, {
                'name': "Xem danh sách Nhân Viên",
                'cmd': 'v_staff'
            }]
        }, {
            'key': 'Khách Hàng',
            'id': 'customer',
            'color': '#56C596',
            'value': [{
                'name': "Khóa /Mở khóa Khách Hàng",
                'cmd': 'd_customer'
            }, {
                'name': "Tìm kiếm Khách Hàng",
                'cmd': 's_customer'
            }, {
                'name': "Xuất Excel Khách Hàng",
                'cmd': 'ex_customer'
            }, {
                'name': "Xem danh sách Khách Hàng",
                'cmd': 'v_customer'
            }]
        }, {
            'key': 'Khuyến Mãi',
            'id': 'sale',
            'color': '#FE7A15',
            'value': [{
                'name': "Thêm Khuyến Mãi",
                'cmd': 'a_sale'
            }, {
                'name': "Sửa Khuyến Mãi",
                'cmd': 'e_sale'
            }, {
                'name': "Xóa Khuyến Mãi",
                'cmd': 'd_sale'
            }, {
                'name': "Tìm kiếm Khuyến Mãi",
                'cmd': 's_sale'
            }, {
                'name': "Xem danh sách Khuyến Mãi",
                'cmd': 'v_sale'
            }]
        }, {
            'key': 'Nhà Cung Cấp',
            'id': 'supplier',
            'color': '#384E78',
            'value': [{
                'name': "Thêm Nhà Cung Cấp",
                'cmd': 'a_supplier'
            }, {
                'name': "Sửa Nhà Cung Cấp",
                'cmd': 'e_supplier'
            }, {
                'name': "Khóa/Mở khóa Nhà Cung Cấp",
                'cmd': 'd_supplier'
            }, {
                'name': "Tìm kiếm Nhà Cung Cấp",
                'cmd': 's_supplier'
            }, {
                'name': "Xem danh sách Nhà Cung Cấp",
                'cmd': 'v_supplier'
            }]
        }];

        var saler = ['v_product', 's_product', 'a_bill', 'c_bill', 'v_bill', 'p_bill', 's_bill', 'ex_bill', 'v_bill', 's_customer', 'v_customer', 's_sale', 'v_product','request_add_product','sta_bill'];

        var warehouseManager = ['s_product', 'v_product', 'a_receipt', 'v_receipt', 'p_receipt', 's_receipt', 'ex_receipt', 'v_receipt', 's_supplier', 'v_supplier','request_add_product','sta_receipt'];

        var listClassId = ['statistic', 'product', 'bill', 'receipt', 'staff', 'customer', 'sale', 'supplier'];


        var xhtml = '';
        for (var i = 0; i < control.length; i++) {
            var item = control[i];
            xhtml += '<div class="col-md-3" id="' + item.id + '">' +
                '<div class="product mb-5" style = "background-color:' + item.color + ';color:white;border-radius:1rem;">' +
                '<form action="#" method="#" class="p-3">' +
                '<h3 style="color:' + item.color + '">' + item.key + '</h3>';
            var subItem = item.value;
            for (var j = 0; j < subItem.length; j++) {
                var subItemValue = subItem[j];
                /*console.log(listRightStaff)
                console.log(subItemValue)
                console.log(isExistRightInList(listRightStaff,subItemValue.cmd))
                console.log("=======================")*/
                xhtml += '<input type="checkbox" id="' + subItemValue.cmd + '" ' + (isExistRightInList(listRightStaff,subItemValue.cmd) ? "checked" : "") + '/>' + subItemValue.name + '<br/>';
            }
            xhtml += '</form></div></div>';

        }

        document.getElementById("controlForm").innerHTML = xhtml;


        function isExistRightInList(list,right){
            var arr = list.split(" ");
            for(var item of arr){
                if(item.localeCompare(right) == 0){
                    return true;
                }
            }
            return false;
        }


        function adminSelect() {
            listClassId.forEach(function(item) {
                var listCheckBox = document.getElementById(item).querySelectorAll("input");

                listCheckBox.forEach(function(subitem) {
                    if (!subitem.checked) {
                        subitem.checked = true;
                    }
                })
            })
        }

        function unCheckAll() {
            listClassId.forEach(function(item) {
                var listCheckBox = document.getElementById(item).querySelectorAll("input");

                listCheckBox.forEach(function(subitem) {
                    if (subitem.checked) {
                        subitem.checked = false;
                    }
                })
            })
        }

        function saleSelect() {
            unCheckAll();
            listClassId.forEach(function(item) {
                var listCheckBox = document.getElementById(item).querySelectorAll("input");

                listCheckBox.forEach(function(subitem) {
                    if (!subitem.checked && isExistValueInList(saler, subitem.id)) {
                        subitem.checked = true;
                    }
                })
            })
        }

        function warehouseSelect() {
            unCheckAll();
            listClassId.forEach(function(item) {
                var listCheckBox = document.getElementById(item).querySelectorAll("input");

                listCheckBox.forEach(function(subitem) {
                    if (!subitem.checked && isExistValueInList(warehouseManager, subitem.id)) {
                        subitem.checked = true;
                    }
                })
            })
        }

        function isExistValueInList(list, value) {
            var result = false;
            list.forEach(function(item) {
                if (item.localeCompare(value) == 0) {
                    result = true;
                }
            })
            return result;
        }

        function getAllSelectedCheckBox() {
            var list = [];
            listClassId.forEach(function(item) {
                var listCheckBox = document.getElementById(item).querySelectorAll("input");


                listCheckBox.forEach(function(subitem) {

                    if (subitem.checked) {
                        list.push(subitem.id)
                    }
                })
            })
            if (list.length == 0) {
                alert("Nhân Viên phải có ít nhất 1 quyền trong hệ thống !!!!!")
                return;
            }

            var strList = '';
            list.forEach(function (item){
                strList += item + ' ';
            })


            var idEditStaff = '<?php echo $data['MANV']?>';

            
            $.ajax({
                url: '/CuaHangNoiThat/Admin/updateRightOfStaff',
                data: {
                    id:idEditStaff,
                    right:strList
                },
                method: 'post',
                success: function(data) {
                    if(data == 0){
                        window.location.href = '/CuaHangNoiThat/Admin/NhanVien';
                    }
                    else{

                    }

                    
                }
            });
        }
    </script>
</body>

</html>