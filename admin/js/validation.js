/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

String.prototype.splice = function(idx, rem, s) {
  return (this.slice(0, idx) + s + this.slice(idx + Math.abs(rem)));
};

function isStringEmpty(str) {
  str = $.trim(str);
  return ((str.length == 0) ? true : false);
}

function isSelected(str) {
  return ((str) ? true : false);
}

function SelectedIndexValue(ddl) {
  return ddl.prop("selectedIndex");
}

function countDigits(str) {
  return str.replace(/[^0-9]/g, "").length;
}

function isNumber(str) {
  str = str.replace(/-/g, "");
  return /^\d+$/.test(str);
}

function removeChar(object, char) {
  var str = object.value;

  // * MEANS REMOVE ALL CHARACTER EXCEPT NUMBER
  if (char == "*")
    str = str.replace(/[^\d]/g, "");

  return str;
}

function setPhoneNumberFormat(str, pos) {
  if (!isStringEmpty(str)) {
    if (str.indexOf("-") == -1)
      str = str.splice(pos, 0, "-");
  }
  return str;
}

function validateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test(email);
}  