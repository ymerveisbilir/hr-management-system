function create_mask() {
    $('input[money]').inputmask({ "alias": 'numeric', 'groupSeparator': '.', 'digits': 2, 'digitsOptional': false, 'placeholder': '0.00', rightAlign: false });
    $('input[type="tel"]').inputmask({ "mask": "9 (999) 999 99 99" });
    $('input[yuzde]').inputmask({ "mask": "%999", 'placeholder': '' });

    $('input[type="tel"]').bind("change keyup", function() {
        var val = $(this).inputmask('unmaskedvalue');
        if (!val.startsWith("0") && val.length != 0) val = 0 + val;
        $(this).val(val);
    });

}

$(function() {
    create_mask();
})