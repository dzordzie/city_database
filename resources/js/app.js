import "./bootstrap";
import "bootstrap";
import $ from "jquery";

$(function () {
    $('#city').on('input', function () {
        let query = $(this).val().toLowerCase();
        query = removeDiacratics(query);

        if (query.length >= 2) {
            $.ajax({
                url: "/search",
                method: "GET",
                data: { query },
                success: function (data) {
                    let suggestions = $('#suggestions');
                    suggestions.empty();

                    if (data.length === 0) {
                        suggestions.append('<li class="list-item">Žiadne výsledky</li>')
                    } else {
                        data.forEach((city) => {
                            $("#suggestions").append(`<li class="list-item">${city.name}</li>`);
                        });
                    }
                },
            });
        } else {
            $("#suggestions").empty();
        }
    });


    $('#suggestions').on('click', '.list-item', function () {
        const id = $(this).data('id');
        window.location.href = `/city/${id}`;
    });
});

function removeDiacratics (str) {
    const accents = 'àáâãäåòóôõöøèéêëðčďìíîïůúüñňšÿýžľĺŕřť';
    const accentsOut = "aaaaaaooooooeeeeecdiiiiuuunnsyyzllrrt";

    return str.split('').map(char => {
        const index = accents.indexOf(char);
        return index !== -1 ? accentsOut[index] : char;
    }).join('');
}