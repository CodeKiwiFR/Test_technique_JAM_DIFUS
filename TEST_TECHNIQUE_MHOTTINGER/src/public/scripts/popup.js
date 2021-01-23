/*
    Popup management
    Two different popups: one for the delete confirmation and the other for the details.
    When a button is clicked, an async request is sent to the server.
    - delete -> we send a delete request to the server and this script updates the DOM
    - details -> the server deals with templating and we just output its answer onto the popup
*/

const container = document.querySelector(".container");
const backdrop = document.querySelector(".backdrop");
const deletePopup = document.querySelector(".popup-delete");
const detailsPopup = document.querySelector(".popup-details");
let id;
let mainTarget;

// Closing backdrop and popups function
const closePopup = () => {
    backdrop.style.display = "none";
    deletePopup.style.display = "none";
    detailsPopup.style.display = "none";
    detailsPopup.innerHTML = "Loading...";
};

// Managing the details popup
const detailsPopupManager = (id) => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", `/shop/details/${id}`, true);
    xhr.responseType = "json";
    xhr.send();
    xhr.onload = () => {
        let res = xhr.response[0];

        if (res.status !== "ok") {
            return;
        }
        detailsPopup.innerHTML = res.content;
    };
    detailsPopup.style.display = "flex";
};

// Adding delete/details buttons listeners
container.addEventListener("click", (event) => {
    event.preventDefault();
    mainTarget = event.target;

    if (mainTarget.nodeName !== "BUTTON") {
        return;
    }
    id = mainTarget.closest("form").querySelector("input").value;

    backdrop.style.display = "block";
    if (mainTarget.innerText === "DÉTAILS") {
        detailsPopupManager(id);
    } else if (mainTarget.innerText === "SUPPRIMER") {
        deletePopup.style.display = "flex";
    }
});

// Adding delete popup event listener
deletePopup.addEventListener("click", (event) => {
    const target = event.target;

    if (target.nodeName !== "BUTTON" || isNaN(id)) {
        return;
    } else if (target.innerText !== "OUI") {
        closePopup();
        return;
    }
    let xhr = new XMLHttpRequest();
    xhr.open("DELETE", `/shop/delete/${id}`, true);
    xhr.responseType = "json";
    xhr.send();
    xhr.onload = () => {
        let res = xhr.response[0];

        if (res.status !== "ok") {
            closePopup();
            return;
        }
        mainTarget.closest(".devThumb").remove();
        closePopup();
    };
});

// Closing backdrop and popups when clicking on backdrop
backdrop.addEventListener("click", closePopup);
