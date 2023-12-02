export function cast(target:any, source:any) {
    for (const key in target) {
      if (source.hasOwnProperty(key)) {
        target[key] = source[key];
      }
    }
    return target
} 

export const fadeOut = (el:any) => {
  var opacity = 1; // Initial opacity
  return new Promise( resolve => { var interval = setInterval(function() {
     if (opacity > 0) {
        opacity -= 0.1;
        el.style.opacity = opacity;
     } else {
        clearInterval(interval); // Stop the interval when opacity reaches 0
        el.style.display = 'none'; // Hide the element
        resolve(5);
     }
  }, 50)
  });
}

export const fadeIn = (element:any) => {
  element.style.opacity = 0;
  element.style.display = 'flex';

  let opacity = 0;
  const interval = setInterval(function () {
      opacity += 0.1;
      element.style.opacity = opacity;

      if (opacity >= 1) {
      clearInterval(interval);
      }
  }, 50);
}

export const printDoc = (id:string) => {
  // Get HTML to print from element
    const prtHtml = document.getElementById(id)?.innerHTML;

    // Get all stylesheets HTML
    let stylesHtml = '';
    for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
    stylesHtml += node.outerHTML;
    }

    // Open the print window
    const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

    WinPrint?.document.write(`<!DOCTYPE html>
    <html>
    <head>
        ${stylesHtml}
    </head>
    <body>
        ${prtHtml}
    </body>
    </html>`);

    setTimeout(() => {
        WinPrint?.document.close()
        WinPrint?.focus();
        WinPrint?.print();
        WinPrint?.close();
    }, 500);
    
}