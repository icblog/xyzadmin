export const isObject = (obj) => {
  return Object.prototype.toString.call(obj) === "[object Object]";
};

export const isArray = (what) => {
  return Object.prototype.toString.call(what) === "[object Array]";
};

export const returnSystemErrorMsg = () => {
  return "Sorry system error, your request can not be processed please see a member of the security team thank you!";
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
  elementRef.value.scrollIntoView({ behavior: "smooth" });
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

export function returnFormattedDate(dateParam, dateWithTime = false) {
  let returnDate = new Date(dateParam).toLocaleDateString();
  if (dateWithTime) {
    returnDate = returnDate + " " + new Date(dateParam).toLocaleTimeString("en-GB").slice(0, 5);
  }
  return returnDate;
}
export function toSqlDatetime(inputDate) {
  // input looks like this { new Date()};
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

export function capitalizeFirstLetter(string) {
  return string[0].toUpperCase() + string.slice(1);
}

export function returnMatchedFromArrOrObjByValue(
  itemValue,
  arrOrObj,
  itemValueKeyName = "",
  isArrOrObj = "obj"
) {
  let filteredArray = [];
  if (isArrOrObj == "arr") {
    filteredArray = arrOrObj.filter(function (e) {
      return e == itemValue;
    });
  } else {
    filteredArray = arrOrObj.filter(function (e) {
      return e[itemValueKeyName] == itemValue;
    });
  }
  return filteredArray;
}

export function moveCursorToTextEnd(input, inputValue) {
  let textEnd = inputValue.length;
  setTimeout(() => input.setSelectionRange(textEnd, textEnd));
}

export function validMobileNumber(number) {
  let regex = /^(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}$/,
    result = regex.test(number);
  return result;
}

export function returnCoWorkerFullName(fname, lname) {
  return fname + " " + lname;
};

export function returnCurrentDate() {
  const current = new Date();
  return current.toDateString();
};

export function returnCurrentTime() {
  const current = new Date();
  return current.toLocaleTimeString("en-GB").slice(0, 5);
};

export function generatePdf(jsPDF, autoTable, columnsArray, attrArray, dataObj, headerMsg = "Records", autoPrint = false) {
  // Create a new PDF document
  let doc = new jsPDF("l", "pt"),
    rows = [],
    currentDateTime = "Date: " + returnCurrentDate() + " Time: " + returnCurrentTime(),
    header =
      "  |  (" +
      dataObj.length +
      ") " + headerMsg;

  dataObj.forEach((visitor, i) => {

    let temParr = [];

    for (let i = 0; i < attrArray.length; i++) {
      temParr.push(visitor[attrArray[i]]);
    }

    rows.push(temParr);

  });

  doc.autoTable({
    columns: columnsArray,
    body: rows,
    margin: { horizontal: 10 },
    styles: { overflow: "linebreak" },
    bodyStyles: { valign: "top" },
    columnStyles: { email: { cellWidth: "wrap" } },
    theme: "striped",
    showHead: "everyPage",
    didDrawPage: function (data) {
      // Header
      doc.setFontSize(14);
      doc.setTextColor(40);
      doc.text(currentDateTime + header, 10, 20, { baseline: "top" });

      // Footer
      var str =
        "Page " +
        doc.internal.getCurrentPageInfo().pageNumber +
        " of " +
        doc.internal.getNumberOfPages();

      doc.setFontSize(10);

      // jsPDF 1.4+ uses getWidth, <1.4 uses .width
      var pageSize = doc.internal.pageSize;
      var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
      doc.text(str, data.settings.margin.left, pageHeight - 10);
    },
  });
  // Print the PDF
  if (autoPrint) {
    doc.autoPrint();
  }
  doc.output("dataurlnewwindow");

};


export function returnSortOptionArray() {
  return [
    {
      name: "Latest",
    },
    {
      name: "A-Z",
    },

    {
      name: "Z-A",
    },

    {
      name: "Date ascending",
    },
    {
      name: "Date descending",
    },
    // {
    //   name: "Company",
    // },
    // {
    //   name: "Reason",
    // },
  ];
};
