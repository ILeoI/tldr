var focus = 0;

const autoFillInputs = document.getElementsByClassName("autofill");

for (let i = 0; i < autoFillInputs.length; i++) {
    let a = document.createElement("div");
    a.setAttribute("id", "autofill-div-" + i);
    a.setAttribute("class", "autocomplete-item-div hidden");
    let b = document.createElement("ul");
    b.setAttribute("id", "autofill-l-" + i);
    b.setAttribute("class", "autofill-l")
    b.addEventListener('click', selectItem);
    a.appendChild(b);
    autoFillInputs[i].parentElement.appendChild(a);
    autoFillInputs[i].addEventListener('input', changeAutoComplete);
    autoFillInputs[i].setAttribute("id", "autofill-input-" + i);

    autoFillInputs[i].addEventListener('focus', function (event) {
        let ulField = document.getElementById("autofill-div-" + focus);
        ulField.classList.add("hidden"); 
        focus = event.target.getAttribute("id").replace("autofill-input-", "");
        ulField = document.getElementById("autofill-div-" + focus);
        ulField.classList.remove("hidden");
    });
}

// Determines which searching function to use
function changeAutoComplete({ target }) {
    let data = target.value;
    const ulField = document.getElementById("autofill-l-" + focus);
    ulField.innerHTML = ``;
    if (!isNaN(data) && data.length > 1) {
        let autoCompleteValues = autoCompletePostCode(target);
        autoCompleteValues.forEach(value => { addItem(value); });
    } else if (data.length > 1) {
        let autoCompleteValues = autoComplete(target);
        autoCompleteValues.forEach(value => { addItem(value); });
    }
}

// Checks the last 4 characters of everyline to see if they match the inputted
function autoCompletePostCode(target) {
    let postcode = target.value;
    return suburbs.filter(
        (value) => value.toLowerCase().substring(value.length - 4, value.length).startsWith(postcode.toLowerCase())
    );
}

// Checks the list of suburbs beginning with the first letter
// e.g. Aberfoyle would check the list a
function autoComplete(target) {
    let suburbName = target.value;
    let result = suburbsOpti[suburbName.substring(0, 1).toLowerCase()];
    return result.filter(
        (value) => {
            value = value.toString();
            return value.toLowerCase().startsWith(suburbName.toLowerCase());
        }
    );
}

// Adds the new element to the ul
function addItem(value) {
    const ulField = document.getElementById("autofill-l-" + focus);
    ulField.innerHTML += `<li>${value}</li>`;
}

// Handles the click fill
function selectItem({ target }) {
    if (target.tagName === 'LI') {
        const input = document.getElementById("autofill-input-" + focus);
        input.value = target.textContent.substring(0, target.textContent.length - 5);
        const ulField = document.getElementById("autofill-l-" + focus);
        ulField.innerHTML = '';
        const divField = document.getElementById("autofill-div-" + focus);
        divField.classList.add("hidden");
    }
}
