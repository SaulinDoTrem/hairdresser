import { readFileAsText } from "./readFile";

export const importHtmlTags = async () => {
    const pageIconLink = document.createElement("link");

    pageIconLink.rel = "icon";
    pageIconLink.href = "./assets/imgs/hairdresser-icon.png";

    const cssImport = document.createElement("link");

    cssImport.rel = "stylesheet";
    cssImport.href = "./main.css";

    const pageTitle = document.createElement("title");

    pageTitle.text = "Hairdresser";

    [cssImport, pageIconLink, pageTitle].forEach((e) => document.head.appendChild(e));

    const fileDirectory = "./partials";

    [`${fileDirectory}/header.html`, `${fileDirectory}/footer.html`].forEach((filePath) =>
        readFileAsText(buildHtmlBody, filePath)
    );
};

const buildHtmlBody = (fileText, fileName) => {
    const element = document.createElement(fileName);
    element.innerHTML = fileText.split(`<${fileName}>`)[1].split(`</${fileName}>`)[0];

    switch (fileName) {
        case "footer":
            {
                const [beforeMain, afterMain] = document.body.innerHTML.split("</main>");
                document.body.innerHTML = `${beforeMain}</main>${element.outerHTML}${afterMain}`;
            }
            break;
        case "header":
            {
                const [beforeMain, afterMain] = document.body.innerHTML.split("<main>");
                document.body.innerHTML = `${beforeMain}${element.outerHTML}<main>${afterMain}`;
            }
            break;
        default: {
            console.log("Non-know archive.");
        }
    }
};
