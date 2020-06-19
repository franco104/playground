function copyTextArea() {
    let textarea = document.getElementById("textToCopy");
    textarea.select();
    document.execCommand("copy");
}

function copyDivToClipboard() {
    var range = document.createRange();
    range.selectNode(document.getElementById("textToCopy"));
    window.getSelection().removeAllRanges(); // clear current selection
    window.getSelection().addRange(range); // to select text
    document.execCommand("copy");
    window.getSelection().removeAllRanges();// to deselect
}