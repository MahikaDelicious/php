var selectedRow = null;

function showAlert(message, className) {
    const div = document.createElement("div");
    div.className = `alert alert-${className}`;
    
    div.appendChild(document.createTextNode(message));
    const container = document.querySelector(".container");
    const main = document.querySelector(".main");
    container.insertBefore(div, main);

    setTimeout(() => document.querySelector(".alert").remove(), 3000);
}

function clearFields() {
    document.querySelector("#productCode").value = "";
    document.querySelector("#product").value = "";
    document.querySelector("#qty").value = "";
    document.querySelector("#perPrice").value = "";
}

document.querySelector("#store-form").addEventListener("submit", (e) => {
    e.preventDefault();

    const productCode = document.querySelector("#productCode").value;
    const product = document.querySelector("#product").value;
    const qty = document.querySelector("#qty").value;
    const perPrice = document.querySelector("#perPrice").value;

    if (productCode == "" || product == "" || qty == "" || perPrice == "") {
        showAlert("Please Fill in all fields", "danger");
    } else {
        if (selectedRow == null) {
            const list = document.querySelector("#store-list");
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${productCode}</td>
                <td>${product}</td>
                <td>${qty}</td>
                <td>${perPrice}</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm edit">EDIT</a>
                    <a href="#" class="btn btn-danger btn-sm delete">DELETE</a>
                </td>
            `;

            list.appendChild(row);
            selectedRow = null;
            showAlert("Order Added", "success");
        } else {
            selectedRow.children[0].textContent = productCode;
            selectedRow.children[1].textContent = product;
            selectedRow.children[2].textContent = qty;
            selectedRow.children[3].textContent = perPrice;
            selectedRow = null;
            showAlert("Order Update", "info");
        }

        clearFields();
    }
});


document.querySelector("#store-list").addEventListener("click", (e) => {
    const target = e.target;
    if (target.classList.contains("edit")) {
        selectedRow = target.parentElement.parentElement;
        document.querySelector("#productCode").value = selectedRow.children[0].textContent;
        document.querySelector("#product").value = selectedRow.children[1].textContent;
        document.querySelector("#qty").value = selectedRow.children[2].textContent;
        document.querySelector("#perPrice").value = selectedRow.children[3].textContent;
    }
});

document.querySelector("#store-list").addEventListener("click", (e) => {
    const target = e.target;
    if (target.classList.contains("delete")) {
        target.parentElement.parentElement.remove();
        showAlert("Data Deleted", "danger");
    }
});