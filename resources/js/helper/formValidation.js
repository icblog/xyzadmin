export function validateEmail(inputValue) {
    let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputValue.match(mailformat)) {

        return true;
    } else {
        return false;
    }
}