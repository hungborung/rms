
function getWallets() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "http://127.0.0.1:8000/wallets",
        success: function (res, status, xhr) {
            if (res != null) {
                $("#wallets_table").empty();
                $.each(res, function (i, e) {
                    $("#wallets_table").append("<tr id='wall-" + e.id + "'><td>" + e.id + "</td><td>" + e.name + "</td><td>" + e.hash_key + "</td></tr>");
                });
            }
        },
        error: function(xhr, error){
            alert(xhr.status);
        }
    });
}

$(document).ready(function () {
    $("#createWallet").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "http://127.0.0.1:8000/wallets",
            data: JSON.stringify({
                name: $("#name").val(),
                hash_key: $("#hash_key").val()
            }),
            success: function (res, status, xhr) {
                alert(xhr.status);
                location.reload();
            },
            error: function(xhr, error){
                alert(xhr.status);
            }
        });
    });

    $("#DeleteWallet").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'DELETE',
            dataType: "json",
            url: 'http://127.0.0.1:8000/wallets',
            data: JSON.stringify({
                name: $("#nameDelete").val(),
                hash_key: $("#keyDelete").val()
            }),
            success: function (res, status, xhr) {
                alert(xhr.status);
                location.reload();                
            },
            error: function(xhr, error){
                alert(xhr.status);
            }
        });
    });
})
