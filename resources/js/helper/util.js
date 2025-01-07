export const isObject = (obj) => {
  return Object.prototype.toString.call(obj) === "[object Object]";
};

export const isArray = (what) => {
  return Object.prototype.toString.call(what) === "[object Array]";
};

export const returnSystemErrorMsg = () => {
  return "Sorry system error, your request can not be processed please see a member of the security team thank you!";
};

export const replaceChar = (str, what_to_search, replace_with) => {
  return str.replace(what_to_search, replace_with);
};

export function limitString(limit_by, str, add_dot = false) {
  if (str.length > limit_by) {
    if (add_dot) {
      return str.slice(0, limit_by) + "...";
    } else {
      return str.slice(0, limit_by);
    }
  } else {
    return str;
  }
}

export function generateRandom(ran_len = 6) {
  let rand = Math.random().toString().replace("0.", "");
  if (rand.length > ran_len) {
    return rand.slice(0, ran_len);
  } else {
    return rand;
  }
}

export function returnRefNumber(fName, lName) {
  let refNumber = "",
    fLetterOffName = limitString(1, fName),
    fLetterOfLName = limitString(1, lName);

  refNumber = fLetterOffName + fLetterOfLName + "-" + generateRandom(3);
  return refNumber;
}

export function scrollToElement(elementRef) {
  elementRef.value.scrollIntoView({ behavior: "smooth" });
}

export function scrollToTopOrBottomOfPage(top_or_bottom = "top") {
  if (top_or_bottom == "top") {
    window.scrollTo({ top: 0, behavior: "smooth" });
  } else {
    window.scrollTo({ top: document.body.scrollHeight, left: 0, behavior: "smooth" });
  }
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

export function returnFormattedDate(date_param, date_with_time = false, time_only = false) {
  let return_date_or_time = new Date(date_param).toLocaleDateString();
  if (date_with_time) {
    return_date_or_time =
      return_date_or_time + " " + new Date(date_param).toLocaleTimeString("en-GB").slice(0, 5);
  }

  if (time_only) {
    return_date_or_time = date_param.substr(11, 5);
  }

  return return_date_or_time;
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

export function returnFilteredText(text, listObj, filterBy, arrType = "obj") {
  if (!text.length) return listObj;
  let tempArr = [];

  if (arrType == "obj") {

    listObj.forEach((element) => {
      if (isNaN(element[filterBy])) {
        if (element[filterBy].toLowerCase().indexOf(text.toLowerCase()) > -1) {
          tempArr.push(element);
        }
      } else {
        if (element[filterBy].toString().toLowerCase().indexOf(text.toLowerCase()) > -1) {
          tempArr.push(element);
        }
      }
    });
    // return listObj.filter((list) =>
    //   list[filterBy].toLowerCase().includes(text.toLowerCase())
    // );
  } else if (arrType == "arr") {
    listObj.forEach((element) => {
      if (isNaN(element)) {
        if (element.toLowerCase().indexOf(text.toLowerCase()) > -1) {
          tempArr.push(element);
        }
      } else {
        if (element.toString().toLowerCase().indexOf(text.toLowerCase()) > -1) {
          tempArr.push(element);
        }
      }
    });
  }

  return tempArr;
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

export function validateEmail(inputValue) {
  let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (inputValue.match(mailformat)) {
    return true;
  } else {
    return false;
  }
}

export function returnCoWorkerFullName(fname, lname) {
  let first_name = fname == null ? "Leaver" : fname,
    last_name = lname == null ? "" : lname;
  return first_name + " " + last_name;
}

export function returnCurrentDate(to_string = true) {
  const current_date = new Date();
  if (to_string) {
    return current_date.toDateString();
  } else {
    return current_date;
  }


}

export function returnCurrentTime() {
  const current_date = returnCurrentDate(false);
  return current_date.toLocaleTimeString("en-GB").slice(0, 5);
}

export function returnFirstPartOfStrAfterChar(str, char = " ", pos = 0) {
  return str.split(char)[pos];
}

export function returnAllStrAfterFirstChar(str, char = " ") {
  return str.slice(str.indexOf(char) + 1);
}



export function returnReturnMinDateAsToday() {
  let dtToday = returnCurrentDate(false), //find this function above.
    month = dtToday.getMonth() + 1,
    day = dtToday.getDate(),
    year = dtToday.getFullYear();
  if (month < 10) {
    month = "0" + month.toString();
  }
  if (day < 10) {
    day = "0" + day.toString();
  }
  return year + "-" + month + "-" + day;
}

export function generatePdf(
  jsPDF,
  autoTable,
  columnsArray,
  attrArray,
  dataObj,
  headerMsg = "Records",
  autoPrint = false,
  dateAttrArray = [],
) {
  // Create a new PDF document
  let doc = new jsPDF("l", "pt"),
    rows = [],
    currentDateTime = "Date: " + returnCurrentDate() + " Time: " + returnCurrentTime(),
    header = "  |  (" + dataObj.length + ") " + headerMsg;

  dataObj.forEach((visitor, i) => {
    let temParr = [];

    for (let i = 0; i < attrArray.length; i++) {

      if (dateAttrArray.length > 0) {
        //for date attr
        if (dateAttrArray.includes(attrArray[i]) && visitor[attrArray[i]] != null) {
          temParr.push(returnFormattedDate(visitor[attrArray[i]], true));
        } else {
          temParr.push(visitor[attrArray[i]]);
        }

      } else {
        temParr.push(visitor[attrArray[i]]);
      }//end if dateAttrArray.length > 0

    }//end foreach
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
}

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
  ];
}

export function checkDateDiff(inputDateTime, daysValue) {
  //Set 1 day in milliseconds
  let one_day = 1000 * 60 * 60 * 24,
    serverDateTime = new Date(inputDateTime),
    newDate = new Date();

  //Calculate difference btw the two dates, and convert to days
  let diff = Math.ceil((newDate.getTime() - serverDateTime.getTime()) / one_day);
  if (diff >= daysValue) {
    return true;
  } else {
    return false;
  }
}

