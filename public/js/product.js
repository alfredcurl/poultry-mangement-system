import { previewImage } from "/js/image_preview.js";

const currencyFormatter = new Intl.NumberFormat("en-UG", {
    style: "currency",
    currency: "UGX",
    currencyDisplay: "symbol",
    minimumFractionDigits: 0,
});
const numberFormatter = new Intl.NumberFormat();

$("button.detail").click(function () {
    var id = $(this).attr("data-id");
    setVisible("#loading", true);

    $.ajax({
        url: "/product/data/" + id,
        method: "get",
        dataType: "json",
        success: function (res) {
            const modal = $("#ProductDetailModal");
            $("#modal-image").attr("src", "/storage/" + res["image"]);

            modal.find(".product-title").text(res["product_name"]);
            modal
                .find(".egg-size")
                .text(capitalize(res["egg_size"]) + " class");
            modal
                .find(".egg-pack")
                .text(numberFormatter.format(res["quantity_per_unit"]) + " eggs / unit");
            modal.find(".description").text(res["description"]);

            const discountedPrice =
                res["discount"] && Number(res["discount"]) > 0
                    ? (100 - Number(res["discount"])) / 100 * Number(res["price"])
                    : Number(res["price"]);

            if (Number(res["discount"]) > 0) {
                modal
                    .find(".price")
                    .html(
                        "<i class='fa-solid fa-tag me-2 text-success'></i>Price: <strong>" +
                            formatCurrency(discountedPrice) +
                            "</strong> <span class='strikethrough text-muted ms-2'>" +
                            formatCurrency(res["price"]) +
                            "</span>"
                    );
                modal
                    .find(".discount")
                    .html(
                        "<i class='fa-solid fa-percent me-2 text-danger'></i>Discount: <strong>" +
                            res["discount"] +
                            "%</strong>"
                    );
            } else {
                modal
                    .find(".price")
                    .html(
                        "<i class='fa-solid fa-tag me-2 text-success'></i>Price: <strong>" +
                            formatCurrency(discountedPrice) +
                            "</strong>"
                    );
                modal
                    .find(".discount")
                    .html(
                        "<i class='fa-solid fa-percent me-2 text-muted'></i>No discount currently"
                    );
            }

            modal
                .find(".stock")
                .html(
                    "<i class='fa-solid fa-warehouse me-2 text-secondary'></i>Available: <strong>" +
                        numberFormatter.format(res["stock"]) +
                        " units</strong> (~" +
                        numberFormatter.format(
                            res["stock"] * res["quantity_per_unit"]
                        ) +
                        " eggs)"
                );

            modal.modal("show");
            setVisible("#loading", false);
        },
    });
});

const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

$("#image").on("change", function () {
    previewImage({
        image: "image",
        image_preview: "image-preview",
        image_preview_alt: "Product Image",
    });
});

function formatCurrency(value) {
    const numericValue = Number(value) || 0;
    return currencyFormatter.format(numericValue);
}

function capitalize(value) {
    if (!value) return "";
    const normalized = value.replace(/_/g, " ");
    return normalized.charAt(0).toUpperCase() + normalized.slice(1);
}

// cancel order
$("#button_edit_product").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "after this process, product data will be changed",
        icon: "warning",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form_edit_product").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});
