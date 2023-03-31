const bold = document.querySelector('button.bold');
const cursive = document.querySelector('button.cursive');
const underline = document.querySelector('button.underline');
const textEditor = document.querySelector('div.textEditor');

bold.onclick = () => {
    styleText(tag = 'b');    
}

cursive.onclick = () => {
    styleText(tag = 'i'); 
}

underline.onclick = () => {
    styleText(tag = 'u');
}




function styleText(tag) {
   const selection = window.getSelection();
   if (selection && selection.toString().length > 0) {
        let parentEl = selection.getRangeAt(0).commonAncestorContainer.parentElement;
            if (parentEl.tagName == 'DIV') {
    
                const span = document.createElement(tag);
                const range = selection.getRangeAt(0);
                
                range.surroundContents(span);
                window.getSelection().removeAllRanges();
            } else {
                     if (parentEl.tagName.toLocaleUpperCase() === tag.toLocaleUpperCase()) {
                we
                     } else {
                        const span = document.createElement(tag);
                        
                        const range = selection.getRangeAt(0);

                        range.surroundContents(span);
                        window.getSelection().removeAllRanges();        
                     }

            }
    } 
    
}

function uninstallOptionText() {
    const selection = window.getSelection();
        const span = document.createElement('span');
        span.style.fontWeight = 'normal';
        const range = selection.getRangeAt(0);
        range.surroundContents(span);
}

function installOptionText() {
    const selection = window.getSelection();
        const span = document.createElement('b');
        span.style.fontWeight = 'bold';
        const range = selection.getRangeAt(0);
        range.surroundContents(span);

}