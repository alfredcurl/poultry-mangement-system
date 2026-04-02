const quantityInput = document.getElementById("quantity");
const priceInput = document.getElementById("price");
const totalInput = document.getElementById("total_price");
const subTotalLabel = document.getElementById("sub-total");
const totalLabel = document.getElementById("total");
const shippingLabel = document.getElementById("shipping");
const couponLabel = document.getElementById("coupon");
const couponUsedInput = document.getElementById("coupon_used");
const couponUsedLabel = document.getElementById("couponUsedShow");

const baseCouponTotal =
    parseInt(
        (couponLabel?.dataset.valuecoupon ??
            couponLabel?.dataset.valuekupon ??
            "0"),
        10
    ) || 0;

let couponsApplied = 0;
let useCoupon = false;

window.addEventListener("load", () => {
    myCounter();
});

function changeStatesCoupon() {
    useCoupon = !useCoupon;
    myCounter();
}

function myCounter() {
    const quantity = parseInt(quantityInput?.value ?? "0", 10) || 0;
    const price =
        parseInt(priceInput?.getAttribute("data-truePrice") ?? "0", 10) || 0;
    const shipping = 0;

    if (useCoupon) {
        couponsApplied = Math.min(baseCouponTotal, quantity);
    } else {
        couponsApplied = 0;
    }

    const remainingCoupons = baseCouponTotal - couponsApplied;
    const effectiveQty = Math.max(quantity - couponsApplied, 0);
    const subTotal = effectiveQty * price;
    const total = subTotal + shipping;

    updateCouponSummary(remainingCoupons);
    refreshSummary({ subTotal, shipping, total });
}

function updateCouponSummary(remainingCoupons) {
    if (couponLabel) {
        couponLabel.innerHTML = `${remainingCoupons} coupon`;
    }
    if (couponUsedInput) {
        couponUsedInput.value = couponsApplied;
    }
    if (couponUsedLabel) {
        couponUsedLabel.innerHTML = `${couponsApplied} coupon`;
    }
}

function refreshSummary({ subTotal = 0, shipping = 0, total = 0 }) {
    if (totalInput) {
        totalInput.value = total;
    }
    if (totalLabel) {
        totalLabel.innerHTML = total;
    }
    if (subTotalLabel) {
        subTotalLabel.innerHTML = subTotal;
    }
    if (shippingLabel) {
        shippingLabel.setAttribute("data-shippingCost", shipping);
        shippingLabel.innerHTML = shipping;
    }
}

