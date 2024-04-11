everyThing();
function everyThing() {
    function d(element) {
        return document.querySelectorAll(element);
    }

    handling_plus_and_minus_buttons();
    handling_remove_buttons();

    //=========================================

    //TODO handling_plus_and_minus_buttons
    function handling_plus_and_minus_buttons() {
        d('.btn-plus').forEach((item, i) => {
            totalPriceControlForEachCartItem(item, i);
        });
        d('.btn-minus').forEach((item, i) => {
            totalPriceControlForEachCartItem(item, i);
        });

        function totalPriceControlForEachCartItem(item, i) {
            item.onclick = () => {
                d('.total_forEach_cart_item')[i].innerHTML =
                    `${Number(d('.span_price')[i].innerHTML) * Number(d('.input_qty')[i].value)} `;

                calculating_total_price_of_all_cart_items();
            }
        }
    }
    //============================================end function


    //TODO handling remove buttons
    function handling_remove_buttons() {
        d('.btn_remove_from_cart').forEach((item, i) => {
            item.onclick = () => {
                d('.btn-plus')[i].remove();
                d('.btn-minus')[i].remove();
                d('.cart_row')[i].remove();
                everyThing();
                calculating_total_price_of_all_cart_items();
            }
        });
    }
    //-----------------------------------------end function



    //TODO calculating_total_price_of_all_cart_items
    function calculating_total_price_of_all_cart_items() {
        let total = 0;
        d('.total_forEach_cart_item').forEach((item, i) => {
            total += Number(item.innerHTML);

        });
        d('#subTotal')[0].innerHTML = `${total} Kyats`;
        d('#finalTotal')[0].innerHTML = `${total === 0 ? 0 : total + 3000} Kyats`;
    }
}
