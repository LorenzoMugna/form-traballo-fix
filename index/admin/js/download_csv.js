function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}

// Start file download.
document.getElementById("download-button").addEventListener("click", function(){
    // Generate download of hello.txt file with some content
    let filename = "applications.csv";
    let text  = "ID,Name,Email,Phone,Address,Status,Date\n"; //Possibly add file name? Or download link?
    let table = document.getElementById("applications-table");
    for (let i = 1; i < table.rows.length; i++) {
        let row = table.rows[i];
        text += row.cells[0].innerText + "," + row.cells[1].innerText + "," + row.cells[2].innerText + "," + row.cells[3].innerText + "," + row.cells[4].innerText + "," + row.cells[5].innerText + "," + row.cells[6].innerText + "\n";
    }
    
    download(filename, text);
}, false);