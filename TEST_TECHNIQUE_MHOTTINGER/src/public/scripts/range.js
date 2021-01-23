/*
    Managing the price filter
    When price is updated an async request is sent to the server
    If the result is ok we output the data sent by the server
    NB: the server deals with templating
*/

const rangeInput = document.querySelector(".actions-range__input");
const rangePriceLabel = document.querySelector("#price");
if (!container) {
    const container = document.querySelector(".container");
}
let isChanging = false;

// Adding an event listener on the range input
rangeInput.addEventListener("change", (event) => {
    const price = rangeInput.value;

    rangePriceLabel.innerText = `${price}€`; // Displaying new price
    if (isNaN(price) || isChanging) {
        return;
    }
    isChanging = true;

    // Sending asynchronous request in order to get user according to price limit
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `/shop/price/${price}`, true);
    xhr.responseType = "json";
    xhr.send();
    xhr.onload = () => {
        let res = xhr.response[0];

        if (res.status !== "ok") {
            return;
        }
        container.innerHTML = res.content;
        isChanging = false;
    };
});
