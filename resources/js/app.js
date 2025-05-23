import "./bootstrap";
import "bootstrap";
import $ from "jquery";

$(function () {
    $("#city").on("input", function () {
        let query = $(this).val().toLowerCase();
        query = removeDiacratics(query);

        if (query.length >= 1) {
            $.ajax({
                url: "/search",
                method: "GET",
                data: { query },
                success: function (data) {
                    let suggestions = $("#suggestions");
                    suggestions.empty();

                    if (data.length === 0) {
                        suggestions.append(
                            '<li class="list-group-item">Žiadne výsledky</li>',
                        );
                    } else {
                        data.forEach((city) => {
                            $("#suggestions").append(
                                `<li class="list-group-item" data-id="${city.id}">${city.name}</li>`,
                            );
                        });

                        $(".list-group-item").on("click", function () {
                            const cityId = $(this).data("id");
                            window.location.href = `/city/${cityId}`;

                            $("#city").val("");
                            $("#suggestions").empty();
                        });
                    }
                },
            });
        } else {
            $("#suggestions").empty();
        }
    });
});

function removeDiacratics(str) {
    const accents = "àáâãäåòóôõöøèéêëðčďìíîïůúüñňšÿýžľĺŕřť";
    const accentsOut = "aaaaaaooooooeeeeecdiiiiuuunnsyyzllrrt";

    return str
        .split("")
        .map((char) => {
            const index = accents.indexOf(char);
            return index !== -1 ? accentsOut[index] : char;
        })
        .join("");
}
