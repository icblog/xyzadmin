export const isObject = (obj) => {
  return Object.prototype.toString.call(obj) === "[object Object]";
};

export const isArray = (what) => {
  return Object.prototype.toString.call(what) === "[object Array]";
};



export const returnSystemErrorMsg = () => {
  return "Sorry system error, your request can not be processed please try again later thank you";
};

export const replaceChar = (str, whatTosearch, replaceWith) => {
  return str.replace(whatTosearch, replaceWith);
};

export function limitString(limitBy, str) {
  if (str.length > limitBy) {
    return str.slice(0, limitBy) + "...";
  } else {
    return str;
  }
}

export function scrollToElement(elementRef) {
  elementRef.current.scrollIntoView();
}

export function scrollToTopOfPage() {
  window.scrollTo({ top: 0, left: 0, behavior: "smooth" });
}

export function removeItemFromArrayByIndex(itemIndex, itemArray) {
  if (itemIndex >= 0) {
    itemArray.splice(itemIndex, 1);

    return itemArray;
  }
}

export function checkIfAvalueIncludesInArrOrObj(
  itemValue,
  arrOrObj,
  itemValueKeyName = "",
  isArrOrObj = "obj"
) {
  let outCome = false;
  if (isArrOrObj == "arr") {
    if (arrOrObj.some((e) => e === itemValue)) {
      outCome = true;
    }
  } else {
    if (arrOrObj.some((e) => e[itemValueKeyName] === itemValue)) {
      outCome = true;
    }
  }

  return outCome;
}

export function removeItemFromArrOrObjByValue(
  itemValue,
  arrOrObj,
  itemValueKeyName = "",
  isArrOrObj = "obj"
) {
  let filteredArray = [];
  if (isArrOrObj == "arr") {
    filteredArray = arrOrObj.filter(function (e) {
      return e !== itemValue;
    });
  } else {
    filteredArray = arrOrObj.filter(function (e) {
      return e[itemValueKeyName] !== itemValue;
    });
  }
  return filteredArray;
}

export function removeItemFromArrayByValue(itemValue, itemArray) {
  let filteredArray = itemArray.filter(function (e) {
    return e !== itemValue;
  });
  return filteredArray;
}

export function returnFormattedDate(dateParam) {
  return new Date(dateParam).toLocaleDateString();
}
export function toSqlDatetime(inputDate) {
  const date = new Date(inputDate);
  const dateWithOffest = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
  return dateWithOffest.toISOString().slice(0, 19).replace("T", " ");
}

export function focusOnFirstInput(firstInput) {
  firstInput.value.focus();
}

export function generateRandom() {
  return Math.random().toString().replace("0.", "");
}

export function returnResumeLink() {
  return appDataObj.resumeLink;
}

export function returnFilteredText(text, listObj, filterBy) {
  if (!text.length) return listObj;
  return listObj.filter((list) =>
    list[filterBy].toLowerCase().includes(text.toLowerCase())
  );
}


