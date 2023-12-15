var formatter = new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',

    // These options are needed to round to whole numbers if that's what you want.
    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
});


function convertStringToEnglish(dataString) {
    var aVN = ["á", "à", "ả", "ã", "ạ", "ắ", "ằ", "ẳ", "ẵ", "ặ", "ă", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ"];
    var dVN = ["đ"];
    var eVN = ["é", "è", "ẻ", "ẽ", "ẹ", "ê", "ế", "ề", "ể", "ễ", "ệ"];
    var iVN = ["í", "ì", "ỉ", "ĩ", "ị"];
    var oVN = ["ó", "ò", "ỏ", "õ", "ọ", "ô", "ố", "ồ", "ổ", "ỗ", "ộ", "ơ", "ớ", "ờ", "ở", "ỡ", "ợ"];
    var uVN = ["ú", "ù", "ủ", "ũ", "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự"];
    var yVN = ["ý", "ỳ", "ỷ", "ỹ", "ỵ"];

    dataString = dataString.toLowerCase();
    for (var i = 0; i < dataString.length; i++) {
        for (var j = 0; j < aVN.length; j++) {
            if (dataString[i] == aVN[j]) {
                dataString = dataString.replaceAt(i, "a");
            }
        }
        for (var j = 0; j < dVN.length; j++) {
            if (dataString[i] == dVN[j]) {
                dataString = dataString.replaceAt(i, "d");
            }
        }
        for (var j = 0; j < eVN.length; j++) {
            if (dataString[i] == eVN[j]) {
                dataString = dataString.replaceAt(i, "e");
            }
        }
        for (var j = 0; j < iVN.length; j++) {
            if (dataString[i] == iVN[j]) {
                dataString = dataString.replaceAt(i, "i");
            }
        }
        for (var j = 0; j < oVN.length; j++) {
            if (dataString[i] == oVN[j]) {
                dataString = dataString.replaceAt(i, "o");
            }
        }
        for (var j = 0; j < uVN.length; j++) {
            if (dataString[i] == uVN[j]) {
                dataString = dataString.replaceAt(i, "u");
            }
        }
        for (var j = 0; j < yVN.length; j++) {
            if (dataString[i] == yVN[j]) {
                dataString = dataString.replaceAt(i, "y");
            }
        }
    }
    return dataString.replace(/\s/g, '');
}




String.prototype.replaceAt = function(index, replacement) {
    return this.substr(0, index) + replacement + this.substr(index + replacement.length);
}


function getImageNameFromSrc(url) {
    $index = url.length - 1;
    while ($index > 0 && url[$index] != '/' && url[$index] != '\\') {
        $index--;
    }
    return url.substring($index + 1);
}

function checkPhoneNumber($phone) {
    if ($phone.length < 10 || $phone.length > 11) {
        return false;
    }
    if ($phone[0] != '0') {
        return false;
    }
    if (isNaN($phone)) {
        return false;
    }
    return true;
}

function isInt(value) {
    return !isNaN(value) &&
        parseInt(Number(value)) == value &&
        !isNaN(parseInt(value, 10));
}

//yyy-mm-dd => dd-mm-yyy
function formatDateToddmmyyyy(date) {
    var input = date;
    $day = input.substring(8);
    $month = input.substring(5, 7);
    $year = input.substring(0, 4);
    return $day + '-' + $month + '-' + $year;
}

function printToImage($id) {
    html2canvas(document.querySelector($id)).then(canvas => {
        canvas.toBlob(function(blob) {
            saveAs(blob, "Bill_Receipt_TimeLine.png");
        });
    });
}