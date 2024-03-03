function isEmptyOrSpaces(str) {
    return str == null || str == " " || str == "";
}

document.getElementById('formFile').addEventListener('change', function(event) {
    var abstract;
    var title;
    var arr = [];
    var firstPage = [];

    var file = event.target.files[0];

    let fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = () => {
        let res = fr.result;
        extractText(res);
        extractFirstpage(res);
    }

    async function extractFirstpage(url) {
        let pdf;
        let alltxt;

        pdf = await pdfjsLib.getDocument(url).promise;
        let pages = pdf.numPages;
        let page = await pdf.getPage(1);
        let txt = await page.getTextContent();
        let text = txt.items.map((s)=> {
            s.str;
            if (!isEmptyOrSpaces(s.str.trim())) {
                firstPage.push(s.str.trim());
            }
        }); 
    }

    async function extractText(url) {
        let pdf;
        let alltxt;

        pdf = await pdfjsLib.getDocument(url).promise;
        let pages = pdf.numPages;

        for (let i = 1; i <= pages; i++) {
            let page = await pdf.getPage(i);
            let txt = await page.getTextContent();
            let text = txt.items.map((s)=> {
                s.str;
                if (!isEmptyOrSpaces(s.str.trim())) {
                    arr.push(s.str.trim());
                }
            });       
        }
        
        // Clean the extracted text
        arr = cleanExtractedText(arr);
        // END

        // Extract Year
        alltxt = arr.join(' ');
        var year = extractYear(alltxt);
        // END

        // EXTRACT ABSTRACT
        abstract = arr.slice(arr.indexOf('ABSTRACT')+1, arr.indexOf('Keywords:'));
        let fabstract = abstract.join(' ');
        // END 

        // EXTRACT KEYWORDS
        const keywordsRegex = /Keywords\s*:/i;
        const tableOfContentsRegex = /\bTABLE\b/i; // ITO LANG BINAGO KO

        const keywordsIndex = arr.findIndex(line => keywordsRegex.test(line));
        const tableOfContentsIndex = arr.findIndex(line => tableOfContentsRegex.test(line));

        if (keywordsIndex !== -1 && tableOfContentsIndex !== -1) {
            keys = arr.slice(keywordsIndex + 1, tableOfContentsIndex - 1); // NILAGYAN KO LANG NG -1 PARA MATANGGAL YUNG PAGE
            let keywords = keys.join(' ');
            document.getElementById('keywords').value = keywords;
        } else {
            keys = [];
            let keywords = '';
            document.getElementById('keywords').value = keywords;
        }
        // END



        // EXTRACT FIRST PAGE
        title = firstPage.slice(0, firstPage.indexOf("A"));
        let ftitle = title.join(' ');
        // END
        
        document.getElementById('title').value = ftitle;
        document.getElementById('year').value = year;
        document.getElementById('abstract').value = fabstract;
        // document.getElementById('keywords').value = keywords;

        // Show the hidden section
        document.getElementById('parsedData').removeAttribute('hidden');
    }
});

function extractYear(text) {
    var yearRegex = /\b\d{4}\b/;
    var matches = text.match(yearRegex);
    if (matches) {
        var year = parseInt(matches[0]);
        if (year >= 1900 && year <= 2100) {
            return year.toString();
        }
    }
    return '';
}

document.querySelector('.submit').addEventListener('click', function() {
    document.getElementById('uploadForm').submit();
});

// Function to clean extracted text
function cleanExtractedText(textArray) {
    let cleanedText = [];
    let skip = false;
    
    for (let word of textArray) {
        if (word.includes('Title')) {
            skip = true;
            continue;
        } else if (word.includes('Technology') || word.includes('Engineering')) {
            skip = false;
            continue;
        }
        
        if (!skip) {
            cleanedText.push(word);
        }
    }
    
    return cleanedText;
}