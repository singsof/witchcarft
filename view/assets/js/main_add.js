const queryString = window.location.search;
const search_name = (object) => {
    let search = $("#" + object).val();

    // alert(search)

    if (queryString.includes("?")) {
        location.assign(window.location.href + "&search=" + search);
    } else {
        location.assign(window.location.href + "?search=" + search);
    }
};

function newPage(object) {
    if (queryString.includes("?")) {
        location.assign(window.location.href + "&page=" + object);
        // alert(object);
    } else {
        location.assign(window.location.href + "?page=" + object);
    }
    // alert(object);
}

function sortBy(object) {
    if (queryString.includes("?")) {
        location.assign(window.location.href + object.value);
    } else {
        location.assign(window.location.href + "?" + object.value);
    }
}

const successSwal = (msg_text, path = true) => {
    Swal.fire({
        position: "center",
        icon: "success",
        title: msg_text,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        if (path === true) location.reload();
        else if (path == false) null;
        else location.assign(path);
    });
};

const errorSwal = (msg_text, reload = true) => {
    Swal.fire({
        position: "center",
        icon: "error",
        title: msg_text,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        if (reload === true) location.reload();
    });
};
const warningSwal = (msg_text, reload = true) => {
    Swal.fire({
        position: "center",
        icon: "warning",
        title: msg_text,
        showConfirmButton: false,
        timer: 1000,
    }).then(() => {
        if (reload === true) location.reload();
    });
};



// exports.editProduct = editProduct;
