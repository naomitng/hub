function handleFileSelect(event) {
    const files = event.target.files;
    if (!files || !files.length) return;

    ['title', 'authors', 'abstract', 'year', 'adviser', 'selectDept', 'keywords'].forEach(elementId => {
        document.getElementById(elementId).value = '';
    });
    

    for (let i = 0; i < files.length; i++) {
        const formData = new FormData();
        formData.append('apikey', 'K87623400388957');
        formData.append('file', files[i]);

        fetch('https://api.ocr.space/parse/image', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.ParsedResults && data.ParsedResults[0] && data.ParsedResults[0].ParsedText) {
                let parsedText = data.ParsedResults[0].ParsedText;

                // EXTRACT YEAR
                const yearRegex = /\b\d{4}\b/;
                const yearMatch = parsedText.match(yearRegex);
                if (yearMatch) {
                    const year = yearMatch[0];
                    document.getElementById('year').value = year;
                }
                // END

                // EXTRACT AUTHORS
                const presentedIndex = parsedText.toLowerCase().indexOf('by');
                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', yearMatch];
                let monthIndex = -1;

                for (let i = 0; i < months.length; i++) {
                    if (parsedText.indexOf(months[i]) !== -1) {
                        monthIndex = parsedText.indexOf(months[i]);
                        break;
                    }
                }

                if (presentedIndex !== -1 && monthIndex !== -1) {
                    let authorsText = parsedText.substring(presentedIndex + 'by'.length, monthIndex).trim();
                    authorsText = authorsText.replace(':', '');
                    document.getElementById('authors').value += authorsText + '\n'; 
                }

                // END

                // Extract ABSTRACT
                const abstractIndex = parsedText.indexOf('ABSTRACT');
                if (abstractIndex !== -1) {
                    const abstractText = parsedText.substring(abstractIndex + 'ABSTRACT'.length).trim();
                    const lastIndex = abstractText.lastIndexOf('\n');
                    if (lastIndex !== -1) {
                        parsedText = abstractText.substring(0, lastIndex).trim();
                    }
                    parsedText = parsedText.replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
                    document.getElementById('abstract').value += parsedText + '\n'; 
                }
                // END

                // Extract TITLE
                const titleIndex = parsedText.indexOf('TECHNOLOGY');
                const titleIndex1 = parsedText.indexOf('ARCHITECTURE');
                const titleIndex2 = parsedText.indexOf('ENGINEERING');
                const capstoneIndex = parsedText.indexOf('A Capstone');

                if (titleIndex !== -1 && capstoneIndex !== -1) {
                    let titleText = parsedText.substring(titleIndex, capstoneIndex).trim();
                    titleText = titleText.replace('TECHNOLOGY', '').trim();
                    document.getElementById('title').value += titleText + '\n'; 
                }
                
                else if (titleIndex1 !== -1 && capstoneIndex !== -1) {
                    let titleText = parsedText.substring(titleIndex1, capstoneIndex).trim();
                    titleText = titleText.replace('ARCHITECTURE', '').trim();
                    document.getElementById('title').value += titleText + '\n'; 
                }
                
                else if (titleIndex2 !== -1 && capstoneIndex !== -1) {
                    let titleText = parsedText.substring(titleIndex2, capstoneIndex).trim();
                    titleText = titleText.replace('ENGINEERING', '').trim();
                    document.getElementById('title').value += titleText + '\n';
                }
                // END
            }
        })
    }
}

document.getElementById('formFile').addEventListener('change', handleFileSelect);
